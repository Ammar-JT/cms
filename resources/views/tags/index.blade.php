@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{route('tags.create')}}" class="btn btn-success">Add Tag</a>
    </div>
    <div class="card card-default">
        <div class="card-header">Tags</div>
        <div class="card-body">
            @include('inc.messages')
            
            @if ($tags->count()>0)
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Post Number</th>
                        <th></th>

                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td>
                                    {{$tag->name}}
                                </td>
                                <td>
                                    {{$tag->posts->count()}}
                                </td>

                                <td>
                                    <a href="{{route('tags.edit', $tag->id)}}" class="btn btn-info btn-sm">Edit</a>
    <!-- ================================================================================================================= -->
    <!--                Delete specific record using from an iteration : Modal + JS code + Laravel                         -->
    <!-- ================================================================================================================== -->
    <button class="btn btn-danger btn-sm" onclick="handleDelete({{$tag->id}})">Delete</button>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center">No Tags Yet</h3>
            @endif
        </div>
    </div>


    <!-- modals -->
    <div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <form action="" method="POST" id="deleteTagForm">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this tag?</p>
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
            var form = document.getElementById('deleteTagForm');
            form.action = '/tags/' + id;
            $('#deleteModal').modal('show');
        }
    </script>
    
@endsection