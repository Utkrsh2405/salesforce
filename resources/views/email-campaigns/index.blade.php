@extends('layouts.app')

@section('title', 'Email Campaigns')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Email Campaigns</h1>
                <a href="{{ route('email-campaigns.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Campaign
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">{{ $stats['total_campaigns'] }}</h3>
                    <p class="text-muted mb-0">Total Campaigns</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $stats['sent_campaigns'] }}</h3>
                    <p class="text-muted mb-0">Sent Campaigns</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">{{ $stats['draft_campaigns'] }}</h3>
                    <p class="text-muted mb-0">Draft Campaigns</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info">{{ number_format($stats['total_recipients']) }}</h3>
                    <p class="text-muted mb-0">Total Recipients</p>
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
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="sending" {{ request('status') == 'sending' ? 'selected' : '' }}>Sending</option>
                                <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="newsletter" {{ request('type') == 'newsletter' ? 'selected' : '' }}>Newsletter</option>
                                <option value="promotion" {{ request('type') == 'promotion' ? 'selected' : '' }}>Promotion</option>
                                <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                                <option value="follow_up" {{ request('type') == 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   placeholder="Campaign name, subject..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('email-campaigns.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaigns Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Subject</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Recipients</th>
                            <th>Open Rate</th>
                            <th>Click Rate</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaigns as $campaign)
                            <tr>
                                <td>
                                    <a href="{{ route('email-campaigns.show', $campaign) }}" class="text-decoration-none fw-semibold">
                                        {{ $campaign->name }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($campaign->subject, 50) }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($campaign->type) }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'draft' => 'secondary',
                                            'scheduled' => 'info',
                                            'sending' => 'warning',
                                            'sent' => 'success',
                                            'paused' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$campaign->status] ?? 'secondary' }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </td>
                                <td>{{ number_format($campaign->recipient_count) }}</td>
                                <td>
                                    @if($campaign->status === 'sent' && $campaign->sent_count > 0)
                                        {{ number_format(($campaign->opened_count / $campaign->sent_count) * 100, 1) }}%
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($campaign->status === 'sent' && $campaign->sent_count > 0)
                                        {{ number_format(($campaign->clicked_count / $campaign->sent_count) * 100, 1) }}%
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $campaign->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('email-campaigns.show', $campaign) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($campaign->status === 'draft')
                                            <a href="{{ route('email-campaigns.edit', $campaign) }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('email-campaigns.preview', $campaign) }}" target="_blank">
                                                        <i class="fas fa-eye"></i> Preview
                                                    </a>
                                                </li>
                                                @if($campaign->status === 'draft')
                                                    <li>
                                                        <form action="{{ route('email-campaigns.test', $campaign) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-flask"></i> Send Test
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('email-campaigns.send', $campaign) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-success"
                                                                    onclick="return confirm('Are you sure you want to send this campaign?')">
                                                                <i class="fas fa-paper-plane"></i> Send Now
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if($campaign->status === 'sending')
                                                    <li>
                                                        <form action="{{ route('email-campaigns.pause', $campaign) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-warning">
                                                                <i class="fas fa-pause"></i> Pause
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if(in_array($campaign->status, ['draft', 'paused']))
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('email-campaigns.destroy', $campaign) }}" method="POST" 
                                                              onsubmit="return confirm('Are you sure you want to delete this campaign?')" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No email campaigns found.</p>
                                    <a href="{{ route('email-campaigns.create') }}" class="btn btn-primary">Create First Campaign</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($campaigns->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $campaigns->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
