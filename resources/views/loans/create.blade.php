@extends('layouts.app')

@section('title', 'Borrow Book')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-hand-point-right"></i> Borrow Book: {{ $book->title }}</h4>
            </div>
            <div class="card-body">
                <!-- Book Information -->
                <div class="alert alert-info">
                    <h5><i class="fas fa-book"></i> Book Details</h5>
                    <p class="mb-1"><strong>Title:</strong> {{ $book->title }}</p>
                    <p class="mb-1"><strong>Author:</strong> {{ $book->author }}</p>
                    <p class="mb-1"><strong>Category:</strong> {{ $book->category->name }}</p>
                    <p class="mb-1"><strong>Available Copies:</strong> {{ $book->availableCopies() }}</p>
                    <p class="mb-0"><strong>Price:</strong> ${{ number_format($book->price, 2) }}</p>
                </div>

                @if($book->availableCopies() > 0)
                    <form action="{{ route('loans.borrow', $book) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" 
                                    id="user_id" name="user_id" required>
                                <option value="">Select a user</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="loan_days" class="form-label">Loan Period (Days)</label>
                            <input type="number" class="form-control @error('loan_days') is-invalid @enderror" 
                                   id="loan_days" name="loan_days" value="{{ old('loan_days', 14) }}" 
                                   min="1" max="30">
                            <div class="form-text">Default is 14 days. Maximum is 30 days.</div>
                            @error('loan_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any additional notes about this loan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Book
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-hand-point-right"></i> Borrow Book
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle"></i> Book Not Available</h5>
                        <p>Sorry, this book is currently out of stock. All copies are currently borrowed.</p>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Book
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection