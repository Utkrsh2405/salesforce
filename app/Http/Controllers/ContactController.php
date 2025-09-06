<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::with(['company', 'assignedUser']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%")
                  ->orWhereHas('company', function ($companyQuery) use ($search) {
                      $companyQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by company
        if ($request->has('company') && $request->company) {
            $query->where('company_id', $request->company);
        }

        // Filter by assigned user
        if ($request->has('assigned_user') && $request->assigned_user) {
            $query->where('assigned_user_id', $request->assigned_user);
        }

        $contacts = $query->latest()->paginate(15);

        $companies = Company::orderBy('name')->get();
        $users = User::all();

        return view('contacts.index', compact('contacts', 'companies', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $users = User::all();

        return view('contacts.create', compact('companies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'nullable|exists:companies,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:100',
            'mobile' => 'nullable|string|max:100',
            'direct_phone' => 'nullable|string|max:20',
            'assistant_name' => 'nullable|string|max:100',
            'assistant_phone' => 'nullable|string|max:100',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|array',
            'social_profiles' => 'nullable|array',
            'communication_preferences' => 'nullable|array',
            'assigned_user_id' => 'nullable|exists:users,id',
            'is_primary_contact' => 'boolean',
            'lead_score' => 'nullable|integer|min:0|max:100',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array'
        ]);

        $validated['assigned_user_id'] = $validated['assigned_user_id'] ?? Auth::id();

        $contact = Contact::create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact->load(['company', 'assignedUser', 'deals', 'activities']);
        
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $companies = Company::orderBy('name')->get();
        $users = User::all();

        return view('contacts.edit', compact('contact', 'companies', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'company_id' => 'nullable|exists:companies,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:100',
            'mobile' => 'nullable|string|max:100',
            'direct_phone' => 'nullable|string|max:20',
            'assistant_name' => 'nullable|string|max:100',
            'assistant_phone' => 'nullable|string|max:100',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|array',
            'social_profiles' => 'nullable|array',
            'communication_preferences' => 'nullable|array',
            'assigned_user_id' => 'nullable|exists:users,id',
            'is_primary_contact' => 'boolean',
            'lead_score' => 'nullable|integer|min:0|max:100',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array'
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
