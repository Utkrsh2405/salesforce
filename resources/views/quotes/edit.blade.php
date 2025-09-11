@extends('layouts.app')

@section('title', 'Edit Quote')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Quote #{{ $quote->quote_number }}</h5>
                    <div>
                        <a href="{{ route('quotes.show', $quote) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('quotes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Quotes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('quotes.update', $quote) }}" method="POST" id="quoteForm">
                        @csrf
                        @method('PUT')

                        <!-- Quote Header Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Quote Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="quote_number" class="form-label">Quote Number</label>
                                            <input type="text" class="form-control @error('quote_number') is-invalid @enderror"
                                                   id="quote_number" name="quote_number"
                                                   value="{{ old('quote_number', $quote->quote_number) }}" readonly>
                                            @error('quote_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="company_id" class="form-label">Company <span class="text-danger">*</span></label>
                                            <select class="form-select @error('company_id') is-invalid @enderror"
                                                    id="company_id" name="company_id" required>
                                                <option value="">Select Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}" {{ old('company_id', $quote->company_id) == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_id" class="form-label">Contact</label>
                                            <select class="form-select @error('contact_id') is-invalid @enderror"
                                                    id="contact_id" name="contact_id">
                                                <option value="">Select Contact</option>
                                                @if($quote->company && $quote->company->contacts)
                                                    @foreach($quote->company->contacts as $contact)
                                                        <option value="{{ $contact->id }}" {{ old('contact_id', $quote->contact_id) == $contact->id ? 'selected' : '' }}>
                                                            {{ $contact->first_name }} {{ $contact->last_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('contact_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="deal_id" class="form-label">Related Deal</label>
                                            <select class="form-select @error('deal_id') is-invalid @enderror"
                                                    id="deal_id" name="deal_id">
                                                <option value="">Select Deal</option>
                                                @if($quote->company && $quote->company->deals)
                                                    @foreach($quote->company->deals as $deal)
                                                        <option value="{{ $deal->id }}" {{ old('deal_id', $quote->deal_id) == $deal->id ? 'selected' : '' }}>
                                                            {{ $deal->title }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('deal_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Quote Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="quote_date" class="form-label">Quote Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('quote_date') is-invalid @enderror"
                                                   id="quote_date" name="quote_date"
                                                   value="{{ old('quote_date', $quote->quote_date ? $quote->quote_date->format('Y-m-d') : date('Y-m-d')) }}" required>
                                            @error('quote_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="valid_until" class="form-label">Valid Until</label>
                                            <input type="date" class="form-control @error('valid_until') is-invalid @enderror"
                                                   id="valid_until" name="valid_until"
                                                   value="{{ old('valid_until', $quote->valid_until ? $quote->valid_until->format('Y-m-d') : '') }}">
                                            @error('valid_until')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                <option value="draft" {{ old('status', $quote->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="sent" {{ old('status', $quote->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                                                <option value="accepted" {{ old('status', $quote->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                <option value="declined" {{ old('status', $quote->status) == 'declined' ? 'selected' : '' }}>Declined</option>
                                                <option value="expired" {{ old('status', $quote->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quote Items -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Quote Items</h6>
                                <button type="button" class="btn btn-primary btn-sm" id="addItemBtn">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="quoteItems">
                                    @if($quote->quoteItems && $quote->quoteItems->count() > 0)
                                        @foreach($quote->quoteItems as $index => $item)
                                            <div class="quote-item row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="items[{{ $index }}][description]"
                                                           value="{{ old('items.' . $index . '.description', $item->description) }}"
                                                           placeholder="Item description" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" name="items[{{ $index }}][quantity]"
                                                           value="{{ old('items.' . $index . '.quantity', $item->quantity) }}"
                                                           placeholder="Qty" min="1" step="0.01" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" name="items[{{ $index }}][unit_price]"
                                                           value="{{ old('items.' . $index . '.unit_price', $item->unit_price) }}"
                                                           placeholder="Unit Price" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" name="items[{{ $index }}][discount_percentage]"
                                                           value="{{ old('items.' . $index . '.discount_percentage', $item->discount_percentage ?? 0) }}"
                                                           placeholder="Discount %" min="0" max="100" step="0.01">
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="form-control-plaintext text-end fw-bold" id="lineTotal{{ $index }}">
                                                        ${{ number_format(($item->quantity * $item->unit_price) * (1 - ($item->discount_percentage ?? 0) / 100), 2) }}
                                                    </span>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-item">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Totals and Terms -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Terms & Conditions</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                                            <textarea class="form-control @error('terms_conditions') is-invalid @enderror"
                                                      id="terms_conditions" name="terms_conditions" rows="4">{{ old('terms_conditions', $quote->terms_conditions) }}</textarea>
                                            @error('terms_conditions')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                                      id="notes" name="notes" rows="3">{{ old('notes', $quote->notes) }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Quote Totals</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6">Subtotal:</div>
                                            <div class="col-6 text-end fw-bold" id="subtotal">${{ number_format($quote->subtotal ?? 0, 2) }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label for="tax_amount" class="form-label mb-0">Tax Amount:</label>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control @error('tax_amount') is-invalid @enderror"
                                                           id="tax_amount" name="tax_amount"
                                                           value="{{ old('tax_amount', $quote->tax_amount ?? 0) }}" min="0" step="0.01">
                                                </div>
                                                @error('tax_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label for="discount_amount" class="form-label mb-0">Discount Amount:</label>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control @error('discount_amount') is-invalid @enderror"
                                                           id="discount_amount" name="discount_amount"
                                                           value="{{ old('discount_amount', $quote->discount_amount ?? 0) }}" min="0" step="0.01">
                                                </div>
                                                @error('discount_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6 fw-bold">Total:</div>
                                            <div class="col-6 text-end fw-bold fs-5 text-primary" id="total">${{ number_format($quote->total_amount ?? 0, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('quotes.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Quote
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = {{ $quote->quoteItems ? $quote->quoteItems->count() : 0 }};

    // Add new item
    document.getElementById('addItemBtn').addEventListener('click', function() {
        addQuoteItem();
    });

    // Remove item
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
            e.target.closest('.quote-item').remove();
            calculateTotals();
        }
    });

    // Calculate totals when inputs change
    document.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.includes('quantity') || e.target.name.includes('unit_price') || e.target.name.includes('discount_percentage')) {
            calculateTotals();
        }
    });

    // Update contact options when company changes
    document.getElementById('company_id').addEventListener('change', function() {
        const companyId = this.value;
        const contactSelect = document.getElementById('contact_id');
        const dealSelect = document.getElementById('deal_id');

        if (companyId) {
            // Fetch contacts and deals for the selected company
            fetch(`/api/companies/${companyId}`)
                .then(response => response.json())
                .then(data => {
                    // Update contacts
                    contactSelect.innerHTML = '<option value="">Select Contact</option>';
                    if (data.contacts) {
                        data.contacts.forEach(contact => {
                            const option = document.createElement('option');
                            option.value = contact.id;
                            option.textContent = `${contact.first_name} ${contact.last_name}`;
                            contactSelect.appendChild(option);
                        });
                    }

                    // Update deals
                    dealSelect.innerHTML = '<option value="">Select Deal</option>';
                    if (data.deals) {
                        data.deals.forEach(deal => {
                            const option = document.createElement('option');
                            option.value = deal.id;
                            option.textContent = deal.title;
                            dealSelect.appendChild(option);
                        });
                    }
                });
        } else {
            contactSelect.innerHTML = '<option value="">Select Contact</option>';
            dealSelect.innerHTML = '<option value="">Select Deal</option>';
        }
    });

    function addQuoteItem() {
        const itemsContainer = document.getElementById('quoteItems');
        const itemHtml = `
            <div class="quote-item row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="items[${itemIndex}][description]" placeholder="Item description" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="items[${itemIndex}][quantity]" placeholder="Qty" min="1" step="0.01" value="1" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="items[${itemIndex}][unit_price]" placeholder="Unit Price" min="0" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="items[${itemIndex}][discount_percentage]" placeholder="Discount %" min="0" max="100" step="0.01" value="0">
                </div>
                <div class="col-md-1">
                    <span class="form-control-plaintext text-end fw-bold" id="lineTotal${itemIndex}">$0.00</span>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
        itemIndex++;
    }

    function calculateTotals() {
        let subtotal = 0;
        const items = document.querySelectorAll('.quote-item');

        items.forEach((item, index) => {
            const quantity = parseFloat(item.querySelector('[name*="[quantity]"]').value) || 0;
            const unitPrice = parseFloat(item.querySelector('[name*="[unit_price]"]').value) || 0;
            const discountPercent = parseFloat(item.querySelector('[name*="[discount_percentage]"]').value) || 0;

            const lineTotal = quantity * unitPrice * (1 - discountPercent / 100);
            subtotal += lineTotal;

            const lineTotalElement = item.querySelector(`[id^="lineTotal"]`);
            if (lineTotalElement) {
                lineTotalElement.textContent = `$${lineTotal.toFixed(2)}`;
            }
        });

        const taxAmount = parseFloat(document.getElementById('tax_amount').value) || 0;
        const discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
        const total = subtotal + taxAmount - discountAmount;

        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    }

    // Initial calculation
    calculateTotals();
});
</script>
@endsection
