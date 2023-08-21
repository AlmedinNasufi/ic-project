<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'ISBN' => '9780743273565',
                'publication_date' => '1925-04-10',
                'categories' => ['Fiction', 'Fantasy'],
            ],
            [
                'title' => 'Moby Dick',
                'author' => 'Herman Melville',
                'ISBN' => '9780142000083',
                'publication_date' => '1851-10-18',
                'categories' => ['Non-Fiction', 'Fantasy'],

            ],
            [
                'title' => 'The Universe in a Nutshell',
                'author' => 'Stephen Hawking',
                'ISBN' => '9780553802023',
                'publication_date' => '2001-11-06',
                'categories' => ['Fiction', 'Mystery'],

            ],
            [
                'title' => 'A Game of Thrones',
                'author' => 'George R.R. Martin',
                'ISBN' => '9780553103540',
                'publication_date' => '1996-08-01',
                'categories' => ['Mystery', 'Romance'],

            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'ISBN' => '9780451524935',
                'publication_date' => '1949-06-08',
                'categories' => ['Biography', 'Horror'],

            ],
        ];

        foreach ($books as $bookData) {
            $bookId = DB::table('books')->insertGetId([
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'ISBN' => $bookData['ISBN'],
                'publication_date' => $bookData['publication_date'],
            ]);

            foreach ($bookData['categories'] as $categoryName) {
                $categoryId = DB::table('categories')->where('name', $categoryName)->first()->id;
                DB::table('book_category')->insert([
                    'book_id' => $bookId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
