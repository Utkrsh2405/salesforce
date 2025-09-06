@extends('layouts.app')

@section('title', 'Deals')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Deals Pipeline</h1>
                <a href="{{ route('deals.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Deal
                </a>
            </div>
        </div>
    </div>

    <!-- Pipeline Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        @foreach($pipelineStats as $stage => $stats)
                            <div class="col-md-2">
                                <div class="pipeline-stage">
                                    <h5 class="text-muted">{{ $stage }}</h5>
                                    <h3 class="mb-1">${{ number_format($stats['value'], 0) }}</h3>
                                    <small class="text-muted">{{ $stats['count'] }} deals</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="stage" class="form-label">Stage</label>
                            <select name="stage" id="stage" class="form-select">
                                <option value="">All Stages</option>
                                @foreach($dealStages as $stage)
                                    <option value="{{ $stage->id }}" {{ request('stage') == $stage->id ? 'selected' : '' }}>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="assigned_user" class="form-label">Assigned To</label>
                            <select name="assigned_user" id="assigned_user" class="form-select">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('assigned_user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   placeholder="Deal name, company..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('deals.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Toggle -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="view" id="kanban-view" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="kanban-view">
                    <i class="fas fa-columns"></i> Kanban
                </label>
                
                <input type="radio" class="btn-check" name="view" id="list-view" autocomplete="off">
                <label class="btn btn-outline-primary" for="list-view">
                    <i class="fas fa-list"></i> List
                </label>
            </div>
        </div>
    </div>

    <!-- Kanban View -->
    <div id="kanban-board" class="kanban-view">
        <div class="row">
            @foreach($dealStages as $stage)
                <div class="col-md-2">
                    <div class="card stage-column">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ $stage->name }}</h6>
                            <span class="badge bg-secondary">
                                {{ $dealsByStage[$stage->id]->count() }}
                            </span>
                        </div>
                        <div class="card-body stage-deals" data-stage-id="{{ $stage->id }}">
                            @foreach($dealsByStage[$stage->id] as $deal)
                                <div class="deal-card mb-3" data-deal-id="{{ $deal->id }}">
                                    <div class="card card-sm">
                                        <div class="card-body p-3">
                                            <h6 class="card-title">
                                                <a href="{{ route('deals.show', $deal) }}" class="text-decoration-none">
                                                    {{ $deal->name }}
                                                </a>
                                            </h6>
                                            <p class="card-text">
                                                <small class="text-muted">{{ $deal->company->name ?? 'No Company' }}</small>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-success">
                                                    ${{ number_format($deal->amount, 0) }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $deal->probability }}%
                                                </small>
                                            </div>
                                            @if($deal->expected_close_date)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> 
                                                        {{ $deal->expected_close_date->format('M j') }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- List View -->
    <div id="list-board" class="list-view" style="display: none;">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Deal Name</th>
                                <th>Company</th>
                                <th>Stage</th>
                                <th>Amount</th>
                                <th>Probability</th>
                                <th>Expected Close</th>
                                <th>Assigned To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deals as $deal)
                                <tr>
                                    <td>
                                        <a href="{{ route('deals.show', $deal) }}" class="text-decoration-none fw-semibold">
                                            {{ $deal->name }}
                                        </a>
                                    </td>
                                    <td>{{ $deal->company->name ?? 'No Company' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $deal->dealStage->name ?? 'No Stage' }}</span>
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($deal->amount, 0) }}</td>
                                    <td>{{ $deal->probability }}%</td>
                                    <td>
                                        @if($deal->expected_close_date)
                                            {{ $deal->expected_close_date->format('M j, Y') }}
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                    <td>{{ $deal->assignedUser->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('deals.show', $deal) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('deals.edit', $deal) }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($deals->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $deals->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.stage-column {
    min-height: 600px;
}

.stage-deals {
    min-height: 500px;
}

.deal-card {
    cursor: move;
    transition: transform 0.2s;
}

.deal-card:hover {
    transform: translateY(-2px);
}

.card-sm .card-body {
    padding: 0.75rem;
}

.pipeline-stage {
    padding: 1rem 0;
}

.kanban-view .col-md-2 {
    padding-left: 8px;
    padding-right: 8px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle functionality
    const kanbanView = document.getElementById('kanban-view');
    const listView = document.getElementById('list-view');
    const kanbanBoard = document.getElementById('kanban-board');
    const listBoard = document.getElementById('list-board');

    kanbanView.addEventListener('change', function() {
        if (this.checked) {
            kanbanBoard.style.display = 'block';
            listBoard.style.display = 'none';
        }
    });

    listView.addEventListener('change', function() {
        if (this.checked) {
            kanbanBoard.style.display = 'none';
            listBoard.style.display = 'block';
        }
    });

    // Make deal cards draggable (basic implementation)
    const dealCards = document.querySelectorAll('.deal-card');
    const stageColumns = document.querySelectorAll('.stage-deals');

    dealCards.forEach(card => {
        card.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', this.dataset.dealId);
        });
        card.setAttribute('draggable', 'true');
    });

    stageColumns.forEach(column => {
        column.addEventListener('dragover', function(e) {
            e.preventDefault();
        });

        column.addEventListener('drop', function(e) {
            e.preventDefault();
            const dealId = e.dataTransfer.getData('text/plain');
            const stageId = this.dataset.stageId;
            
            // Update deal stage via AJAX
            fetch(`/deals/${dealId}/update-stage`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    deal_stage_id: stageId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Move the card to the new column
                    const dealCard = document.querySelector(`[data-deal-id="${dealId}"]`);
                    this.appendChild(dealCard);
                } else {
                    alert('Failed to update deal stage');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update deal stage');
            });
        });
    });
});
</script>
@endpush
@endsection
