@extends('layouts.layout')

@section('body')
    <div class="text-center mt-5">
        <h2>Book Management</h2>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('borrow.add') }}" class="btn btn-primary w-75">Borrow Book</a>
    </div>

    

    <div class="container">
        <table id="myTable" class="table-responsive">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Member Name.</th>
                    <th>Book Name.</th>
                    <th>Category.</th>
                    <th>Due Date.</th>
                    <th>Returned At.</th>
                    <th>Edit.</th>
                    <th>Delete.</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    
@endsection

@push('js')
    <script>
        $(document).ready( function () {
            
            let header = $('#myTable').DataTable({
                ajax: {
                    url: "{{ route('dashboard.data') }}",
                    type: "GET",
                    datatype: "JSON",
                    data: {
                        category: "{{ $category }}",
                        borrowed: "{{ $borrowed }}"
                    },
                    error: function(xhr, error, thrown) {
                        console.error('Error occured:', thrown);
                        console.log('XHR:', xhr);
                    }
                },
                columnDefs: [
                    { targets: [0], data: 'no' },
                    { targets: [1], data: 'member.name' },
                    { targets: [2], data: 'book.title' },
                    { targets: [3], data: 'category_names' },
                    { targets: [4], data: 'due_date' },
                    { targets: [5], data: 'returned_at' },
                    { 
                        targets: [6],
                        data: 'borrow_id',
                        render: function(data, type, row) {
                            // Create the edit URL
                            var url_edit = "{{ route('borrow.edit', 'data') }}";
                            url_edit = url_edit.replace("data", data);

                            // Return edit button
                            return '<a href="' + url_edit + '" class="btn btn-primary">Edit</a>'
                        }
                    },
                    {
                        targets: [7],
                        data: 'borrow_id',
                        render: function(data, type, row) {
                            // Return delete button
                            var url_delete = "{{ route('borrow.delete', 'data') }}";
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
            })
        })
    </script>
@endpush