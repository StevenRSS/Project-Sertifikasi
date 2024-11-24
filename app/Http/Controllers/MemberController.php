<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Member;

class MemberController extends Controller
{
    public function index() 
    {
        return view('member');
    }

    public function showAllData()
    {
        $query = Member::query();

        $results = $query->get();

        $results->each(function ($row, $index) {
            // Add the index numbering for the datatable
            $row->no = $index + 1;
        });

        // dd($results);

        return response()->json(['data' => $results]);
    }

    public function addMember()
    {
        $title = "Add New Member";

        return view('member-form', [
            'title' => $title
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);
    
        // Create new Member data
        $member = Member::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
        ]);
        
        return redirect()->route('member');
    }

    public function editMember($member_id) 
    {
        $title = "Edit Member";

        $member = Member::findOrFail($member_id);

        return view('member-form', [
            'title' => $title,
            'member' => $member
        ]);
    }

    public function update(Request $request, $member_id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);
    
        $member = Member::findOrFail($member_id);

        $member->name =$validated['name'];
        $member->phone =$validated['phone'];
        $member->email =$validated['email'];
        $member->address =$validated['address'];

        $member->save();
    
        return redirect()->route('member');
    }

    public function delete($member_id)
    {
        $member = Member::findOrFail($member_id);

        $member->delete();

        return redirect()->route('member');
    }
}
