@extends('layouts.layout')

@section('body')
    <div class="text-center mt-5">
        <h2>Member</h2>
    </div>
    <div class="container">
        <div class="text-center my-4">
            <a href="{{ route('member.add') }}" class="btn btn-primary w-75">Add New Member</a>
        </div>

        <table id="myTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Member ID.</th>
                    <th>Name.</th>
                    <th>Phone.</th>
                    <th>Email.</th>
                    <th>Address.</th>
                    <th>Edit.</th>
                    <th>Delete.</th>
                </tr>
            </thead>
        </table>
    </div>

    
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                ajax: {
                    url: "{{ route('member.data') }}",
                    type: "GET",
                    datatype: "JSON",
                    error: function(xhr, error, thrown) {
                        console.error('Error occured:', thrown);
                        console.log('XHR:', xhr);
                    }
                },
                columnDefs: [
                    { targets: [0], data: 'no' },
                    { targets: [1], data: 'member_id' },
                    { targets: [2], data: 'name' },
                    { targets: [3], data: 'phone' },
                    { targets: [4], data: 'email' },
                    { targets: [5], data: 'address' },
                    { 
                        targets: [6],
                        data: 'member_id',
                        render: function(data, type, row) {
                            // Create the edit URL
                            var url_edit = "{{ route('member.edit', 'data') }}";
                            url_edit = url_edit.replace("data", data);

                            // Return edit button
                            return '<a href="' + url_edit + '" class="btn btn-primary">Edit</a>'
                        }
                    },
                    {
                        targets: [7],
                        data: 'member_id',
                        render: function(data, type, row) {
                            // Return delete button
                            var url_delete = "{{ route('member.delete', 'data') }}";
                            url_delete = url_delete.replace("data", data);

                            return `
                                        <form action="${url_delete}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush