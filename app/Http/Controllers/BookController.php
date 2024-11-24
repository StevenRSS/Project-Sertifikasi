<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Category;
use App\Models\CategoryList;

class BookController extends Controller
{
    public function index()
    {
        return view('book');
    }

    public function showAllData()
    {
        $query = Book::query();

        $results = $query->with(['categoryList'])
                   ->get();

        $results->each(function ($row, $index) {
            // Add the index numbering for the datatable
            $row->no = $index + 1;

            // Get all the genres for the current book and concat them
            $genres = $row->categoryList->pluck('genre')->implode(', ');
            
            $row->genres = $genres;
        });

        // dd($results);

        return response()->json(['data' => $results]);
    }
    
    public function addBook()
    {
        $title = "Add New Book";
        $categories = Category::all();

        return view('book-form', [
            'title' => $title,
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());

        $validated = $request->validate([
            'book_name' => 'required|string',
            'book_author' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:category,category_id'
        ]);
    
        // Create new Book data
        $book = Book::create([
            'title' => $validated['book_name'],
            'author' => $validated['book_author'],
        ]);

        // dd($book);

        // Create new CategoryList data for the selected categories
        foreach ($validated['categories'] as $categoryID) {
            // Get the category model to get the genre
            $category = Category::find($categoryID);

            if ($category) {
                CategoryList::create([
                    'book_id' => $book->book_id, 
                    'category_id' => $categoryID,
                    'genre' => $category->genre, 
                ]);
            }
        }
        
        return redirect()->route('book');
    }

    public function editBook($book_id) 
    {
        $title = "Edit Book";

        $book = Book::findOrFail($book_id);

        $categories = Category::all();

        // Get all the category_list related to book_id
        $category_list = CategoryList::where('book_id', $book_id)->pluck('category_id');

        return view('book-form', [
            'title' => $title,
            'book' => $book,
            'categories' => $categories,
            'category_list' => $category_list
        ]);
    }

    public function update(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);

        $validated = $request->validate([
            'book_name' => 'required|string',
            'book_author' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:category,category_id'
        ]);

        // Update the book data
        $book->title = $validated['book_name'];
        $book->author = $validated['book_author'];
        $book->save();

        // Delete the existing categoryList data first before adding it back
        $book->categoryList()->delete();

        // Adding back the categoryList
        foreach ($validated['categories'] as $categoryID) {
            // Get the category model to get the genre
            $category = Category::find($categoryID);
    
            if ($category) {
                CategoryList::create([
                    'book_id' => $book->book_id, 
                    'category_id' => $categoryID,
                    'genre' => $category->genre
                ]);
            }
        }

        return redirect()->route('book');
    }

    public function delete($book_id)
    {
        $book = Book::findOrFail($book_id);

        $book->delete();

        return redirect()->route('book');
    }

}
