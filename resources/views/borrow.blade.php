@extends('layouts.layout')

@section('body')
<div class="container mt-5">
    <div class="text-center mb-3">
        <h2>{{ $title }}</h2>
    </div>

    <form action="{{ isset($borrow) ? route('borrow.update', $borrow->borrow_id) : route('borrow.store') }}" method="POST">
        @csrf
        @if(isset($borrow))
            @method('PUT') {{-- Use PUT method for updates --}}
        @endif

        {{-- Select Member --}}
        <div class="mb-3">
            <label for="member" class="form-label">Select Member</label>
            <select class="form-select" id="member" name="member_id" required>
                <option value="">-- Select Member --</option>
                @foreach($members as $member)
                    <option value="{{ $member->member_id }}" 
                        {{ isset($borrow) && $borrow->member_id == $member->member_id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Select Book --}}
        <div class="mb-3">
            <label for="book" class="form-label">Select Book</label>
            <select class="form-select" id="book" name="book_id" required>
                <option value="">-- Select Book --</option>
                @foreach($books as $book)
                    <option value="{{ $book->book_id }}" 
                        {{ isset($borrow) && $borrow->book_id == $book->book_id ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Due Date --}}
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" 
                value="{{ isset($borrow) ? $borrow->due_date : '' }}" required>
        </div>

        {{-- Returned Status --}}
        <div class="mb-3">
            <label class="form-label">Returned Status</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="returned_status" id="returned" value="true" 
                           {{ isset($borrow) && $borrow->returned_at ? 'checked' : '' }}>
                    <label class="form-check-label" for="returned">Returned</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="returned_status" id="not_returned" value="false" 
                           {{ isset($borrow) && !$borrow->returned_at ? 'checked' : '' }}>
                    <label class="form-check-label" for="not_returned">Not Returned</label>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50">{{ isset($borrow) ? 'Update Borrow' : 'Add Borrow' }}</button>
        </div>
    </form>
</div>
@endsection
