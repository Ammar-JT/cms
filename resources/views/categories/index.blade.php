@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{route('categories.create')}}" class="btn btn-success">Add Category</a>
    </div>
    <div class="card card-default">
        <div class="card-header">Categories</div>
        <div class="card-body">
            @include('inc.messages')
            
            @if ($categories->count()>0)
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Post Number</th>
                        <th></th>

                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    {{$category->name}}
                                </td>
                                <td>
                                    {{$category->posts->count()}}
                                </td>

                                <td>
                                    <a href="{{route('categories.edit', $category->id)}}" class="btn btn-info btn-sm">Edit</a>
    <!-- ================================================================================================================= -->
    <!--                Delete specific record using from an iteration : Modal + JS code + Laravel                         -->
    <!-- ================================================================================================================== -->
                                    <button class="btn btn-danger btn-sm" onclick="handleDelete({{$category->id}})">Delete</button>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center">No Categories Yet</h3>
            @endif
        </div>
    </div>


    <!-- modals -->
    <div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <form action="" method="POST" id="deleteCategoryForm">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function handleDelete(id){
            var form = document.getElementById('deleteCategoryForm');
            form.action = '/categories/' + id;
            $('#deleteModal').modal('show');
        }
    </script>
    
@endsection