@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Contacts</h1>
            <p class="text-muted mb-0">Manage your customer contacts</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">
                <i class="bi bi-plus-circle me-2"></i>Add Contact
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Contacts
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">156</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Contacts
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">142</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                New This Month
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">23</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-plus text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                VIP Contacts
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-star text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search contacts...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Companies</option>
                        <option value="acme">Acme Corp</option>
                        <option value="globex">Globex Industries</option>
                        <option value="initech">Initech</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-gray-800">Contact List</h6>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-secondary active">
                        <i class="bi bi-list"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-grid"></i>
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
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>Contact</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Last Contact</th>
                            <th width="100">Actions</th>
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
                                    <div class="avatar avatar-sm me-3 status-online">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=3b82f6&color=fff" 
                                             class="rounded-circle" width="40" height="40" alt="John Doe">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800">John Doe</div>
                                        <div class="text-muted small">Marketing Manager</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-800">Acme Corp</span>
                            </td>
                            <td>
                                <a href="mailto:john.doe@acme.com" class="text-decoration-none">john.doe@acme.com</a>
                            </td>
                            <td>
                                <a href="tel:+1234567890" class="text-decoration-none">+1 (234) 567-890</a>
                            </td>
                            <td>
                                <span class="badge badge-success">Active</span>
                            </td>
                            <td>
                                <span class="text-muted">2 days ago</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Send Email</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
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
                                        <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=10b981&color=fff" 
                                             class="rounded-circle" width="40" height="40" alt="Jane Smith">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800">Jane Smith</div>
                                        <div class="text-muted small">Sales Director</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-800">Globex Industries</span>
                            </td>
                            <td>
                                <a href="mailto:jane.smith@globex.com" class="text-decoration-none">jane.smith@globex.com</a>
                            </td>
                            <td>
                                <a href="tel:+1234567891" class="text-decoration-none">+1 (234) 567-891</a>
                            </td>
                            <td>
                                <span class="badge badge-warning">VIP</span>
                            </td>
                            <td>
                                <span class="text-muted">1 week ago</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Send Email</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
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
                                        <img src="https://ui-avatars.com/api/?name=Bob+Johnson&background=f59e0b&color=fff" 
                                             class="rounded-circle" width="40" height="40" alt="Bob Johnson">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800">Bob Johnson</div>
                                        <div class="text-muted small">IT Specialist</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-800">Initech</span>
                            </td>
                            <td>
                                <a href="mailto:bob.johnson@initech.com" class="text-decoration-none">bob.johnson@initech.com</a>
                            </td>
                            <td>
                                <a href="tel:+1234567892" class="text-decoration-none">+1 (234) 567-892</a>
                            </td>
                            <td>
                                <span class="badge badge-info">Inactive</span>
                            </td>
                            <td>
                                <span class="text-muted">3 weeks ago</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Send Email</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                    </ul>
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
                    Showing 1 to 3 of 156 contacts
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

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContactModalLabel">Add New Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company" class="form-label">Company</label>
                                <select class="form-select" id="company">
                                    <option value="">Select Company</option>
                                    <option value="acme">Acme Corp</option>
                                    <option value="globex">Globex Industries</option>
                                    <option value="initech">Initech</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" class="form-control" id="position">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save Contact</button>
            </div>
        </div>
    </div>
</div>
@endsection
