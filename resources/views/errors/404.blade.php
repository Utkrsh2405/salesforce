@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    <div class="text-center">
        <div class="error-illustration mb-4">
            <div class="error-number">404</div>
            <div class="error-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
        
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-description text-muted mb-4">
            The page you're looking for doesn't exist or has been moved.
        </p>
        
        <div class="error-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-primary me-3">
                <i class="bi bi-house-door me-2"></i>Go to Dashboard
            </a>
            <button onclick="history.back()" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Go Back
            </button>
        </div>
        
        <div class="mt-5">
            <small class="text-muted">
                Need help? <a href="#" class="text-decoration-none">Contact Support</a>
            </small>
        </div>
    </div>
</div>

<style>
.error-number {
    font-size: 8rem;
    font-weight: 900;
    color: #e2e8f0;
    line-height: 1;
    position: relative;
}

.error-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 3rem;
    color: #f59e0b;
}

.error-illustration {
    position: relative;
    display: inline-block;
}

.error-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.error-description {
    font-size: 1.125rem;
    max-width: 500px;
    margin: 0 auto;
}
</style>
@endsection
