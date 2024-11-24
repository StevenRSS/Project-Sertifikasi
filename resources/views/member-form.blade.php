@extends('layouts.layout')

@section('body')

    <div class="container mt-5">
        <div class="text-center mb-3">
            <h2>{{ isset($member) ? 'Edit Member' : 'Add New Member' }}</h2>
        </div>

        <form action="{{ isset($member) ? route('member.update', $member->member_id) : route('member.store') }}" method="POST">
            @csrf

            {{-- Change method to PUT if editing --}}
            @if(isset($member))
                @method('PUT')
            @endif
            
            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Member's Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                    value="{{ old('name', isset($member) ? $member->name : '') }}" placeholder="Steven Rafael">
            </div>

            {{-- Phone --}}
            <div class="mb-3">
                <label for="phone" class="form-label">Member's Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" 
                    value="{{ old('phone', isset($member) ? $member->phone : '') }}" placeholder="08X-XXX-XXX-XXX">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Member's Email</label>
                <input type="text" class="form-control" id="email" name="email" 
                    value="{{ old('email', isset($member) ? $member->email : '') }}" placeholder="steven@gmail.com">
            </div>

            {{-- Address --}}
            <div class="mb-3">
                <label for="address" class="form-label">Member's Address</label>
                <input type="text" class="form-control" id="address" name="address" 
                    value="{{ old('address', isset($member) ? $member->address : '') }}" placeholder="Citraland...">
            </div>
            
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-50">{{ isset($member) ? 'Update' : 'Save' }}</button>
            </div>

        </form>
    </div>

@endsection

@push('js')
@endpush
