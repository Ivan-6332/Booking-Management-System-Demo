@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-book"></i> Books</h1>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Book
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('books.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search by title or author...">
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Books List -->
@if($books->count() > 0)
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">
                            <strong>Author:</strong> {{ $book->author }}<br>
                            <strong>Category:</strong> {{ $book->category->name }}<br>
                            <strong>Price:</strong> ${{ number_format($book->price, 2) }}<br>
                            <strong>Stock:</strong> 
                            <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $book->stock }} {{ $book->stock == 1 ? 'copy' : 'copies' }}
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if($book->stock > 0)
                                <a href="{{ route('loans.create', $book) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-hand-point-right"></i> Borrow
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-ban"></i> Out of Stock
                                </button>
                            @endif
                        </div>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="mt-2" 
                              onsubmit="return confirm('Are you sure you want to delete this book?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>
@else
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> No books found.
        @if(request('search') || request('category'))
            Try adjusting your filters.
        @endif
    </div>
@endif
@endsection