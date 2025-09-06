<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Company;
use App\Models\Contact;
use App\Models\DealStage;
use App\Models\DealSource;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Deal::with(['company', 'contact', 'assignedUser', 'dealStage', 'dealSource']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('company', function ($companyQuery) use ($search) {
                      $companyQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by stage
        if ($request->has('stage') && $request->stage) {
            $query->where('deal_stage_id', $request->stage);
        }

        // Filter by assigned user
        if ($request->has('assigned_user') && $request->assigned_user) {
            $query->where('assigned_user_id', $request->assigned_user);
        }

        // Filter by value range
        if ($request->has('min_value') && $request->min_value) {
            $query->where('deal_value', '>=', $request->min_value);
        }
        if ($request->has('max_value') && $request->max_value) {
            $query->where('deal_value', '<=', $request->max_value);
        }

        // Filter by close date
        if ($request->has('close_date_from') && $request->close_date_from) {
            $query->where('expected_close_date', '>=', $request->close_date_from);
        }
        if ($request->has('close_date_to') && $request->close_date_to) {
            $query->where('expected_close_date', '<=', $request->close_date_to);
        }

        $deals = $query->latest()->paginate(15);

        $dealStages = DealStage::orderBy('order')->get();
        $users = User::all();

        return view('deals.index', compact('deals', 'dealStages', 'users'));
    }

    /**
     * Display pipeline view
     */
    public function pipeline()
    {
        $stages = DealStage::with(['deals' => function ($query) {
            $query->with(['company', 'assignedUser'])
                  ->where('is_won', false)
                  ->orderBy('deal_value', 'desc');
        }])->orderBy('order')->get();

        $totalPipelineValue = Deal::where('is_won', false)->sum('deal_value');
        $averageDealSize = Deal::where('is_won', false)->avg('deal_value');

        return view('deals.pipeline', compact('stages', 'totalPipelineValue', 'averageDealSize'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $contacts = Contact::with('company')->orderBy('first_name')->get();
        $dealStages = DealStage::orderBy('order')->get();
        $dealSources = DealSource::orderBy('name')->get();
        $users = User::all();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('deals.create', compact('companies', 'contacts', 'dealStages', 'dealSources', 'users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'deal_stage_id' => 'required|exists:deal_stages,id',
            'deal_value' => 'required|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date|after:today',
            'deal_source_id' => 'nullable|exists:deal_sources,id',
            'competitor_info' => 'nullable|string',
            'description' => 'nullable|string',
            'products' => 'nullable|array',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array'
        ]);

        $validated['assigned_user_id'] = $validated['assigned_user_id'] ?? Auth::id();
        
        // Calculate total amount
        $subtotal = $validated['deal_value'];
        $discount = $subtotal * (($validated['discount_percentage'] ?? 0) / 100);
        $taxAmount = $validated['tax_amount'] ?? 0;
        $validated['total_amount'] = $subtotal - $discount + $taxAmount;

        $deal = Deal::create($validated);

        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal)
    {
        $deal->load(['company', 'contact', 'assignedUser', 'dealStage', 'dealSource', 'activities']);
        
        return view('deals.show', compact('deal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        $companies = Company::orderBy('name')->get();
        $contacts = Contact::with('company')->orderBy('first_name')->get();
        $dealStages = DealStage::orderBy('order')->get();
        $dealSources = DealSource::orderBy('name')->get();
        $users = User::all();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('deals.edit', compact('deal', 'companies', 'contacts', 'dealStages', 'dealSources', 'users', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'deal_stage_id' => 'required|exists:deal_stages,id',
            'deal_value' => 'required|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date|after:today',
            'deal_source_id' => 'nullable|exists:deal_sources,id',
            'competitor_info' => 'nullable|string',
            'description' => 'nullable|string',
            'products' => 'nullable|array',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array'
        ]);
        
        // Calculate total amount
        $subtotal = $validated['deal_value'];
        $discount = $subtotal * (($validated['discount_percentage'] ?? 0) / 100);
        $taxAmount = $validated['tax_amount'] ?? 0;
        $validated['total_amount'] = $subtotal - $discount + $taxAmount;

        $deal->update($validated);

        return redirect()->route('deals.index')->with('success', 'Deal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        $deal->delete();

        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully.');
    }

    /**
     * Mark deal as won
     */
    public function markAsWon(Deal $deal)
    {
        $deal->update([
            'is_won' => true,
            'actual_close_date' => now(),
            'probability' => 100
        ]);

        return back()->with('success', 'Deal marked as won successfully.');
    }

    /**
     * Mark deal as lost
     */
    public function markAsLost(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'lost_reason' => 'required|string|max:255'
        ]);

        $deal->update([
            'is_won' => false,
            'actual_close_date' => now(),
            'probability' => 0,
            'lost_reason' => $validated['lost_reason']
        ]);

        return back()->with('success', 'Deal marked as lost.');
    }

    /**
     * Update deal stage (for AJAX requests)
     */
    public function updateStage(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'deal_stage_id' => 'required|exists:deal_stages,id'
        ]);

        $deal->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Deal stage updated successfully.'
        ]);
    }
}
