@extends('layouts.layout')

@section('body')

    <div class="container mt-5">
        <div class="text-center mb-3">
            <h2>{{ $title }}</h2>
        </div>

        {{-- Dynamically changing the form based on use case (edit/create) --}}
        <form action="{{ isset($book) ? route('book.update', $book->book_id) : route('book.store') }}" method="POST">
            @csrf

            {{-- Change method if there is $book --}}
            @if(isset($book))
                @method('PUT')
            @endif
            
            {{-- Book Title --}}
            <div class="mb-3">
                <label for="book_name" class="form-label">Book Name</label>
                <input type="text" class="form-control" id="book_name" name="book_name" 
                    value="{{ old('book_name', isset($book) ? $book->title : '') }}" placeholder="Atomic Habits">
            </div>

            {{-- Book Author --}}
            <div class="mb-5">
                <label for="book_author" class="form-label">Book Author</label>
                <input type="text" class="form-control" id="book_author" name="book_author" 
                    value="{{ old('book_author', isset($book) ? $book->author : '') }}" placeholder="James Clear">
            </div>

            {{-- Categories --}}
            <div class="mb-3">
                <label class="form-label">Select Categories</label>
                <div>
                    @foreach($categories as $category)
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="categories[]" 
                                id="category_{{ $category->category_id }}" 
                                value="{{ $category->category_id }}"
                                @if(isset($category_list) && in_array($category->category_id, $category_list->toArray())) checked @endif>
                            <label class="form-check-label" for="category_{{ $category->category_id }}">
                                {{ $category->genre }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-50">{{ isset($book) ? 'Update' : 'Create' }}</button>
            </div>

        </form>
    </div>

@endsection

@push('js')
    <script>
        $('form').submit(function (event) {
            // Optional additional form handling or validation
        });
    </script>
@endpush
