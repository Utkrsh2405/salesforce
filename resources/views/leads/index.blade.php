@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Leads</h1>
            <p class="text-muted mb-0">Manage your sales prospects</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeadModal">
                <i class="bi bi-plus-circle me-2"></i>Add Lead
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 slide-in-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Leads
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">89</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> 12% from last month
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-plus text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 slide-in-left" style="animation-delay: 0.1s;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Hot Leads
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">23</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> 5% from last week
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-fire text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 slide-in-left" style="animation-delay: 0.2s;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Converted
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">34</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> 8% conversion rate
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 slide-in-left" style="animation-delay: 0.3s;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Avg. Lead Value
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$2,450</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> $230 increase
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-dollar text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Pipeline Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm fade-in-up">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h6 class="mb-0 text-gray-800">Lead Pipeline</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="pipeline-stage">
                                <div class="pipeline-number text-primary">32</div>
                                <div class="pipeline-label">New</div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="pipeline-stage">
                                <div class="pipeline-number text-warning">23</div>
                                <div class="pipeline-label">Qualified</div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="pipeline-stage">
                                <div class="pipeline-number text-info">18</div>
                                <div class="pipeline-label">Contacted</div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="pipeline-stage">
                                <div class="pipeline-number text-success">16</div>
                                <div class="pipeline-label">Converted</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4 bounce-in">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search leads...">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">All Status</option>
                        <option value="new">New</option>
                        <option value="qualified">Qualified</option>
                        <option value="contacted">Contacted</option>
                        <option value="converted">Converted</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">All Sources</option>
                        <option value="website">Website</option>
                        <option value="referral">Referral</option>
                        <option value="cold_call">Cold Call</option>
                        <option value="social_media">Social Media</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">All Priority</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="btn-group w-100" role="group">
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-funnel me-2"></i>Filter
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="card border-0 shadow-sm fade-in-up">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-gray-800">Lead List</h6>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active">
                        <i class="bi bi-list"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-kanban"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllLeads">
                                </div>
                            </th>
                            <th>Lead</th>
                            <th>Company</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Value</th>
                            <th>Created</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Wilson&background=ef4444&color=fff" 
                                             class="rounded-circle" width="40" height="40" alt="Sarah Wilson">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800">Sarah Wilson</div>
                                        <div class="text-muted small">sarah.wilson@techcorp.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-800">TechCorp</span>
                                <div class="text-muted small">Technology</div>
                            </td>
                            <td>
                                <span class="badge" style="background-color: #e0f2fe; color: #0277bd;">Website</span>
                            </td>
                            <td>
                                <span class="badge badge-warning">Qualified</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-circle-fill text-danger me-1" style="font-size: 0.5rem;"></i>
                                    <span class="text-danger fw-semibold">High</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-success">$5,200</span>
                            </td>
                            <td>
                                <span class="text-muted">Today</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-success" title="Convert Lead">
                                        <i class="bi bi-arrow-right-circle"></i>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-telephone me-2"></i>Call</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Email</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Chen&background=3b82f6&color=fff" 
                                             class="rounded-circle" width="40" height="40" alt="Mike Chen">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800">Mike Chen</div>
                                        <div class="text-muted small">mike.chen@startup.io</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-800">Startup.io</span>
                                <div class="text-muted small">Software</div>
                            </td>
                            <td>
                                <span class="badge" style="background-color: #f3e8ff; color: #7c3aed;">Referral</span>
                            </td>
                            <td>
                                <span class="badge badge-info">Contacted</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-circle-fill text-warning me-1" style="font-size: 0.5rem;"></i>
                                    <span class="text-warning fw-semibold">Medium</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-success">$3,800</span>
                            </td>
                            <td>
                                <span class="text-muted">2 days ago</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-success" title="Convert Lead">
                                        <i class="bi bi-arrow-right-circle"></i>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-telephone me-2"></i>Call</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Email</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <img src="https://ui-avatars.com/api/?name=Emma+Davis&background=10b981&color=fff" 
                                             class="rounded-circle" width="40" height="40" alt="Emma Davis">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800">Emma Davis</div>
                                        <div class="text-muted small">emma.davis@creative.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-800">Creative Agency</span>
                                <div class="text-muted small">Marketing</div>
                            </td>
                            <td>
                                <span class="badge" style="background-color: #fef3c7; color: #d97706;">Social Media</span>
                            </td>
                            <td>
                                <span class="badge" style="background-color: #f3f4f6; color: #6b7280;">New</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-circle-fill text-success me-1" style="font-size: 0.5rem;"></i>
                                    <span class="text-success fw-semibold">Low</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-success">$1,500</span>
                            </td>
                            <td>
                                <span class="text-muted">1 week ago</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-success" title="Convert Lead">
                                        <i class="bi bi-arrow-right-circle"></i>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-telephone me-2"></i>Call</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Email</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing 1 to 3 of 89 leads
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Add Lead Modal -->
<div class="modal fade" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeadModalLabel">Add New Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="leadFirstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="leadFirstName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="leadLastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="leadLastName" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="leadEmail" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="leadEmail" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="leadPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="leadPhone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="leadCompany" class="form-label">Company</label>
                                <input type="text" class="form-control" id="leadCompany">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="leadSource" class="form-label">Lead Source</label>
                                <select class="form-select" id="leadSource">
                                    <option value="">Select Source</option>
                                    <option value="website">Website</option>
                                    <option value="referral">Referral</option>
                                    <option value="cold_call">Cold Call</option>
                                    <option value="social_media">Social Media</option>
                                    <option value="trade_show">Trade Show</option>
                                    <option value="advertisement">Advertisement</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="leadStatus" class="form-label">Status</label>
                                <select class="form-select" id="leadStatus">
                                    <option value="new" selected>New</option>
                                    <option value="qualified">Qualified</option>
                                    <option value="contacted">Contacted</option>
                                    <option value="converted">Converted</option>
                                    <option value="lost">Lost</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="leadPriority" class="form-label">Priority</label>
                                <select class="form-select" id="leadPriority">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="leadValue" class="form-label">Estimated Value</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="leadValue" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="leadNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="leadNotes" rows="3" placeholder="Additional notes about this lead..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Lead</button>
            </div>
        </div>
    </div>
</div>

<style>
.pipeline-stage {
    padding: 1rem;
    border-radius: 8px;
    background-color: #f8fafc;
    margin: 0.5rem;
    transition: all 0.3s ease;
}

.pipeline-stage:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.pipeline-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.pipeline-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.avatar {
    position: relative;
}

.avatar img {
    object-fit: cover;
}
</style>
@endsection
