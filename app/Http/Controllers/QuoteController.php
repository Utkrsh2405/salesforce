<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::with(['company', 'contact', 'deal', 'quoteItems']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('quote_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('company', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $quotes = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate stats
        $stats = [
            'total_value' => Quote::sum('total_amount'),
            'sent_count' => Quote::where('status', 'sent')->count(),
            'pending_count' => Quote::where('status', 'draft')->count(),
            'accepted_count' => Quote::where('status', 'accepted')->count(),
        ];

        $companies = Company::orderBy('name')->get(['id', 'name']);

        return view('quotes.index', compact('quotes', 'stats', 'companies'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get(['id', 'name']);
        $contacts = Contact::with('company')->orderBy('first_name')->get();
        $deals = Deal::with('company')->orderBy('name')->get();
        $products = Product::where('status', 'active')->orderBy('name')->get();

        return view('quotes.create', compact('companies', 'contacts', 'deals', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quote_number' => 'required|unique:quotes',
            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'deal_id' => 'nullable|exists:deals,id',
            'valid_until' => 'nullable|date',
            'status' => 'required|in:draft,sent',
            'terms_and_conditions' => 'nullable|string',
            'notes' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'subtotal_amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $quote = Quote::create([
            'quote_number' => $validated['quote_number'],
            'company_id' => $validated['company_id'],
            'contact_id' => $validated['contact_id'],
            'deal_id' => $validated['deal_id'],
            'user_id' => auth()->id(),
            'valid_until' => $validated['valid_until'],
            'status' => $request->input('action') === 'save_and_send' ? 'sent' : 'draft',
            'terms_and_conditions' => $validated['terms_and_conditions'],
            'notes' => $validated['notes'],
            'tax_rate' => $validated['tax_rate'] ?? 0,
            'subtotal_amount' => $validated['subtotal_amount'],
            'tax_amount' => $validated['tax_amount'],
            'total_amount' => $validated['total_amount'],
        ]);

        // Create quote items
        foreach ($validated['items'] as $item) {
            $quantity = $item['quantity'];
            $unitPrice = $item['unit_price'];
            $discountPercent = $item['discount_percent'] ?? 0;
            
            $lineTotal = $quantity * $unitPrice;
            $discountAmount = $lineTotal * ($discountPercent / 100);
            $totalPrice = $lineTotal - $discountAmount;

            QuoteItem::create([
                'quote_id' => $quote->id,
                'product_id' => $item['product_id'],
                'description' => $item['description'],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'discount_percent' => $discountPercent,
                'discount_amount' => $discountAmount,
                'total_price' => $totalPrice,
            ]);
        }

        $message = $request->input('action') === 'save_and_send' 
            ? 'Quote created and sent successfully!' 
            : 'Quote saved as draft successfully!';

        return redirect()->route('quotes.show', $quote)->with('success', $message);
    }

    public function show(Quote $quote)
    {
        $quote->load(['company', 'contact', 'deal', 'user', 'quoteItems.product']);
        
        return view('quotes.show', compact('quote'));
    }

    public function edit(Quote $quote)
    {
        if ($quote->status !== 'draft') {
            return redirect()->route('quotes.show', $quote)
                           ->with('error', 'Only draft quotes can be edited.');
        }

        $quote->load('quoteItems.product');
        $companies = Company::orderBy('name')->get(['id', 'name']);
        $contacts = Contact::with('company')->orderBy('first_name')->get();
        $deals = Deal::with('company')->orderBy('name')->get();
        $products = Product::where('status', 'active')->orderBy('name')->get();

        return view('quotes.edit', compact('quote', 'companies', 'contacts', 'deals', 'products'));
    }

    public function update(Request $request, Quote $quote)
    {
        if ($quote->status !== 'draft') {
            return redirect()->route('quotes.show', $quote)
                           ->with('error', 'Only draft quotes can be updated.');
        }

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'deal_id' => 'nullable|exists:deals,id',
            'valid_until' => 'nullable|date',
            'terms_and_conditions' => 'nullable|string',
            'notes' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'subtotal_amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $quote->update([
            'company_id' => $validated['company_id'],
            'contact_id' => $validated['contact_id'],
            'deal_id' => $validated['deal_id'],
            'valid_until' => $validated['valid_until'],
            'terms_and_conditions' => $validated['terms_and_conditions'],
            'notes' => $validated['notes'],
            'tax_rate' => $validated['tax_rate'] ?? 0,
            'subtotal_amount' => $validated['subtotal_amount'],
            'tax_amount' => $validated['tax_amount'],
            'total_amount' => $validated['total_amount'],
        ]);

        // Delete existing items and recreate
        $quote->quoteItems()->delete();

        foreach ($validated['items'] as $item) {
            $quantity = $item['quantity'];
            $unitPrice = $item['unit_price'];
            $discountPercent = $item['discount_percent'] ?? 0;
            
            $lineTotal = $quantity * $unitPrice;
            $discountAmount = $lineTotal * ($discountPercent / 100);
            $totalPrice = $lineTotal - $discountAmount;

            QuoteItem::create([
                'quote_id' => $quote->id,
                'product_id' => $item['product_id'],
                'description' => $item['description'],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'discount_percent' => $discountPercent,
                'discount_amount' => $discountAmount,
                'total_price' => $totalPrice,
            ]);
        }

        return redirect()->route('quotes.show', $quote)
                        ->with('success', 'Quote updated successfully!');
    }

    public function destroy(Quote $quote)
    {
        if (!in_array($quote->status, ['draft', 'sent'])) {
            return redirect()->route('quotes.index')
                           ->with('error', 'Cannot delete this quote.');
        }

        $quote->delete();
        
        return redirect()->route('quotes.index')
                        ->with('success', 'Quote deleted successfully!');
    }

    public function generatePdf(Quote $quote)
    {
        $quote->load(['company', 'contact', 'deal', 'user', 'quoteItems.product']);
        
        $pdf = Pdf::loadView('quotes.pdf', compact('quote'));
        
        return $pdf->download("quote-{$quote->quote_number}.pdf");
    }

    public function send(Quote $quote)
    {
        if ($quote->status !== 'draft') {
            return redirect()->route('quotes.show', $quote)
                           ->with('error', 'Quote has already been sent.');
        }

        $quote->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // Here you would typically send email notification
        // Mail::to($quote->contact->email)->send(new QuoteSentMail($quote));

        return redirect()->route('quotes.show', $quote)
                        ->with('success', 'Quote sent successfully!');
    }

    public function accept(Quote $quote)
    {
        if ($quote->status !== 'sent') {
            return redirect()->route('quotes.show', $quote)
                           ->with('error', 'Only sent quotes can be accepted.');
        }

        $quote->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        // If quote is linked to a deal, update deal amount
        if ($quote->deal) {
            $quote->deal->update([
                'amount' => $quote->total_amount,
            ]);
        }

        return redirect()->route('quotes.show', $quote)
                        ->with('success', 'Quote marked as accepted!');
    }

    public function reject(Quote $quote)
    {
        if ($quote->status !== 'sent') {
            return redirect()->route('quotes.show', $quote)
                           ->with('error', 'Only sent quotes can be rejected.');
        }

        $quote->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return redirect()->route('quotes.show', $quote)
                        ->with('success', 'Quote marked as rejected.');
    }

    public function duplicate(Quote $quote)
    {
        $newQuote = $quote->replicate();
        $newQuote->quote_number = 'Q-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $newQuote->status = 'draft';
        $newQuote->sent_at = null;
        $newQuote->accepted_at = null;
        $newQuote->rejected_at = null;
        $newQuote->save();

        // Duplicate quote items
        foreach ($quote->quoteItems as $item) {
            $newItem = $item->replicate();
            $newItem->quote_id = $newQuote->id;
            $newItem->save();
        }

        return redirect()->route('quotes.edit', $newQuote)
                        ->with('success', 'Quote duplicated successfully!');
    }
}
