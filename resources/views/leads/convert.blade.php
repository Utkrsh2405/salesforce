@extends('layouts.app')

@section('title', 'Lead Conversion')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Convert Lead: {{ $lead->contact_name }} - {{ $lead->company_name }}</h5>
                    <a href="{{ route('leads.show', $lead) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Lead
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('leads.convert', $lead) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Deal Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="deal_title" class="form-label">Deal Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('deal_title') is-invalid @enderror" 
                                                   id="deal_title" name="deal_title" 
                                                   value="{{ old('deal_title', $lead->company_name . ' - Opportunity') }}" required>
                                            @error('deal_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="deal_value" class="form-label">Deal Value <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('deal_value') is-invalid @enderror" 
                                                       id="deal_value" name="deal_value" 
                                                       value="{{ old('deal_value', $lead->estimated_value) }}" required>
                                                @error('deal_value')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deal_stage_id" class="form-label">Deal Stage <span class="text-danger">*</span></label>
                                            <select class="form-select @error('deal_stage_id') is-invalid @enderror" 
                                                    id="deal_stage_id" name="deal_stage_id" required>
                                                <option value="">Select Stage</option>
                                                @foreach($dealStages as $stage)
                                                    <option value="{{ $stage->id }}" 
                                                            {{ old('deal_stage_id') == $stage->id ? 'selected' : '' }}>
                                                        {{ $stage->name }} ({{ $stage->probability }}%)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('deal_stage_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="expected_close_date" class="form-label">Expected Close Date</label>
                                            <input type="date" class="form-control @error('expected_close_date') is-invalid @enderror" 
                                                   id="expected_close_date" name="expected_close_date" 
                                                   value="{{ old('expected_close_date', $lead->expected_close_date?->format('Y-m-d')) }}">
                                            @error('expected_close_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Conversion Options</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       id="create_company" name="create_company" 
                                                       value="1" {{ old('create_company', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="create_company">
                                                    Create Company Record
                                                </label>
                                            </div>
                                            <small class="text-muted">
                                                Company: {{ $lead->company_name }}
                                            </small>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       id="create_contact" name="create_contact" 
                                                       value="1" {{ old('create_contact', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="create_contact">
                                                    Create Contact Record
                                                </label>
                                            </div>
                                            <small class="text-muted">
                                                Contact: {{ $lead->contact_name }}
                                                @if($lead->email)
                                                    <br>Email: {{ $lead->email }}
                                                @endif
                                                @if($lead->phone)
                                                    <br>Phone: {{ $lead->phone }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Lead Summary</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Company:</strong></td>
                                                <td>{{ $lead->company_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Contact:</strong></td>
                                                <td>{{ $lead->contact_name }}</td>
                                            </tr>
                                            @if($lead->job_title)
                                            <tr>
                                                <td><strong>Title:</strong></td>
                                                <td>{{ $lead->job_title }}</td>
                                            </tr>
                                            @endif
                                            @if($lead->leadSource)
                                            <tr>
                                                <td><strong>Source:</strong></td>
                                                <td>{{ $lead->leadSource->name }}</td>
                                            </tr>
                                            @endif
                                            @if($lead->estimated_value)
                                            <tr>
                                                <td><strong>Est. Value:</strong></td>
                                                <td>${{ number_format($lead->estimated_value, 2) }}</td>
                                            </tr>
                                            @endif
                                            @if($lead->lead_score)
                                            <tr>
                                                <td><strong>Lead Score:</strong></td>
                                                <td>{{ $lead->lead_score }}/100</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('leads.show', $lead) }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-exchange-alt"></i> Convert Lead
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate deal title based on company name
    const dealValueInput = document.getElementById('deal_value');
    const dealStageSelect = document.getElementById('deal_stage_id');
    
    // Format currency input
    dealValueInput.addEventListener('input', function() {
        let value = this.value.replace(/[^\d.]/g, '');
        this.value = value;
    });
    
    // Show probability when stage changes
    dealStageSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            console.log('Stage selected with probability: ' + selectedOption.text);
        }
    });
});
</script>
@endpush
