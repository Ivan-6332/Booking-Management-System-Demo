@extends('layouts.app')

@section('title', $user->name . ' - Loan History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user"></i> {{ $user->name }} - Loan History</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Users
    </a>
</div>

<!-- User Information -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>User Type:</strong> 
                    <span class="badge {{ $user->user_type == 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                        {{ ucfirst($user->user_type) }}
                    </span>
                </p>
                <p><strong>Current Loans:</strong> {{ $user->currentLoans->count() }}</p>
                <p><strong>Total Loans:</strong> {{ $loans->total() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Loans History -->
@if($loans->count() > 0)
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-history"></i> Loan History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Borrowed Date</th>
                            <th>Due Date</th>
                            <th>Returned Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>
                                    <strong>{{ $loan->book->title }}</strong><br>
                                    <small class="text-muted">by {{ $loan->book->author }}</small>
                                </td>
                                <td>{{ $loan->borrowed_at->format('M d, Y') }}</td>
                                <td>
                                    {{ $loan->due_date->format('M d, Y') }}
                                    @if($loan->isOverdue())
                                        <br><small class="text-danger">{{ $loan->daysOverdue() }} days overdue</small>
                                    @endif
                                </td>
                                <td>
                                    @if($loan->returned_at)
                                        {{ $loan->returned_at->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">Not returned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($loan->status == 'borrowed')
                                        @if($loan->isOverdue())
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-warning">Borrowed</span>
                                        @endif
                                    @else
                                        <span class="badge bg-success">Returned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($loan->status == 'borrowed')
                                        <form action="{{ route('loans.return', $loan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                    onclick="return confirm('Mark this book as returned?')">
                                                <i class="fas fa-undo"></i> Return
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $loans->links() }}
    </div>
@else
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> This user has no loan history.
    </div>
@endif
@endsection