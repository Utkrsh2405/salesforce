@extends('layouts.app')

@section('title', 'Quotes')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Quotes</h1>
                <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Quote
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">${{ number_format($stats['total_value'], 0) }}</h3>
                    <p class="text-muted mb-0">Total Quote Value</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $stats['sent_count'] }}</h3>
                    <p class="text-muted mb-0">Sent Quotes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">{{ $stats['pending_count'] }}</h3>
                    <p class="text-muted mb-0">Pending Approval</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info">{{ $stats['accepted_count'] }}</h3>
                    <p class="text-muted mb-0">Accepted Quotes</p>
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
                                <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="company" class="form-label">Company</label>
                            <select name="company" id="company" class="form-select">
                                <option value="">All Companies</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   placeholder="Quote number, company..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('quotes.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quotes Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Quote #</th>
                            <th>Company</th>
                            <th>Deal</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Valid Until</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $quote)
                            <tr>
                                <td>
                                    <a href="{{ route('quotes.show', $quote) }}" class="text-decoration-none fw-semibold">
                                        {{ $quote->quote_number }}
                                    </a>
                                </td>
                                <td>{{ $quote->company->name ?? 'No Company' }}</td>
                                <td>
                                    @if($quote->deal)
                                        <a href="{{ route('deals.show', $quote->deal) }}" class="text-decoration-none">
                                            {{ $quote->deal->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">No Deal</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-success">${{ number_format($quote->total_amount, 2) }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'draft' => 'secondary',
                                            'sent' => 'primary',
                                            'accepted' => 'success',
                                            'rejected' => 'danger',
                                            'expired' => 'warning'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$quote->status] ?? 'secondary' }}">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($quote->valid_until)
                                        {{ $quote->valid_until->format('M j, Y') }}
                                        @if($quote->valid_until->isPast() && $quote->status !== 'accepted')
                                            <small class="text-danger d-block">Expired</small>
                                        @endif
                                    @else
                                        <span class="text-muted">No expiry</span>
                                    @endif
                                </td>
                                <td>{{ $quote->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('quotes.show', $quote) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($quote->status === 'draft')
                                            <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('quotes.pdf', $quote) }}" target="_blank">
                                                        <i class="fas fa-file-pdf"></i> Download PDF
                                                    </a>
                                                </li>
                                                @if($quote->status === 'draft')
                                                    <li>
                                                        <form action="{{ route('quotes.send', $quote) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-paper-plane"></i> Send Quote
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if($quote->status === 'sent')
                                                    <li>
                                                        <form action="{{ route('quotes.accept', $quote) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fas fa-check"></i> Mark Accepted
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('quotes.reject', $quote) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-times"></i> Mark Rejected
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if(in_array($quote->status, ['draft', 'sent']))
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('quotes.destroy', $quote) }}" method="POST" 
                                                              onsubmit="return confirm('Are you sure you want to delete this quote?')" class="d-inline">
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
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No quotes found.</p>
                                    <a href="{{ route('quotes.create') }}" class="btn btn-primary">Create First Quote</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($quotes->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $quotes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
