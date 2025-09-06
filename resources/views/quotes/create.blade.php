@extends('layouts.app')

@section('title', 'Create Quote')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Quote</h5>
                    <a href="{{ route('quotes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Quotes
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('quotes.store') }}" method="POST" id="quoteForm">
                        @csrf
                        
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
                                                   value="{{ old('quote_number', 'Q-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}" readonly>
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
                                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_id" class="form-label">Primary Contact</label>
                                            <select class="form-select @error('contact_id') is-invalid @enderror" 
                                                    id="contact_id" name="contact_id">
                                                <option value="">Select Contact</option>
                                                @foreach($contacts as $contact)
                                                    <option value="{{ $contact->id }}" {{ old('contact_id') == $contact->id ? 'selected' : '' }}>
                                                        {{ $contact->first_name }} {{ $contact->last_name }}
                                                    </option>
                                                @endforeach
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
                                                @foreach($deals as $deal)
                                                    <option value="{{ $deal->id }}" {{ old('deal_id') == $deal->id ? 'selected' : '' }}>
                                                        {{ $deal->name }} ({{ $deal->company->name ?? 'No Company' }})
                                                    </option>
                                                @endforeach
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="valid_until" class="form-label">Valid Until</label>
                                                    <input type="date" class="form-control @error('valid_until') is-invalid @enderror" 
                                                           id="valid_until" name="valid_until" 
                                                           value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}">
                                                    @error('valid_until')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select @error('status') is-invalid @enderror" 
                                                            id="status" name="status">
                                                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                        <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                                    </select>
                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="terms_and_conditions" class="form-label">Terms and Conditions</label>
                                            <textarea class="form-control @error('terms_and_conditions') is-invalid @enderror" 
                                                      id="terms_and_conditions" name="terms_and_conditions" rows="4">{{ old('terms_and_conditions', 'Payment due within 30 days. All prices are subject to change without notice.') }}</textarea>
                                            @error('terms_and_conditions')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Internal Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                            @error('notes')
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
                                <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="itemsTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%;">Product/Service</th>
                                                <th style="width: 20%;">Description</th>
                                                <th style="width: 10%;">Quantity</th>
                                                <th style="width: 15%;">Unit Price</th>
                                                <th style="width: 10%;">Discount</th>
                                                <th style="width: 15%;">Total</th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsTableBody">
                                            <!-- Items will be added here dynamically -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end fw-bold">Subtotal:</td>
                                                <td class="fw-bold" id="subtotalAmount">$0.00</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end">Tax Rate (%):</td>
                                                <td>
                                                    <input type="number" step="0.01" min="0" max="100" 
                                                           class="form-control form-control-sm" id="taxRate" 
                                                           name="tax_rate" value="{{ old('tax_rate', 0) }}">
                                                </td>
                                                <td class="fw-bold" id="taxAmount">$0.00</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-end fw-bold h5">Total Amount:</td>
                                                <td class="fw-bold h5 text-success" id="totalAmount">$0.00</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden inputs for calculated values -->
                        <input type="hidden" name="subtotal_amount" id="subtotalInput">
                        <input type="hidden" name="tax_amount" id="taxInput">
                        <input type="hidden" name="total_amount" id="totalInput">

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('quotes.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="action" value="save_draft" class="btn btn-outline-primary">
                                        <i class="fas fa-save"></i> Save as Draft
                                    </button>
                                    <button type="submit" name="action" value="save_and_send" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Save & Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Item Row Template -->
<template id="itemRowTemplate">
    <tr class="item-row">
        <td>
            <select class="form-select product-select" name="items[INDEX][product_id]">
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            <input type="text" class="form-control mt-1 custom-description" name="items[INDEX][description]" placeholder="Custom description">
        </td>
        <td>
            <textarea class="form-control" name="items[INDEX][description]" rows="2" placeholder="Item description"></textarea>
        </td>
        <td>
            <input type="number" class="form-control quantity-input" name="items[INDEX][quantity]" min="1" value="1" step="0.01">
        </td>
        <td>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" class="form-control unit-price-input" name="items[INDEX][unit_price]" min="0" step="0.01" value="0">
            </div>
        </td>
        <td>
            <div class="input-group">
                <input type="number" class="form-control discount-input" name="items[INDEX][discount_percent]" min="0" max="100" step="0.01" value="0">
                <span class="input-group-text">%</span>
            </div>
        </td>
        <td class="item-total fw-bold">$0.00</td>
        <td>
            <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 0;

    // Add Item functionality
    document.getElementById('addItemBtn').addEventListener('click', function() {
        addNewItem();
    });

    // Company selection change handler
    document.getElementById('company_id').addEventListener('change', function() {
        const companyId = this.value;
        const contactSelect = document.getElementById('contact_id');
        const dealSelect = document.getElementById('deal_id');
        
        // Clear options
        contactSelect.innerHTML = '<option value="">Select Contact</option>';
        dealSelect.innerHTML = '<option value="">Select Deal</option>';
        
        if (companyId) {
            // Fetch contacts and deals for the selected company
            Promise.all([
                fetch(`/api/companies/${companyId}/contacts`),
                fetch(`/api/companies/${companyId}/deals`)
            ])
            .then(responses => Promise.all(responses.map(r => r.json())))
            .then(([contacts, deals]) => {
                contacts.forEach(contact => {
                    const option = document.createElement('option');
                    option.value = contact.id;
                    option.textContent = `${contact.first_name} ${contact.last_name}`;
                    contactSelect.appendChild(option);
                });
                
                deals.forEach(deal => {
                    const option = document.createElement('option');
                    option.value = deal.id;
                    option.textContent = deal.name;
                    dealSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
        }
    });

    // Tax rate change handler
    document.getElementById('taxRate').addEventListener('input', calculateTotals);

    function addNewItem() {
        const template = document.getElementById('itemRowTemplate');
        const clone = template.content.cloneNode(true);
        
        // Replace INDEX with actual index
        clone.querySelectorAll('input, select, textarea').forEach(element => {
            if (element.name) {
                element.name = element.name.replace('INDEX', itemIndex);
            }
        });
        
        // Add event listeners
        const row = clone.querySelector('.item-row');
        addItemEventListeners(row);
        
        document.getElementById('itemsTableBody').appendChild(clone);
        itemIndex++;
        
        calculateTotals();
    }

    function addItemEventListeners(row) {
        // Product selection
        const productSelect = row.querySelector('.product-select');
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.price) {
                row.querySelector('.unit-price-input').value = selectedOption.dataset.price;
                calculateItemTotal(row);
            }
        });

        // Quantity, price, discount change
        row.querySelectorAll('.quantity-input, .unit-price-input, .discount-input').forEach(input => {
            input.addEventListener('input', () => calculateItemTotal(row));
        });

        // Remove item
        row.querySelector('.remove-item-btn').addEventListener('click', function() {
            row.remove();
            calculateTotals();
        });
    }

    function calculateItemTotal(row) {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const unitPrice = parseFloat(row.querySelector('.unit-price-input').value) || 0;
        const discountPercent = parseFloat(row.querySelector('.discount-input').value) || 0;
        
        const subtotal = quantity * unitPrice;
        const discountAmount = subtotal * (discountPercent / 100);
        const total = subtotal - discountAmount;
        
        row.querySelector('.item-total').textContent = '$' + total.toFixed(2);
        
        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        
        document.querySelectorAll('.item-row').forEach(row => {
            const itemTotalText = row.querySelector('.item-total').textContent;
            const itemTotal = parseFloat(itemTotalText.replace('$', '')) || 0;
            subtotal += itemTotal;
        });
        
        const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
        const taxAmount = subtotal * (taxRate / 100);
        const totalAmount = subtotal + taxAmount;
        
        // Update display
        document.getElementById('subtotalAmount').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('taxAmount').textContent = '$' + taxAmount.toFixed(2);
        document.getElementById('totalAmount').textContent = '$' + totalAmount.toFixed(2);
        
        // Update hidden inputs
        document.getElementById('subtotalInput').value = subtotal.toFixed(2);
        document.getElementById('taxInput').value = taxAmount.toFixed(2);
        document.getElementById('totalInput').value = totalAmount.toFixed(2);
    }

    // Add first item by default
    addNewItem();
});
</script>
@endpush
@endsection
