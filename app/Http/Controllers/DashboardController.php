<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Book;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\MemberHistory;
use App\Models\Member;

class DashboardController extends Controller
{
    public function showData(Request $request) 
    {
        $genres = Category::all();
        $category =  $request->category ?? null;
        $borrowed = $request->borrowed ?? false;

        return view('dashboard', [
            'category' => $category,
            'borrowed' => $borrowed,
            'genres' => $genres
        ]);
    }

    public function showAllData(Request $request)
    {
        $category = $request->category ?? null;
        $borrowed = $request->borrowed ?? false;

        // Start the query with relationships
        $query = MemberHistory::with(['book', 'member', 'book.categoryList.category']);

        // Filter by category if provided
        if ($category) {
            $query->whereHas('book', function ($q) use ($category) {
                $q->whereHas('categoryList', function ($q) use ($category) {
                    $q->where('category_id', $category); // Filter by category ID
                });
            });
        }

        // Filter by borrowed status if true
        if ($borrowed) {
            $query->whereNull('returned_at');
        }

        // Get the results
        $results = $query->get();

        // Process results to add index and category names
        $results->each(function ($row, $index) {
            // Add the index numbering for the datatable
            $row->no = $index + 1;

            // Concat category names to one column (handle empty categories gracefully)
            $categoryNames = $row->book->categoryList
                ->pluck('category.genre')
                ->implode(', ');

            // Add category names to the result
            $row->category_names = $categoryNames ?: 'No Category';
        });

        // Return results as a JSON response
        return response()->json(['data' => $results]);
    }


    public function addBorrow()
    {
        $title = "Add New Borrow";
        $member = Member::all();
        $book = Book::all();

        return view('borrow', [
            'title' => $title,
            'members' => $member,
            'books' => $book
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());

        $validated = $request->validate([
            'member_id' => 'required|string',
            'book_id' => 'required|string',
            'due_date' => 'required|date',
        ]);
    
        // Create new Borrow data
        $borrow = MemberHistory::create([
            'member_id' => $validated['member_id'],
            'book_id' => $validated['book_id'],
            'due_date' => $validated['due_date'],
            'returned_at' => null
        ]);
        
        return redirect()->route('dashboard');
    }

    public function editBorrow($borrow_id) 
    {
        $title = "Edit Borrow";

        $borrow = MemberHistory::findOrFail($borrow_id);

        $member = Member::all();
        $book = Book::all();

        // $member = Member::findOrFail($borrow->member_id);

        // $book = Member::findOrFail($book->book_id);

        return view('borrow', [
            'title' => $title,
            'borrow' => $borrow,
            'members' => $member,
            'books' => $book
        ]);
    }

    public function update(Request $request, $borrow_id)
    {
        $validated = $request->validate([
            'member_id' => 'required|string',
            'book_id' => 'required|string',
            'due_date' => 'required|date',
            'returned_status' => 'required',
        ]);
    
        $borrow = MemberHistory::findOrFail($borrow_id);

        $borrow->member_id = $validated['member_id'];
        $borrow->book_id = $validated['book_id'];
        $borrow->due_date = $validated['due_date'];

        if($validated['returned_status']) {
            $borrow->returned_at = Carbon::now();
        }

        $borrow->save();
    
        return redirect()->route('dashboard');
    }

    public function delete($borrow_id)
    {
        $borrow = MemberHistory::findOrFail($borrow_id);

        $borrow->delete();

        return redirect()->route('dashboard');
    }

}
