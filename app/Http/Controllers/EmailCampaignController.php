<?php

namespace App\Http\Controllers;

use App\Models\EmailCampaign;
use App\Models\Contact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EmailCampaign::with('createdBy');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $campaigns = $query->latest()->paginate(15);

        return view('email-campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('email-campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'reply_to_email' => 'nullable|email|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,scheduled,sending,sent,paused',
            'scheduled_at' => 'nullable|date|after:now',
            'segment_criteria' => 'nullable|array',
            'a_b_test_config' => 'nullable|array'
        ]);

        $validated['created_by_user_id'] = Auth::id();

        $campaign = EmailCampaign::create($validated);

        return redirect()->route('email-campaigns.index')->with('success', 'Email campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailCampaign $emailCampaign)
    {
        $emailCampaign->load('createdBy');
        
        return view('email-campaigns.show', compact('emailCampaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailCampaign $emailCampaign)
    {
        return view('email-campaigns.edit', compact('emailCampaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailCampaign $emailCampaign)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'reply_to_email' => 'nullable|email|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,scheduled,sending,sent,paused',
            'scheduled_at' => 'nullable|date|after:now',
            'segment_criteria' => 'nullable|array',
            'a_b_test_config' => 'nullable|array'
        ]);

        $emailCampaign->update($validated);

        return redirect()->route('email-campaigns.index')->with('success', 'Email campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailCampaign $emailCampaign)
    {
        // Only allow deletion of draft campaigns
        if ($emailCampaign->status !== 'draft') {
            return back()->with('error', 'Only draft campaigns can be deleted.');
        }

        $emailCampaign->delete();

        return redirect()->route('email-campaigns.index')->with('success', 'Email campaign deleted successfully.');
    }

    /**
     * Send the email campaign
     */
    public function send(EmailCampaign $emailCampaign)
    {
        if ($emailCampaign->status !== 'draft') {
            return back()->with('error', 'Only draft campaigns can be sent.');
        }

        // Get recipients based on segment criteria
        $recipients = $this->getRecipients($emailCampaign->segment_criteria);

        $emailCampaign->update([
            'status' => 'sent',
            'sent_at' => now(),
            'recipient_count' => $recipients->count()
        ]);

        // Here you would integrate with your email service provider
        // For now, we'll just mark it as sent

        return back()->with('success', 'Email campaign sent successfully to ' . $recipients->count() . ' recipients.');
    }

    /**
     * Schedule the email campaign
     */
    public function schedule(Request $request, EmailCampaign $emailCampaign)
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now'
        ]);

        $emailCampaign->update([
            'status' => 'scheduled',
            'scheduled_at' => $validated['scheduled_at']
        ]);

        return back()->with('success', 'Email campaign scheduled successfully.');
    }

    /**
     * Get recipients based on segment criteria
     */
    private function getRecipients($segmentCriteria)
    {
        // Default to all contacts and leads with email addresses
        $contacts = Contact::whereNotNull('email')->get();
        $leads = Lead::whereNotNull('email')->get();

        // Apply segment criteria if provided
        if ($segmentCriteria) {
            // This would be expanded based on your segmentation needs
            if (isset($segmentCriteria['include_leads']) && !$segmentCriteria['include_leads']) {
                $leads = collect();
            }
            if (isset($segmentCriteria['include_contacts']) && !$segmentCriteria['include_contacts']) {
                $contacts = collect();
            }
        }

        return $contacts->merge($leads);
    }
}
