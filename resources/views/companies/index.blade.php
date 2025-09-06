<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white">
                    <div class="mt-8 text-2xl flex justify-between">
                        <div>Companies</div>
                        <div>
                            <x-button href="{{ route('companies.create') }}">
                                {{ __('Add New Company') }}
                            </x-button>
                        </div>
                    </div>

                    <div class="mt-6">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Industry</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @extends('layouts.app')

@section('content')
<div class="fade-in">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Companies</h1>
                <p class="text-muted mb-0">Manage your company contacts and relationships</p>
            </div>
            <div>
                <a href="{{ route('companies.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Company
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="dashboard-card border-left-primary">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-primary bg-opacity-10 text-primary me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-building-fill"></i>
                        </div>
                        <div>
                            <div class="h5 mb-0 fw-bold">{{ $companies->total() ?? 156 }}</div>
                            <small class="text-muted">Total Companies</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card border-left-success">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-success bg-opacity-10 text-success me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <div class="h5 mb-0 fw-bold">89</div>
                            <small class="text-muted">Active Clients</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card border-left-info">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-info bg-opacity-10 text-info me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div>
                            <div class="h5 mb-0 fw-bold">34</div>
                            <small class="text-muted">Prospects</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card border-left-warning">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper bg-warning bg-opacity-10 text-warning me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <div class="h5 mb-0 fw-bold">23</div>
                            <small class="text-muted">Follow-ups Due</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Table -->
    <div class="content-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-building me-2"></i>All Companies</h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="Search companies..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">All Companies</a></li>
                            <li><a class="dropdown-item" href="#">Active Clients</a></li>
                            <li><a class="dropdown-item" href="#">Prospects</a></li>
                            <li><a class="dropdown-item" href="#">Inactive</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Company</th>
                            <th>Industry</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Last Contact</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($companies ?? [
                            (object)['id' => 1, 'name' => 'TechCorp Inc.', 'industry' => 'Technology', 'size' => 'Large', 'status' => 'Active', 'assigned_to' => 'John Doe', 'last_contact' => '2024-12-01'],
                            (object)['id' => 2, 'name' => 'StartupXYZ', 'industry' => 'E-commerce', 'size' => 'Small', 'status' => 'Prospect', 'assigned_to' => 'Jane Smith', 'last_contact' => '2024-11-28'],
                            (object)['id' => 3, 'name' => 'MegaCorp Ltd.', 'industry' => 'Manufacturing', 'size' => 'Enterprise', 'status' => 'Active', 'assigned_to' => 'Mike Johnson', 'last_contact' => '2024-12-02'],
                            (object)['id' => 4, 'name' => 'InnovateLabs', 'industry' => 'Research', 'size' => 'Medium', 'status' => 'Follow-up', 'assigned_to' => 'Sarah Wilson', 'last_contact' => '2024-11-25'],
                            (object)['id' => 5, 'name' => 'GlobalTrade Co.', 'industry' => 'Import/Export', 'size' => 'Large', 'status' => 'Active', 'assigned_to' => 'David Brown', 'last_contact' => '2024-12-03']
                        ] as $company)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <span class="text-primary fw-bold">{{ substr($company->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">
                                                <a href="#" class="text-decoration-none text-dark hover-primary">{{ $company->name }}</a>
                                            </div>
                                            <small class="text-muted">{{ $company->email ?? 'contact@' . strtolower(str_replace(' ', '', $company->name)) . '.com' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $company->industry ?? 'Technology' }}</span>
                                </td>
                                <td>
                                    @php
                                        $sizeClass = match($company->size ?? 'Medium') {
                                            'Small' => 'bg-info',
                                            'Medium' => 'bg-warning',
                                            'Large' => 'bg-success',
                                            'Enterprise' => 'bg-primary',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $sizeClass }}">{{ $company->size ?? 'Medium' }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($company->status ?? 'Active') {
                                            'Active' => 'bg-success',
                                            'Prospect' => 'bg-info',
                                            'Follow-up' => 'bg-warning',
                                            'Inactive' => 'bg-secondary',
                                            default => 'bg-primary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $company->status ?? 'Active' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px;">
                                            <span class="text-secondary" style="font-size: 0.7rem;">{{ substr($company->assigned_to ?? 'John Doe', 0, 1) }}</span>
                                        </div>
                                        <small>{{ $company->assigned_to ?? 'John Doe' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($company->last_contact ?? '2024-12-01')->format('M d, Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-building" style="font-size: 3rem;"></i>
                                        <h5 class="mt-3">No companies found</h5>
                                        <p>Get started by adding your first company.</p>
                                        <a href="{{ route('companies.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Add Company
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($companies) && $companies->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of {{ $companies->total() }} results
                </small>
                {{ $companies->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const companyName = row.querySelector('td:first-child .fw-semibold').textContent.toLowerCase();
            const industry = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            
            if (companyName.includes(searchTerm) || industry.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Add hover effects
    document.querySelectorAll('.hover-primary').forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.color = 'var(--primary-color)';
        });
        element.addEventListener('mouseleave', function() {
            this.style.color = '';
        });
    });
});
</script>
@endsection
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">{{ $company->industry->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $company->company_size ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                            {{ $company->assignedUser->name ?? 'Unassigned' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                            <a href="{{ route('companies.edit', $company) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this company?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-center">
                                            No companies found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <div class="mt-4">
                            {{ $companies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
