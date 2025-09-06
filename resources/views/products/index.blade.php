@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-box text-primary"></i> Products
                    </h5>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Product
                    </a>
                </div>

                <!-- Filters -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Search products...">
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="is_active" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" class="form-control" name="min_price" 
                                   value="{{ request('min_price') }}" placeholder="Min Price">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-initial bg-light rounded">
                                                            <i class="fas fa-box text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $product->name }}</div>
                                                        @if($product->description)
                                                            <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <code>{{ $product->sku }}</code>
                                            </td>
                                            <td>
                                                @if($product->category)
                                                    <span class="badge bg-light text-dark">{{ $product->category }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-medium">${{ number_format($product->unit_price, 2) }}</div>
                                                @if($product->cost_price)
                                                    <small class="text-muted">Cost: ${{ number_format($product->cost_price, 2) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->stock_quantity !== null)
                                                    <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                                        {{ $product->stock_quantity }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('products.show', $product) }}">View</a></li>
                                                        <li><a class="dropdown-item" href="{{ route('products.edit', $product) }}">Edit</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" 
                                                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-box text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted">No Products Found</h5>
                            <p class="text-muted">Add your first product to the catalog.</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-initial {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}
</style>
@endpush
