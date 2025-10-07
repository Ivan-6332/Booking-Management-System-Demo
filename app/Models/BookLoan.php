<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Get the user that borrowed the book.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if the loan is overdue.
     */
    public function isOverdue()
    {
        return $this->status === 'borrowed' && $this->due_date < now();
    }

    /**
     * Get the number of days overdue.
     */
    public function daysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return now()->diffInDays($this->due_date);
    }

    /**
     * Mark the loan as returned.
     */
    public function markAsReturned()
    {
        $this->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);
    }

    /**
     * Scope to get overdue loans.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'borrowed')
                    ->where('due_date', '<', now());
    }

    /**
     * Scope to get current loans.
     */
    public function scopeCurrent($query)
    {
        return $query->where('status', 'borrowed');
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            if (!$loan->borrowed_at) {
                $loan->borrowed_at = now();
            }
            if (!$loan->due_date) {
                $loan->due_date = now()->addDays(14); // Default 14 days loan period
            }
        });
    }
}