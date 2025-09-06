@extends('layouts.app')

@section('title', 'Create Deal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Deal</h5>
                    <a href="{{ route('deals.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Deals
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('deals.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Deal Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Deal Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" step="0.01" min="0" 
                                                               class="form-control @error('amount') is-invalid @enderror" 
                                                               id="amount" name="amount" value="{{ old('amount') }}" required>
                                                        @error('amount')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="probability" class="form-label">Probability (%) <span class="text-danger">*</span></label>
                                                    <input type="number" min="0" max="100" 
                                                           class="form-control @error('probability') is-invalid @enderror" 
                                                           id="probability" name="probability" value="{{ old('probability', 50) }}" required>
                                                    @error('probability')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="company_id" class="form-label">Company</label>
                                                    <select class="form-select @error('company_id') is-invalid @enderror" 
                                                            id="company_id" name="company_id">
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
                                            </div>
                                            <div class="col-md-6">
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
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="deal_stage_id" class="form-label">Stage <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('deal_stage_id') is-invalid @enderror" 
                                                            id="deal_stage_id" name="deal_stage_id" required>
                                                        <option value="">Select Stage</option>
                                                        @foreach($dealStages as $stage)
                                                            <option value="{{ $stage->id }}" {{ old('deal_stage_id') == $stage->id ? 'selected' : '' }}>
                                                                {{ $stage->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('deal_stage_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="deal_source_id" class="form-label">Source</label>
                                                    <select class="form-select @error('deal_source_id') is-invalid @enderror" 
                                                            id="deal_source_id" name="deal_source_id">
                                                        <option value="">Select Source</option>
                                                        @foreach($dealSources as $source)
                                                            <option value="{{ $source->id }}" {{ old('deal_source_id') == $source->id ? 'selected' : '' }}>
                                                                {{ $source->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('deal_source_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="assigned_user_id" class="form-label">Assigned To</label>
                                            <select class="form-select @error('assigned_user_id') is-invalid @enderror" 
                                                    id="assigned_user_id" name="assigned_user_id">
                                                <option value="">Auto-assign</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('assigned_user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Timeline & Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="expected_close_date" class="form-label">Expected Close Date</label>
                                                    <input type="date" class="form-control @error('expected_close_date') is-invalid @enderror" 
                                                           id="expected_close_date" name="expected_close_date" value="{{ old('expected_close_date') }}">
                                                    @error('expected_close_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="next_step_date" class="form-label">Next Step Date</label>
                                                    <input type="date" class="form-control @error('next_step_date') is-invalid @enderror" 
                                                           id="next_step_date" name="next_step_date" value="{{ old('next_step_date') }}">
                                                    @error('next_step_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="next_step" class="form-label">Next Step</label>
                                            <input type="text" class="form-control @error('next_step') is-invalid @enderror" 
                                                   id="next_step" name="next_step" value="{{ old('next_step') }}" 
                                                   placeholder="What's the next action required?">
                                            @error('next_step')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="key_decision_makers" class="form-label">Key Decision Makers</label>
                                            <textarea class="form-control @error('key_decision_makers') is-invalid @enderror" 
                                                      id="key_decision_makers" name="key_decision_makers" rows="3" 
                                                      placeholder="List the key people involved in the decision">{{ old('key_decision_makers') }}</textarea>
                                            @error('key_decision_makers')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="competitors" class="form-label">Competitors</label>
                                            <input type="text" class="form-control @error('competitors') is-invalid @enderror" 
                                                   id="competitors" name="competitors" value="{{ old('competitors') }}" 
                                                   placeholder="Who are we competing against?">
                                            @error('competitors')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="budget_confirmed" class="form-label">Budget Status</label>
                                            <select class="form-select @error('budget_confirmed') is-invalid @enderror" 
                                                    id="budget_confirmed" name="budget_confirmed">
                                                <option value="">Not Specified</option>
                                                <option value="1" {{ old('budget_confirmed') == '1' ? 'selected' : '' }}>Budget Confirmed</option>
                                                <option value="0" {{ old('budget_confirmed') == '0' ? 'selected' : '' }}>Budget Not Confirmed</option>
                                            </select>
                                            @error('budget_confirmed')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="pain_points" class="form-label">Pain Points</label>
                                            <textarea class="form-control @error('pain_points') is-invalid @enderror" 
                                                      id="pain_points" name="pain_points" rows="3" 
                                                      placeholder="What problems are they trying to solve?">{{ old('pain_points') }}</textarea>
                                            @error('pain_points')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="proposed_solution" class="form-label">Proposed Solution</label>
                                            <textarea class="form-control @error('proposed_solution') is-invalid @enderror" 
                                                      id="proposed_solution" name="proposed_solution" rows="3" 
                                                      placeholder="What solution are we proposing?">{{ old('proposed_solution') }}</textarea>
                                            @error('proposed_solution')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('deals.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Deal
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Company selection change handler
    const companySelect = document.getElementById('company_id');
    const contactSelect = document.getElementById('contact_id');

    companySelect.addEventListener('change', function() {
        const companyId = this.value;
        
        // Clear contact options
        contactSelect.innerHTML = '<option value="">Select Contact</option>';
        
        if (companyId) {
            // Fetch contacts for the selected company
            fetch(`/api/companies/${companyId}/contacts`)
                .then(response => response.json())
                .then(contacts => {
                    contacts.forEach(contact => {
                        const option = document.createElement('option');
                        option.value = contact.id;
                        option.textContent = `${contact.first_name} ${contact.last_name}`;
                        contactSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching contacts:', error);
                });
        }
    });

    // Probability slider visual feedback
    const probabilityInput = document.getElementById('probability');
    
    probabilityInput.addEventListener('input', function() {
        const value = this.value;
        let color = '#dc3545'; // red
        
        if (value >= 75) {
            color = '#28a745'; // green
        } else if (value >= 50) {
            color = '#ffc107'; // yellow
        } else if (value >= 25) {
            color = '#fd7e14'; // orange
        }
        
        this.style.borderColor = color;
    });
});
</script>
@endpush
@endsection
