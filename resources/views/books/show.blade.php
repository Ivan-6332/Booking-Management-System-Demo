@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-book"></i> {{ $book->title }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Author:</strong> {{ $book->author }}</p>
                        <p><strong>Category:</strong> {{ $book->category->name }}</p>
                        <p><strong>Price:</strong> ${{ number_format($book->price, 2) }}</p>
                        <p><strong>Stock:</strong> 
                            <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $book->stock }} {{ $book->stock == 1 ? 'copy' : 'copies' }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Added:</strong> {{ $book->created_at->format('M d, Y') }}</p>
                        <p><strong>Last Updated:</strong> {{ $book->updated_at->format('M d, Y') }}</p>
                        <p><strong>Available Copies:</strong> {{ $book->availableCopies() }}</p>
                        <p><strong>Currently Borrowed:</strong> {{ $book->currentLoans->count() }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="btn-group" role="group">
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Book
                        </a>
                        @if($book->stock > 0)
                            <a href="{{ route('loans.create', $book) }}" class="btn btn-success">
                                <i class="fas fa-hand-point-right"></i> Borrow This Book
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-ban"></i> Out of Stock
                            </button>
                        @endif
                    </div>
                    
                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline ms-2"
                          onsubmit="return confirm('Are you sure you want to delete this book?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Book
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-exchange-alt"></i> Current Loans</h5>
            </div>
            <div class="card-body">
                @if($book->currentLoans->count() > 0)
                    @foreach($book->currentLoans as $loan)
                        <div class="border-bottom pb-2 mb-2">
                            <p class="mb-1"><strong>{{ $loan->user->name }}</strong></p>
                            <p class="mb-1 text-muted small">
                                Borrowed: {{ $loan->borrowed_at->format('M d, Y') }}<br>
                                Due: {{ $loan->due_date->format('M d, Y') }}
                                @if($loan->isOverdue())
                                    <span class="text-danger">({{ $loan->daysOverdue() }} days overdue)</span>
                                @endif
                            </p>
                            <form action="{{ route('loans.return', $loan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-primary btn-sm"
                                        onclick="return confirm('Mark this book as returned?')">
                                    <i class="fas fa-undo"></i> Return
                                </button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No current loans for this book.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('books.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Books
    </a>
</div>
@endsection