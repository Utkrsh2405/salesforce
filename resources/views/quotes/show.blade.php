@extends('layouts.app')

@section('title', 'Quote Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quote #{{ $quote->quote_number }}</h5>
                    <div>
                        <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('quotes.pdf', $quote) }}" class="btn btn-success me-2" target="_blank">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </a>
                        <div class="btn-group" role="group">
                            @if($quote->status === 'draft')
                                <form action="{{ route('quotes.send', $quote) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-paper-plane"></i> Send
                                    </button>
                                </form>
                            @elseif($quote->status === 'sent')
                                <form action="{{ route('quotes.accept', $quote) }}" method="POST" class="d-inline me-1">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Accept
                                    </button>
                                </form>
                                <form action="{{ route('quotes.reject', $quote) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('quotes.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left"></i> Back to Quotes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Quote Status Badge -->
                    <div class="mb-4">
                        <span class="badge
                            @if($quote->status === 'draft') bg-secondary
                            @elseif($quote->status === 'sent') bg-info
                            @elseif($quote->status === 'accepted') bg-success
                            @elseif($quote->status === 'declined') bg-danger
                            @elseif($quote->status === 'expired') bg-warning
                            @endif fs-6 px-3 py-2">
                            {{ ucfirst($quote->status) }}
                        </span>
                        @if($quote->signed_at)
                            <small class="text-muted ms-2">
                                <i class="fas fa-signature"></i> Signed on {{ $quote->signed_at->format('M d, Y') }}
                            </small>
                        @endif
                    </div>

                    <!-- Quote Header Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Quote Information</h6>
                                    <div class="row mb-2">
                                        <div class="col-4 fw-bold">Quote Number:</div>
                                        <div class="col-8">{{ $quote->quote_number }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 fw-bold">Quote Date:</div>
                                        <div class="col-8">{{ $quote->quote_date ? $quote->quote_date->format('M d, Y') : 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 fw-bold">Valid Until:</div>
                                        <div class="col-8">{{ $quote->valid_until ? $quote->valid_until->format('M d, Y') : 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 fw-bold">Created:</div>
                                        <div class="col-8">{{ $quote->created_at->format('M d, Y H:i') }}</div>
                                    </div>
                                    @if($quote->updated_at != $quote->created_at)
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">Last Updated:</div>
                                            <div class="col-8">{{ $quote->updated_at->format('M d, Y H:i') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Company & Contact</h6>
                                    @if($quote->company)
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">Company:</div>
                                            <div class="col-8">
                                                <a href="{{ route('companies.show', $quote->company) }}" class="text-decoration-none">
                                                    {{ $quote->company->name }}
                                                </a>
                                            </div>
                                        </div>
                                        @if($quote->company->phone)
                                            <div class="row mb-2">
                                                <div class="col-4 fw-bold">Phone:</div>
                                                <div class="col-8">{{ $quote->company->phone }}</div>
                                            </div>
                                        @endif
                                        @if($quote->company->email)
                                            <div class="row mb-2">
                                                <div class="col-4 fw-bold">Email:</div>
                                                <div class="col-8">
                                                    <a href="mailto:{{ $quote->company->email }}">{{ $quote->company->email }}</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    @if($quote->contact)
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">Contact:</div>
                                            <div class="col-8">
                                                <a href="{{ route('contacts.show', $quote->contact) }}" class="text-decoration-none">
                                                    {{ $quote->contact->first_name }} {{ $quote->contact->last_name }}
                                                </a>
                                            </div>
                                        </div>
                                        @if($quote->contact->email)
                                            <div class="row mb-2">
                                                <div class="col-4 fw-bold">Email:</div>
                                                <div class="col-8">
                                                    <a href="mailto:{{ $quote->contact->email }}">{{ $quote->contact->email }}</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    @if($quote->deal)
                                        <div class="row mb-2">
                                            <div class="col-4 fw-bold">Related Deal:</div>
                                            <div class="col-8">
                                                <a href="{{ route('deals.show', $quote->deal) }}" class="text-decoration-none">
                                                    {{ $quote->deal->title }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quote Items -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Quote Items</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Description</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Unit Price</th>
                                            <th class="text-center">Discount</th>
                                            <th class="text-end">Line Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($quote->quoteItems && $quote->quoteItems->count() > 0)
                                            @foreach($quote->quoteItems as $item)
                                                <tr>
                                                    <td>{{ $item->description }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                                    <td class="text-center">
                                                        @if($item->discount_percentage > 0)
                                                            {{ $item->discount_percentage }}%
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-end fw-bold">
                                                        ${{ number_format($item->line_total ?? ($item->quantity * $item->unit_price * (1 - ($item->discount_percentage ?? 0) / 100)), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                                    <br>No items found
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Quote Totals -->
                    <div class="row">
                        <div class="col-md-6">
                            @if($quote->terms_conditions || $quote->notes)
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Terms & Notes</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($quote->terms_conditions)
                                            <div class="mb-3">
                                                <h6>Terms & Conditions:</h6>
                                                <p class="text-muted">{{ $quote->terms_conditions }}</p>
                                            </div>
                                        @endif

                                        @if($quote->notes)
                                            <div class="mb-3">
                                                <h6>Notes:</h6>
                                                <p class="text-muted">{{ $quote->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Quote Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-6">Subtotal:</div>
                                        <div class="col-6 text-end fw-bold">${{ number_format($quote->subtotal ?? 0, 2) }}</div>
                                    </div>
                                    @if($quote->tax_amount > 0)
                                        <div class="row mb-2">
                                            <div class="col-6">Tax:</div>
                                            <div class="col-6 text-end fw-bold">${{ number_format($quote->tax_amount, 2) }}</div>
                                        </div>
                                    @endif
                                    @if($quote->discount_amount > 0)
                                        <div class="row mb-2">
                                            <div class="col-6">Discount:</div>
                                            <div class="col-6 text-end fw-bold text-success">-${{ number_format($quote->discount_amount, 2) }}</div>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 fs-5 fw-bold">Total:</div>
                                        <div class="col-6 text-end fs-5 fw-bold text-primary">${{ number_format($quote->total_amount ?? 0, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Signature Modal (for accepted quotes) -->
@if($quote->signature_data)
<div class="modal fade" id="signatureModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quote Signature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="data:image/png;base64,{{ $quote->signature_data }}" alt="Signature" class="img-fluid border">
                <p class="mt-2 text-muted">Signed on {{ $quote->signed_at->format('M d, Y \a\t H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-show signature modal if quote is accepted and has signature
    @if($quote->status === 'accepted' && $quote->signature_data)
        const signatureModal = new bootstrap.Modal(document.getElementById('signatureModal'));
        signatureModal.show();
    @endif
});
</script>
@endsection
