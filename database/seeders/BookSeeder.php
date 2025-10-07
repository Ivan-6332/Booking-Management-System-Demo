<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookCategory;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $categories = BookCategory::all();

        $books = [
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'price' => 15.99,
                'stock' => 10,
                'book_category_id' => $categories->where('name', 'Fiction')->first()->id,
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'price' => 13.50,
                'stock' => 8,
                'book_category_id' => $categories->where('name', 'Fiction')->first()->id,
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'price' => 14.25,
                'stock' => 12,
                'book_category_id' => $categories->where('name', 'Fiction')->first()->id,
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'price' => 18.99,
                'stock' => 6,
                'book_category_id' => $categories->where('name', 'Science')->first()->id,
            ],
            [
                'title' => 'The Immortal Life of Henrietta Lacks',
                'author' => 'Rebecca Skloot',
                'price' => 16.75,
                'stock' => 5,
                'book_category_id' => $categories->where('name', 'Science')->first()->id,
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'price' => 45.00,
                'stock' => 15,
                'book_category_id' => $categories->where('name', 'Technology')->first()->id,
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas',
                'price' => 42.50,
                'stock' => 8,
                'book_category_id' => $categories->where('name', 'Technology')->first()->id,
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'price' => 19.99,
                'stock' => 20,
                'book_category_id' => $categories->where('name', 'History')->first()->id,
            ],
            [
                'title' => 'The Art of War',
                'author' => 'Sun Tzu',
                'price' => 12.99,
                'stock' => 7,
                'book_category_id' => $categories->where('name', 'History')->first()->id,
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'price' => 17.99,
                'stock' => 25,
                'book_category_id' => $categories->where('name', 'Non-Fiction')->first()->id,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}