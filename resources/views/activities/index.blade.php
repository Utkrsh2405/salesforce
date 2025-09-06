@extends('layouts.app')

@section('title', 'Activities')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks text-primary"></i> Activities
                    </h5>
                    <a href="{{ route('activities.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Activity
                    </a>
                </div>

                <!-- Filters -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ route('activities.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Search activities...">
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($activityTypes as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="priority" class="form-select">
                                <option value="">All Priorities</option>
                                @foreach($priorities as $priority)
                                    <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="assigned_user" class="form-select">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('assigned_user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    @if($activities->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Subject</th>
                                        <th>Related To</th>
                                        <th>Assigned To</th>
                                        <th>Due Date</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                        <tr class="{{ $activity->is_completed ? 'table-success' : ($activity->due_date < now() ? 'table-warning' : '') }}">
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-{{ $activity->type == 'call' ? 'phone' : ($activity->type == 'email' ? 'envelope' : ($activity->type == 'meeting' ? 'users' : ($activity->type == 'task' ? 'check' : 'sticky-note'))) }}"></i>
                                                    {{ ucfirst($activity->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $activity->subject }}</div>
                                                @if($activity->description)
                                                    <small class="text-muted">{{ Str::limit($activity->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ ucfirst($activity->related_to_type) }}</small><br>
                                                @php
                                                    $relatedEntity = null;
                                                    switch($activity->related_to_type) {
                                                        case 'lead':
                                                            $relatedEntity = \App\Models\Lead::find($activity->related_to_id);
                                                            break;
                                                        case 'contact':
                                                            $relatedEntity = \App\Models\Contact::find($activity->related_to_id);
                                                            break;
                                                        case 'company':
                                                            $relatedEntity = \App\Models\Company::find($activity->related_to_id);
                                                            break;
                                                        case 'deal':
                                                            $relatedEntity = \App\Models\Deal::find($activity->related_to_id);
                                                            break;
                                                    }
                                                @endphp
                                                @if($relatedEntity)
                                                    <span class="fw-medium">
                                                        @if($activity->related_to_type == 'lead')
                                                            {{ $relatedEntity->company_name }}
                                                        @elseif($activity->related_to_type == 'contact')
                                                            {{ $relatedEntity->full_name }}
                                                        @elseif($activity->related_to_type == 'company')
                                                            {{ $relatedEntity->name }}
                                                        @elseif($activity->related_to_type == 'deal')
                                                            {{ $relatedEntity->title }}
                                                        @endif
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($activity->assignedUser)
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <div class="avatar-initial bg-primary rounded-circle">
                                                                {{ substr($activity->assignedUser->name, 0, 1) }}
                                                            </div>
                                                        </div>
                                                        <span>{{ $activity->assignedUser->name }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $activity->due_date->format('M j, Y') }}</div>
                                                <small class="text-muted">{{ $activity->due_date->format('g:i A') }}</small>
                                                @if($activity->due_date < now() && !$activity->is_completed)
                                                    <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Overdue</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $activity->priority == 'urgent' ? 'danger' : ($activity->priority == 'high' ? 'warning' : ($activity->priority == 'medium' ? 'info' : 'secondary')) }}">
                                                    {{ ucfirst($activity->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($activity->is_completed)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Completed
                                                    </span>
                                                    <br><small class="text-muted">{{ $activity->completed_at->format('M j') }}</small>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock"></i> Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('activities.show', $activity) }}">View</a></li>
                                                        <li><a class="dropdown-item" href="{{ route('activities.edit', $activity) }}">Edit</a></li>
                                                        @if(!$activity->is_completed)
                                                            <li>
                                                                <form action="{{ route('activities.complete', $activity) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item text-success">
                                                                        <i class="fas fa-check"></i> Mark Complete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" 
                                                                        onclick="return confirm('Are you sure you want to delete this activity?')">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            {{ $activities->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-tasks text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted">No Activities Found</h5>
                            <p class="text-muted">Create your first activity to get started.</p>
                            <a href="{{ route('activities.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Activity
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-initial {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}
</style>
@endpush
