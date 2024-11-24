@extends('layouts.layout')

@section('body')
    <div class="text-center mt-5">
        <h2>Book</h2>
    </div>
    
    <div class="container">
        <div class="text-center my-4">
            <a href="{{ route('book.add') }}" class="btn btn-primary w-75">Add New Book</a>
        </div>

        <table id="myTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Book ID.</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genres</th>
                    <th>Edit</th>
                    <th>Delete</th>
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
                    url: "{{ route('book.data') }}",
                    type: "GET",
                    datatype: "JSON",
                    error: function(xhr, error, thrown) {
                        console.error('Error occured:', thrown);
                        console.log('XHR:', xhr);
                    }
                },
                columnDefs: [
                    { targets: [0], data: 'no' },
                    { targets: [1], data: 'book_id' },
                    { targets: [2], data: 'title' },
                    { targets: [3], data: 'author' },
                    { targets: [4], data: 'genres' },
                    { 
                        targets: [5],
                        data: 'book_id',
                        render: function(data, type, row) {
                            // Create the edit URL
                            var url_edit = "{{ route('book.edit', 'data') }}";
                            url_edit = url_edit.replace("data", data);

                            // Return edit button
                            return '<a href="' + url_edit + '" class="editBook btn btn-primary">Edit</a>'
                        }
                    },
                    {
                        targets: [6],
                        data: 'book_id',
                        render: function(data, type, row) {
                            // Return delete button
                            var url_delete = "{{ route('book.delete', 'data') }}";
                            url_delete = url_delete.replace("data", data);

                            return `
                                        <form action="${url_delete}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="deleteBook btn btn-danger">Delete</button>
                                        </form>
                                    `;
                        }
                    }
                ]
            });
        });

    </script>
@endpush