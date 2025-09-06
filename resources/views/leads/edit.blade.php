@extends('layouts.app')

@section('title', 'Edit Lead')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Lead: {{ $lead->company_name }}</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('leads.show', $lead) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Leads
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('leads.update', $lead) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Lead Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                                   id="company_name" name="company_name" 
                                                   value="{{ old('company_name', $lead->company_name) }}" required>
                                            @error('company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_name" class="form-label">Contact Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('contact_name') is-invalid @enderror" 
                                                   id="contact_name" name="contact_name" 
                                                   value="{{ old('contact_name', $lead->contact_name) }}" required>
                                            @error('contact_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                           id="email" name="email" value="{{ old('email', $lead->email) }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                           id="phone" name="phone" value="{{ old('phone', $lead->phone) }}">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="job_title" class="form-label">Job Title</label>
                                            <input type="text" class="form-control @error('job_title') is-invalid @enderror" 
                                                   id="job_title" name="job_title" value="{{ old('job_title', $lead->job_title) }}">
                                            @error('job_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="lead_source_id" class="form-label">Lead Source <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('lead_source_id') is-invalid @enderror" 
                                                            id="lead_source_id" name="lead_source_id" required>
                                                        <option value="">Select Source</option>
                                                        @foreach($leadSources as $source)
                                                            <option value="{{ $source->id }}" 
                                                                    {{ old('lead_source_id', $lead->lead_source_id) == $source->id ? 'selected' : '' }}>
                                                                {{ $source->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('lead_source_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="lead_status_id" class="form-label">Lead Status <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('lead_status_id') is-invalid @enderror" 
                                                            id="lead_status_id" name="lead_status_id" required>
                                                        <option value="">Select Status</option>
                                                        @foreach($leadStatuses as $status)
                                                            <option value="{{ $status->id }}" 
                                                                    {{ old('lead_status_id', $lead->lead_status_id) == $status->id ? 'selected' : '' }}>
                                                                {{ $status->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('lead_status_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Additional Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="industry_id" class="form-label">Industry</label>
                                            <select class="form-select @error('industry_id') is-invalid @enderror" 
                                                    id="industry_id" name="industry_id">
                                                <option value="">Select Industry</option>
                                                @foreach($industries as $industry)
                                                    <option value="{{ $industry->id }}" 
                                                            {{ old('industry_id', $lead->industry_id) == $industry->id ? 'selected' : '' }}>
                                                        {{ $industry->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('industry_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="company_size" class="form-label">Company Size</label>
                                                    <select class="form-select @error('company_size') is-invalid @enderror" 
                                                            id="company_size" name="company_size">
                                                        <option value="">Select Size</option>
                                                        <option value="1-10" {{ old('company_size', $lead->company_size) == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                                        <option value="11-50" {{ old('company_size', $lead->company_size) == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                                        <option value="51-200" {{ old('company_size', $lead->company_size) == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                                        <option value="201-1000" {{ old('company_size', $lead->company_size) == '201-1000' ? 'selected' : '' }}>201-1000 employees</option>
                                                        <option value="1000+" {{ old('company_size', $lead->company_size) == '1000+' ? 'selected' : '' }}>1000+ employees</option>
                                                    </select>
                                                    @error('company_size')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="assigned_user_id" class="form-label">Assigned To</label>
                                                    <select class="form-select @error('assigned_user_id') is-invalid @enderror" 
                                                            id="assigned_user_id" name="assigned_user_id">
                                                        <option value="">Auto-assign</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}" 
                                                                    {{ old('assigned_user_id', $lead->assigned_user_id) == $user->id ? 'selected' : '' }}>
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

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="estimated_value" class="form-label">Estimated Value</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" step="0.01" min="0" 
                                                               class="form-control @error('estimated_value') is-invalid @enderror" 
                                                               id="estimated_value" name="estimated_value" 
                                                               value="{{ old('estimated_value', $lead->estimated_value) }}">
                                                        @error('estimated_value')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="probability" class="form-label">Probability (%)</label>
                                                    <input type="number" min="0" max="100" 
                                                           class="form-control @error('probability') is-invalid @enderror" 
                                                           id="probability" name="probability" 
                                                           value="{{ old('probability', $lead->probability) }}">
                                                    @error('probability')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="expected_close_date" class="form-label">Expected Close Date</label>
                                            <input type="date" class="form-control @error('expected_close_date') is-invalid @enderror" 
                                                   id="expected_close_date" name="expected_close_date" 
                                                   value="{{ old('expected_close_date', $lead->expected_close_date ? $lead->expected_close_date->format('Y-m-d') : '') }}">
                                            @error('expected_close_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="budget_range" class="form-label">Budget Range</label>
                                            <input type="text" class="form-control @error('budget_range') is-invalid @enderror" 
                                                   id="budget_range" name="budget_range" 
                                                   value="{{ old('budget_range', $lead->budget_range) }}" 
                                                   placeholder="e.g., $10,000 - $50,000">
                                            @error('budget_range')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="pain_points" class="form-label">Pain Points / Notes</label>
                                            <textarea class="form-control @error('pain_points') is-invalid @enderror" 
                                                      id="pain_points" name="pain_points" rows="4">{{ old('pain_points', $lead->pain_points) }}</textarea>
                                            @error('pain_points')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lead Score Card -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Lead Score Analysis</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <div class="lead-score-circle mb-2" style="
                                                        width: 80px; 
                                                        height: 80px; 
                                                        border-radius: 50%; 
                                                        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        margin: 0 auto;
                                                        color: white;
                                                        font-size: 24px;
                                                        font-weight: bold;
                                                    ">
                                                        {{ $lead->score ?? 0 }}
                                                    </div>
                                                    <small class="text-muted">Lead Score</small>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <small class="text-muted">Last Activity:</small><br>
                                                            <span class="fw-semibold">{{ $lead->last_activity_date ? $lead->last_activity_date->diffForHumans() : 'No activity' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <small class="text-muted">Created:</small><br>
                                                            <span class="fw-semibold">{{ $lead->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <small class="text-muted">Assigned to:</small><br>
                                                            <span class="fw-semibold">{{ $lead->assignedUser->name ?? 'Unassigned' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('leads.show', $lead) }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Lead
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
