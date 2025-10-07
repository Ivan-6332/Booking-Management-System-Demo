@extends('layouts.app')

@section('title', 'Book Loans')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-exchange-alt"></i> Book Loans</h1>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('loans.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="user_id" class="form-label">User</label>
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('loans.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Loans List -->
@if($loans->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>User</th>
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
                                <td>{{ $loan->user->name }}</td>
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
        <i class="fas fa-info-circle"></i> No loans found.
        @if(request('status') || request('user_id'))
            Try adjusting your filters.
        @endif
    </div>
@endif
@endsection