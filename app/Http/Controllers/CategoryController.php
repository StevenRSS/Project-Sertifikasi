<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index() 
    {
        return view('category');
    }

    public function showAllData()
    {
        $query = Category::query();

        $results = $query->get();

        $results->each(function ($row, $index) {
            // Add the index numbering for the datatable
            $row->no = $index + 1;
        });

        // dd($results);

        return response()->json(['data' => $results]);
    }

    public function addCategory()
    {
        $title = "Add New Category";

        return view('category-form', [
            'title' => $title
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());

        $validated = $request->validate([
            'genre' => 'required|string',
        ]);
    
        // Create new Category data
        $category = Category::create([
            'genre' => $validated['genre']
        ]);
        
        return redirect()->route('category')->with('success', 'Category saved successfully!');
    }

    public function editCategory($category_id) 
    {
        $title = "Edit Category";

        $category = Category::findOrFail($category_id);

        return view('category-form', [
            'title' => $title,
            'category' => $category
        ]);
    }

    public function update(Request $request, $category_id)
    {
        $validated = $request->validate([
            'genre' => 'required|string',
        ]);
    
        $category = Category::findOrFail($category_id);

        $category->genre =$validated['genre'];

        $category->save();
    
        return redirect()->route('category');
    }

    public function delete($category_id)
    {
        $category = Category::findOrFail($category_id);

        $category->delete();

        return redirect()->route('category');
    }
}
