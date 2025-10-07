<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'price',
        'stock',
        'book_category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Get the category that the book belongs to.
     */
    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }

    /**
     * Get the loans for the book.
     */
    public function loans()
    {
        return $this->hasMany(BookLoan::class);
    }

    /**
     * Get the currently borrowed loans for the book.
     */
    public function currentLoans()
    {
        return $this->hasMany(BookLoan::class)->where('status', 'borrowed');
    }

    /**
     * Check if book is available for borrowing.
     */
    public function isAvailable()
    {
        return $this->stock > 0;
    }

    /**
     * Get the number of available copies.
     */
    public function availableCopies()
    {
        return $this->stock - $this->currentLoans()->count();
    }

    /**
     * Scope to filter books by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('book_category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Scope to search books by title or author.
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }
}