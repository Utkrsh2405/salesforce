<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Industry;
use App\Models\LeadSource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::with(['industry', 'assignedUser']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('legal_name', 'like', "%{$search}%")
                  ->orWhere('website', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by industry
        if ($request->has('industry') && $request->industry) {
            $query->where('industry_id', $request->industry);
        }

        // Filter by company size
        if ($request->has('company_size') && $request->company_size) {
            $query->where('company_size', $request->company_size);
        }

        // Filter by assigned user
        if ($request->has('assigned_user') && $request->assigned_user) {
            $query->where('assigned_user_id', $request->assigned_user);
        }

        // Filter by client status
        if ($request->has('is_client') && $request->is_client !== '') {
            $query->where('is_client', $request->is_client);
        }

        $companies = $query->latest()->paginate(15);

        $industries = Industry::orderBy('name')->get();
        $users = User::all();
        $companySizes = ['1-10', '11-50', '51-200', '201-1000', '1000+'];

        return view('companies.index', compact('companies', 'industries', 'users', 'companySizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = Industry::orderBy('name')->get();
        $leadSources = LeadSource::orderBy('name')->get();
        $users = User::all();
        $companySizes = ['1-10', '11-50', '51-200', '201-1000', '1000+'];

        return view('companies.create', compact('industries', 'leadSources', 'users', 'companySizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:100',
            'phone' => 'nullable|string|max:100',
            'fax' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'industry_id' => 'nullable|exists:industries,id',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-1000,1000+',
            'annual_revenue' => 'nullable|numeric|min:0',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'billing_address' => 'nullable|array',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'social_media_links' => 'nullable|array',
            'assigned_user_id' => 'nullable|exists:users,id',
            'source_id' => 'nullable|exists:lead_sources,id',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array',
            'is_client' => 'boolean'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $validated['assigned_user_id'] = $validated['assigned_user_id'] ?? Auth::id();

        $company = Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load(['industry', 'assignedUser', 'source', 'contacts', 'deals', 'activities']);
        
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $industries = Industry::orderBy('name')->get();
        $leadSources = LeadSource::orderBy('name')->get();
        $users = User::all();
        $companySizes = ['1-10', '11-50', '51-200', '201-1000', '1000+'];

        return view('companies.edit', compact('company', 'industries', 'leadSources', 'users', 'companySizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:100',
            'phone' => 'nullable|string|max:100',
            'fax' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'industry_id' => 'nullable|exists:industries,id',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-1000,1000+',
            'annual_revenue' => 'nullable|numeric|min:0',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'billing_address' => 'nullable|array',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'social_media_links' => 'nullable|array',
            'assigned_user_id' => 'nullable|exists:users,id',
            'source_id' => 'nullable|exists:lead_sources,id',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array',
            'is_client' => 'boolean'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                \Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Delete logo if exists
        if ($company->logo) {
            \Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
