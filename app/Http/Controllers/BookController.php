<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(auth()->user()->role->name !== 'Admin') {
            return $this->getUserBooks();
        }
        else {
            return $this->getAllBooks();
        }

    }


    private function getAllBooks() {
        try{

            $books = Book::with(['categories'])->orderBy('publication_date', 'DESC')->get();

            return response()->json($books);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }
    }

    private function getUserBooks() {
        try {
            $user = auth()->user();

            $preferredCategoryIds = $user->preferredCategories->pluck('id');

            $books = Book::whereHas('categories', function ($query) use ($preferredCategoryIds) {
                $query->whereIn('categories.id', $preferredCategoryIds);
            })->orderBy('publication_date', 'DESC')->get();

            return $books;
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'ISBN' => 'required|string|unique:books',
                'publication_date' => 'required|date',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $book = new Book();
            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->ISBN = $request->input('ISBN');
            $book->publication_date = $request->input('publication_date');
            $book->save();

            $book->categories()->sync($request->input('categories'));
            $book->load('categories');


            return response()->json($book, 201);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $book = Book::with('categories')->find($id);

            if(!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }

            $user = auth()->user();
            if($user->role->name !== 'Admin') {

                $preferredCategoryIds = $user->preferredCategories->pluck('id');
                $bookCategoryIds = $book->categories->pluck('id');
                $commonCategories = $bookCategoryIds->intersect($preferredCategoryIds);

                if ($commonCategories->isEmpty()) {
                    return response()->json(['message' => 'You do not have access to view this book'], 403);
                }
            }

            return response()->json($book);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $book = Book::find($id);

            if(!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|string|max:255',
                'author' => 'sometimes|string|max:255',
                'ISBN' => 'sometimes|string|unique:books,ISBN,' . $id,
                'publication_date' => 'sometimes|date',
                'categories' => 'sometimes|array',
                'categories.*' => 'exists:categories,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $book->fill($request->all());
            $book->save();


            if ($request->has('categories')) {
                $book->categories()->sync($request->input('categories'));
            }

            $book->load('categories');

            return response()->json($book);

        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Book::find($id);

            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }

            $book->delete();
            return response()->json(['message' => 'Book deleted successfully']);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }

    }


    public function search(Request $request)
    {
        try{
            $query = Book::query();


            // Search by author
            if ($request->has('author')) {
                $query->where('author', 'LIKE', '%' . $request->input('author') . '%');
            }

            // Search by title
            if ($request->has('title')) {
                $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
            }

            // Search by ISBN
            if ($request->has('ISBN')) {
                $query->where('ISBN', $request->input('ISBN'));
            }

            $user = auth()->user();
            if($user->role->name !== 'Admin') {

                $preferredCategoryIds = $user->preferredCategories->pluck('id');

                $query->whereHas('categories', function ($query) use ($preferredCategoryIds) {
                    $query->whereIn('categories.id', $preferredCategoryIds);
                });
            }


            $books = $query->orderBy('publication_date', 'DESC')->get();

            return response()->json($books);

        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);

        }
    }


}
