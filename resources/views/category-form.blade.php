@extends('layouts.layout')

@section('body')

    <div class="container mt-5">
        <div class="text-center mb-3">
            <h2>{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h2>
        </div>

        <form action="{{ isset($category) ? route('category.update', $category->category_id) : route('category.store') }}" method="POST">
            @csrf

            {{-- Change method to PUT if editing --}}
            @if(isset($category))
                @method('PUT')
            @endif
            
            {{-- Genre --}}
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" 
                    value="{{ old('genre', isset($category) ? $category->genre : '') }}" placeholder="Fantasy">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-50">{{ isset($category) ? 'Update' : 'Save' }}</button>
            </div>
        </form>
    </div>

@endsection

@push('js')

@endpush
