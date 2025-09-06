@extends('layouts.app')

@section('title', 'Lead Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Lead Information Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $lead->company_name }}</h5>
                    <div class="d-flex gap-2">
                        @if(!$lead->converted_to_deal)
                            <a href="{{ route('leads.convert', $lead) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-exchange-alt"></i> Convert to Deal
                            </a>
                        @else
                            <span class="badge bg-success">Converted</span>
                        @endif
                        <a href="{{ route('leads.edit', $lead) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Contact Information</h6>
                            <div class="mb-2">
                                <strong>Contact Name:</strong> {{ $lead->contact_name }}
                            </div>
                            @if($lead->job_title)
                                <div class="mb-2">
                                    <strong>Job Title:</strong> {{ $lead->job_title }}
                                </div>
                            @endif
                            @if($lead->email)
                                <div class="mb-2">
                                    <strong>Email:</strong> 
                                    <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a>
                                </div>
                            @endif
                            @if($lead->phone)
                                <div class="mb-2">
                                    <strong>Phone:</strong> 
                                    <a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Lead Details</h6>
                            <div class="mb-2">
                                <strong>Source:</strong> {{ $lead->leadSource->name ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <strong>Status:</strong> 
                                <span class="badge bg-primary">{{ $lead->leadStatus->name ?? 'N/A' }}</span>
                            </div>
                            @if($lead->industry)
                                <div class="mb-2">
                                    <strong>Industry:</strong> {{ $lead->industry->name }}
                                </div>
                            @endif
                            @if($lead->company_size)
                                <div class="mb-2">
                                    <strong>Company Size:</strong> {{ $lead->company_size }} employees
                                </div>
                            @endif
                            @if($lead->assignedUser)
                                <div class="mb-2">
                                    <strong>Assigned To:</strong> {{ $lead->assignedUser->name }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($lead->estimated_value || $lead->probability || $lead->expected_close_date || $lead->budget_range)
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Financial Information</h6>
                                @if($lead->estimated_value)
                                    <div class="mb-2">
                                        <strong>Estimated Value:</strong> ${{ number_format($lead->estimated_value, 2) }}
                                    </div>
                                @endif
                                @if($lead->probability)
                                    <div class="mb-2">
                                        <strong>Probability:</strong> {{ $lead->probability }}%
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Timeline</h6>
                                @if($lead->expected_close_date)
                                    <div class="mb-2">
                                        <strong>Expected Close:</strong> {{ $lead->expected_close_date->format('M j, Y') }}
                                    </div>
                                @endif
                                @if($lead->budget_range)
                                    <div class="mb-2">
                                        <strong>Budget Range:</strong> {{ $lead->budget_range }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($lead->pain_points)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">Pain Points / Notes</h6>
                                <p>{{ $lead->pain_points }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activities Timeline -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Activities Timeline</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                        <i class="fas fa-plus"></i> Add Activity
                    </button>
                </div>
                <div class="card-body">
                    @if($lead->activities->count() > 0)
                        <div class="timeline">
                            @foreach($lead->activities->sortByDesc('created_at') as $activity)
                                <div class="timeline-item d-flex mb-3">
                                    <div class="timeline-marker me-3">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 32px; height: 32px;">
                                            <i class="fas fa-{{ $activity->type === 'call' ? 'phone' : ($activity->type === 'email' ? 'envelope' : 'calendar') }} text-white" style="font-size: 12px;"></i>
                                        </div>
                                    </div>
                                    <div class="timeline-content flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ ucfirst($activity->type) }}: {{ $activity->subject }}</h6>
                                                <p class="mb-1 text-muted">{{ $activity->description }}</p>
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> {{ $activity->user->name ?? 'Unknown' }} • 
                                                    <i class="fas fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            @if($activity->completed)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No activities recorded yet.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                Add First Activity
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Lead Score Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Lead Score</h6>
                </div>
                <div class="card-body text-center">
                    <div class="lead-score-circle mb-3" style="
                        width: 100px; 
                        height: 100px; 
                        border-radius: 50%; 
                        background: linear-gradient(135deg, 
                            {{ $lead->score >= 80 ? '#28a745' : ($lead->score >= 60 ? '#ffc107' : '#dc3545') }} 0%, 
                            {{ $lead->score >= 80 ? '#20c997' : ($lead->score >= 60 ? '#fd7e14' : '#e83e8c') }} 100%
                        );
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto;
                        color: white;
                        font-size: 32px;
                        font-weight: bold;
                    ">
                        {{ $lead->score ?? 0 }}
                    </div>
                    <div class="mb-2">
                        <strong>
                            @if(($lead->score ?? 0) >= 80)
                                Hot Lead
                            @elseif(($lead->score ?? 0) >= 60)
                                Warm Lead
                            @else
                                Cold Lead
                            @endif
                        </strong>
                    </div>
                    <small class="text-muted">
                        Score based on engagement, fit, and behavior
                    </small>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Created:</span>
                        <span class="fw-semibold">{{ $lead->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Days Active:</span>
                        <span class="fw-semibold">{{ $lead->created_at->diffInDays() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Activities:</span>
                        <span class="fw-semibold">{{ $lead->activities->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Last Activity:</span>
                        <span class="fw-semibold">
                            {{ $lead->last_activity_date ? $lead->last_activity_date->diffForHumans() : 'None' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($lead->email)
                            <a href="mailto:{{ $lead->email }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-envelope"></i> Send Email
                            </a>
                        @endif
                        @if($lead->phone)
                            <a href="tel:{{ $lead->phone }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-phone"></i> Call
                            </a>
                        @endif
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                            <i class="fas fa-calendar-plus"></i> Schedule Activity
                        </button>
                        @if(!$lead->converted_to_deal)
                            <a href="{{ route('leads.convert', $lead) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-exchange-alt"></i> Convert to Deal
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Activity Modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('activities.store') }}" method="POST">
                @csrf
                <input type="hidden" name="subject_type" value="App\Models\Lead">
                <input type="hidden" name="subject_id" value="{{ $lead->id }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Activity Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="call">Phone Call</option>
                            <option value="email">Email</option>
                            <option value="meeting">Meeting</option>
                            <option value="task">Task</option>
                            <option value="note">Note</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="datetime-local" class="form-control" id="due_date" name="due_date">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
