<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Lead;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Activity::with(['assignedUser', 'completedBy']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_completed', $request->status);
        }

        // Filter by assigned user
        if ($request->has('assigned_user') && $request->assigned_user) {
            $query->where('assigned_user_id', $request->assigned_user);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        // Filter by due date
        if ($request->has('due_date_from') && $request->due_date_from) {
            $query->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->has('due_date_to') && $request->due_date_to) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        $activities = $query->latest('due_date')->paginate(15);

        $users = User::all();
        $activityTypes = ['call', 'email', 'meeting', 'task', 'note'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        return view('activities.index', compact('activities', 'users', 'activityTypes', 'priorities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $users = User::all();
        $activityTypes = ['call', 'email', 'meeting', 'task', 'note'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $relatedTypes = ['lead', 'contact', 'company', 'deal'];

        // Pre-populate if related entity is specified
        $relatedTo = null;
        $relatedToId = null;
        $relatedToType = null;

        if ($request->has('related_to') && $request->has('related_id')) {
            $relatedToType = $request->related_to;
            $relatedToId = $request->related_id;

            switch ($relatedToType) {
                case 'lead':
                    $relatedTo = Lead::find($relatedToId);
                    break;
                case 'contact':
                    $relatedTo = Contact::find($relatedToId);
                    break;
                case 'company':
                    $relatedTo = Company::find($relatedToId);
                    break;
                case 'deal':
                    $relatedTo = Deal::find($relatedToId);
                    break;
            }
        }

        return view('activities.create', compact('users', 'activityTypes', 'priorities', 'relatedTypes', 'relatedTo', 'relatedToId', 'relatedToType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:call,email,meeting,task,note',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'duration_minutes' => 'nullable|integer|min:0',
            'related_to_type' => 'required|in:lead,contact,company,deal',
            'related_to_id' => 'required|integer',
            'assigned_user_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'location' => 'nullable|string|max:255',
            'attendees' => 'nullable|array',
            'is_billable' => 'boolean',
            'billable_hours' => 'nullable|numeric|min:0'
        ]);

        // Validate related entity exists
        $this->validateRelatedEntity($validated['related_to_type'], $validated['related_to_id']);

        $validated['assigned_user_id'] = $validated['assigned_user_id'] ?? Auth::id();

        // Combine due_date and due_time if provided
        if (isset($validated['due_time'])) {
            $validated['due_date'] = $validated['due_date'] . ' ' . $validated['due_time'];
        }

        $activity = Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $activity->load(['assignedUser', 'completedBy']);
        
        // Load the related entity
        $relatedEntity = $this->getRelatedEntity($activity->related_to_type, $activity->related_to_id);
        
        return view('activities.show', compact('activity', 'relatedEntity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $users = User::all();
        $activityTypes = ['call', 'email', 'meeting', 'task', 'note'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $relatedTypes = ['lead', 'contact', 'company', 'deal'];

        // Load the related entity
        $relatedEntity = $this->getRelatedEntity($activity->related_to_type, $activity->related_to_id);

        return view('activities.edit', compact('activity', 'users', 'activityTypes', 'priorities', 'relatedTypes', 'relatedEntity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'type' => 'required|in:call,email,meeting,task,note',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'duration_minutes' => 'nullable|integer|min:0',
            'related_to_type' => 'required|in:lead,contact,company,deal',
            'related_to_id' => 'required|integer',
            'assigned_user_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'location' => 'nullable|string|max:255',
            'attendees' => 'nullable|array',
            'outcome' => 'nullable|string',
            'next_action' => 'nullable|string|max:255',
            'is_billable' => 'boolean',
            'billable_hours' => 'nullable|numeric|min:0'
        ]);

        // Validate related entity exists
        $this->validateRelatedEntity($validated['related_to_type'], $validated['related_to_id']);

        // Combine due_date and due_time if provided
        if (isset($validated['due_time'])) {
            $validated['due_date'] = $validated['due_date'] . ' ' . $validated['due_time'];
        }

        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }

    /**
     * Mark activity as complete
     */
    public function complete(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'outcome' => 'nullable|string',
            'next_action' => 'nullable|string|max:255',
            'billable_hours' => 'nullable|numeric|min:0'
        ]);

        $activity->update([
            'is_completed' => true,
            'completed_at' => now(),
            'completed_by_user_id' => Auth::id(),
            'outcome' => $validated['outcome'] ?? $activity->outcome,
            'next_action' => $validated['next_action'] ?? $activity->next_action,
            'billable_hours' => $validated['billable_hours'] ?? $activity->billable_hours
        ]);

        return back()->with('success', 'Activity marked as completed.');
    }

    /**
     * Get calendar view of activities
     */
    public function calendar()
    {
        $activities = Activity::with(['assignedUser'])
            ->where('assigned_user_id', Auth::id())
            ->whereDate('due_date', '>=', now()->startOfMonth())
            ->whereDate('due_date', '<=', now()->endOfMonth())
            ->get();

        return view('activities.calendar', compact('activities'));
    }

    /**
     * Validate that the related entity exists
     */
    private function validateRelatedEntity($type, $id)
    {
        switch ($type) {
            case 'lead':
                if (!Lead::find($id)) {
                    throw new \InvalidArgumentException('Lead not found');
                }
                break;
            case 'contact':
                if (!Contact::find($id)) {
                    throw new \InvalidArgumentException('Contact not found');
                }
                break;
            case 'company':
                if (!Company::find($id)) {
                    throw new \InvalidArgumentException('Company not found');
                }
                break;
            case 'deal':
                if (!Deal::find($id)) {
                    throw new \InvalidArgumentException('Deal not found');
                }
                break;
        }
    }

    /**
     * Get the related entity
     */
    private function getRelatedEntity($type, $id)
    {
        switch ($type) {
            case 'lead':
                return Lead::find($id);
            case 'contact':
                return Contact::find($id);
            case 'company':
                return Company::find($id);
            case 'deal':
                return Deal::find($id);
            default:
                return null;
        }
    }
}
