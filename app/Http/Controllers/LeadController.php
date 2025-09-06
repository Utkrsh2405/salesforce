<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lead::with(['leadSource', 'leadStatus', 'assignedUser', 'industry']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('lead_status_id', $request->status);
        }

        // Filter by source
        if ($request->has('source') && $request->source) {
            $query->where('lead_source_id', $request->source);
        }

        // Filter by assigned user
        if ($request->has('assigned_user') && $request->assigned_user) {
            $query->where('assigned_user_id', $request->assigned_user);
        }

        $leads = $query->latest()->paginate(15);

        $leadSources = LeadSource::all();
        $leadStatuses = LeadStatus::all();
        $users = User::all();

        return view('leads.index', compact('leads', 'leadSources', 'leadStatuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leadSources = LeadSource::all();
        $leadStatuses = LeadStatus::all();
        $industries = Industry::all();
        $users = User::all();

        return view('leads.create', compact('leadSources', 'leadStatuses', 'industries', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'lead_source_id' => 'required|exists:lead_sources,id',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'industry_id' => 'nullable|exists:industries,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'estimated_value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date|after:today',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-1000,1000+',
            'budget_range' => 'nullable|string|max:50',
            'pain_points' => 'nullable|string',
            'decision_makers' => 'nullable|array',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array'
        ]);

        $validated['assigned_user_id'] = $validated['assigned_user_id'] ?? Auth::id();
        $validated['lead_score'] = $this->calculateLeadScore($validated);

        $lead = Lead::create($validated);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        $lead->load(['leadSource', 'leadStatus', 'assignedUser', 'industry', 'activities']);
        
        return view('leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        $leadSources = LeadSource::all();
        $leadStatuses = LeadStatus::all();
        $industries = Industry::all();
        $users = User::all();

        return view('leads.edit', compact('lead', 'leadSources', 'leadStatuses', 'industries', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'lead_source_id' => 'required|exists:lead_sources,id',
            'lead_status_id' => 'required|exists:lead_statuses,id',
            'industry_id' => 'nullable|exists:industries,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'estimated_value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date|after:today',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-1000,1000+',
            'budget_range' => 'nullable|string|max:50',
            'pain_points' => 'nullable|string',
            'decision_makers' => 'nullable|array',
            'tags' => 'nullable|array',
            'custom_fields' => 'nullable|array'
        ]);

        $validated['lead_score'] = $this->calculateLeadScore($validated);

        $lead->update($validated);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    /**
     * Show convert form
     */
    public function showConvertForm(Lead $lead)
    {
        $dealStages = \App\Models\DealStage::orderBy('order')->get();
        
        return view('leads.convert', compact('lead', 'dealStages'));
    }

    /**
     * Convert lead to deal
     */
    public function convert(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'deal_title' => 'required|string|max:255',
            'deal_value' => 'required|numeric|min:0',
            'deal_stage_id' => 'required|exists:deal_stages,id',
            'expected_close_date' => 'nullable|date|after:today',
            'create_company' => 'boolean',
            'create_contact' => 'boolean'
        ]);

        $company = null;
        $contact = null;

        // Create company if requested
        if ($validated['create_company']) {
            $company = Company::create([
                'name' => $lead->company_name,
                'industry_id' => $lead->industry_id,
                'assigned_user_id' => $lead->assigned_user_id,
                'source_id' => $lead->lead_source_id,
                'is_client' => true
            ]);
        }

        // Create contact if requested
        if ($validated['create_contact']) {
            [$firstName, $lastName] = $this->parseFullName($lead->contact_name);
            
            $contact = Contact::create([
                'company_id' => $company ? $company->id : null,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'job_title' => $lead->job_title,
                'assigned_user_id' => $lead->assigned_user_id,
                'is_primary_contact' => true,
                'lead_score' => $lead->lead_score
            ]);
        }

        // Create deal
        $deal = Deal::create([
            'title' => $validated['deal_title'],
            'company_id' => $company ? $company->id : null,
            'contact_id' => $contact ? $contact->id : null,
            'assigned_user_id' => $lead->assigned_user_id,
            'deal_stage_id' => $validated['deal_stage_id'],
            'deal_value' => $validated['deal_value'],
            'probability' => $lead->probability,
            'expected_close_date' => $validated['expected_close_date'],
            'description' => $lead->pain_points,
            'tags' => $lead->tags,
            'custom_fields' => $lead->custom_fields
        ]);

        // Mark lead as converted
        $lead->update([
            'conversion_date' => now(),
            'lead_status_id' => LeadStatus::where('name', 'Converted')->first()?->id
        ]);

        return redirect()->route('deals.show', $deal)->with('success', 'Lead converted to deal successfully.');
    }

    /**
     * Calculate lead score based on various factors
     */
    private function calculateLeadScore(array $data)
    {
        $score = 0;

        // Company size scoring
        if (isset($data['company_size'])) {
            $companyScores = [
                '1-10' => 10,
                '11-50' => 20,
                '51-200' => 30,
                '201-1000' => 40,
                '1000+' => 50
            ];
            $score += $companyScores[$data['company_size']] ?? 0;
        }

        // Budget range scoring
        if (isset($data['estimated_value']) && $data['estimated_value']) {
            if ($data['estimated_value'] > 100000) $score += 30;
            elseif ($data['estimated_value'] > 50000) $score += 20;
            elseif ($data['estimated_value'] > 10000) $score += 10;
            else $score += 5;
        }

        // Email provided scoring
        if (isset($data['email']) && $data['email']) {
            $score += 10;
        }

        // Phone provided scoring
        if (isset($data['phone']) && $data['phone']) {
            $score += 10;
        }

        // Job title scoring (decision makers get higher scores)
        if (isset($data['job_title'])) {
            $decisionMakerTitles = ['ceo', 'cto', 'cfo', 'president', 'director', 'manager', 'head'];
            $title = strtolower($data['job_title']);
            foreach ($decisionMakerTitles as $dmTitle) {
                if (strpos($title, $dmTitle) !== false) {
                    $score += 15;
                    break;
                }
            }
        }

        return min($score, 100); // Cap at 100
    }

    /**
     * Parse full name into first and last name
     */
    private function parseFullName($fullName)
    {
        $parts = explode(' ', trim($fullName), 2);
        $firstName = $parts[0] ?? '';
        $lastName = $parts[1] ?? '';
        
        return [$firstName, $lastName];
    }
}
