<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use App\Http\Requests\StoreLoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookLoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index(Request $request)
    {
        $loans = BookLoan::with(['book', 'user'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->user_id, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        $users = User::where('user_type', 'member')->get();
        
        return view('loans.index', compact('loans', 'users'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create(Book $book)
    {
        if (!$book->isAvailable()) {
            return redirect()->route('books.show', $book)
                ->with('error', 'This book is out of stock.');
        }

        $users = User::where('user_type', 'member')->get();
        return view('loans.create', compact('book', 'users'));
    }

    /**
     * Store a newly created loan.
     */
    public function borrow(StoreLoanRequest $request, Book $book)
    {
        if (!$book->isAvailable()) {
            return redirect()->route('books.show', $book)
                ->with('error', 'This book is out of stock.');
        }

        DB::transaction(function () use ($request, $book) {
            // Create the loan
            BookLoan::create([
                'user_id' => $request->user_id,
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'due_date' => now()->addDays($request->loan_days ?? 14),
                'notes' => $request->notes,
            ]);

            // Reduce stock
            $book->decrement('stock');
        });

        return redirect()->route('loans.index')
            ->with('success', 'Book borrowed successfully.');
    }

    /**
     * Return a borrowed book.
     */
    public function return(BookLoan $loan)
    {
        if ($loan->status !== 'borrowed') {
            return redirect()->route('loans.index')
                ->with('error', 'This book has already been returned.');
        }

        DB::transaction(function () use ($loan) {
            // Mark loan as returned
            $loan->markAsReturned();

            // Increase stock
            $loan->book->increment('stock');
        });

        return redirect()->route('loans.index')
            ->with('success', 'Book returned successfully.');
    }
}