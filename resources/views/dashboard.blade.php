@extends('layouts.app')

@section('content')
<div class="fade-in">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your CRM today.</p>
            </div>
            <div>
                <span class="badge bg-primary">{{ now()->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- New Leads Card -->
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card border-left-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">New Leads</div>
                            <div class="h4 mb-0 fw-bold text-dark">24</div>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 12% from last week</small>
                        </div>
                        <div class="col-auto">
                            <div class="icon-wrapper bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deals in Progress Card -->
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card border-left-success">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Deals in Progress</div>
                            <div class="h4 mb-0 fw-bold text-dark">18</div>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 8% from last week</small>
                        </div>
                        <div class="col-auto">
                            <div class="icon-wrapper bg-success bg-opacity-10 text-success">
                                <i class="bi bi-bar-chart-line-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue This Month Card -->
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card border-left-info">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Monthly Revenue</div>
                            <div class="h4 mb-0 fw-bold text-dark">$54,320</div>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 15% from last month</small>
                        </div>
                        <div class="col-auto">
                            <div class="icon-wrapper bg-info bg-opacity-10 text-info">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Tasks Card -->
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card border-left-warning">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Pending Tasks</div>
                            <div class="h4 mb-0 fw-bold text-dark">12</div>
                            <small class="text-warning"><i class="bi bi-clock"></i> 3 due today</small>
                        </div>
                        <div class="col-auto">
                            <div class="icon-wrapper bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-list-task"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Row -->
    <div class="row g-4">
        <!-- Activity Chart -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Activity Overview</h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="chartPeriod" id="week" checked>
                            <label class="btn btn-outline-primary" for="week">Week</label>
                            <input type="radio" class="btn-check" name="chartPeriod" id="month">
                            <label class="btn btn-outline-primary" for="month">Month</label>
                            <input type="radio" class="btn-check" name="chartPeriod" id="year">
                            <label class="btn btn-outline-primary" for="year">Year</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="content-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('leads.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Add New Lead
                        </a>
                        <a href="{{ route('deals.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>Create Deal
                        </a>
                        <a href="{{ route('activities.create') }}" class="btn btn-info">
                            <i class="bi bi-plus-circle me-2"></i>Schedule Activity
                        </a>
                        <a href="{{ route('companies.create') }}" class="btn btn-warning">
                            <i class="bi bi-plus-circle me-2"></i>Add Company
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="content-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">New lead created</h6>
                                <p class="text-muted small mb-1">John Doe from ABC Corp</p>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Deal won</h6>
                                <p class="text-muted small mb-1">$25,000 deal with XYZ Ltd</p>
                                <small class="text-muted">4 hours ago</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Meeting scheduled</h6>
                                <p class="text-muted small mb-1">Follow-up call with client</p>
                                <small class="text-muted">6 hours ago</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Task overdue</h6>
                                <p class="text-muted small mb-1">Send proposal to MegaCorp</p>
                                <small class="text-muted">8 hours ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Deals Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-currency-dollar me-2"></i>Recent Deals</h5>
                        <a href="{{ route('deals.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Deal Name</th>
                                    <th>Company</th>
                                    <th>Value</th>
                                    <th>Stage</th>
                                    <th>Expected Close</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Enterprise Software License</strong></td>
                                    <td>TechCorp Inc.</td>
                                    <td><span class="fw-bold text-success">$75,000</span></td>
                                    <td><span class="badge bg-info">Negotiation</span></td>
                                    <td>Dec 15, 2024</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Marketing Campaign</strong></td>
                                    <td>StartupXYZ</td>
                                    <td><span class="fw-bold text-success">$12,500</span></td>
                                    <td><span class="badge bg-warning">Proposal</span></td>
                                    <td>Jan 8, 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Consulting Services</strong></td>
                                    <td>MegaCorp Ltd.</td>
                                    <td><span class="fw-bold text-success">$45,000</span></td>
                                    <td><span class="badge bg-primary">Qualified</span></td>
                                    <td>Feb 20, 2025</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Activity Chart
    const ctx = document.getElementById('activityChart').getContext('2d');
    const activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['sales_trend']['labels']) !!},
            datasets: [{
                label: 'Activities',
                data: {!! json_encode($chartData['data']) !!},
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: 1,
                        color: '#64748b'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#64748b'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 1
                }
            },
            elements: {
                point: {
                    hoverRadius: 8
                }
            }
        }
    });

    // Add some animation to the stats cards
    const cards = document.querySelectorAll('.dashboard-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });
});
</script>

<style>
/* Timeline Styles */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 1rem;
    width: 2px;
    height: calc(100% - 0.5rem);
    background-color: #e2e8f0;
}

.timeline-marker {
    position: absolute;
    left: -1.75rem;
    top: 0.25rem;
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
}

.timeline-content h6 {
    color: #1e293b;
    font-size: 0.9rem;
}

/* Custom animations for dashboard cards */
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.dashboard-card .h4 {
    animation: countUp 0.8s ease-out forwards;
}
</style>
@endsection
