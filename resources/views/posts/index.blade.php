@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{route('posts.create')}}" class="btn btn-success">Add Post</a>
    </div>
    <div class="card card-default">
        <div class="card-header">Posts</div>
        <div class="card-body">
            @include('inc.messages')
            
            @if ($posts->count()>0)
                <table class="table">
                    <thead>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>

                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <img src="{{asset('/storage/'.$post->image)}}" width='80px'    alt="">
                                </td>
                                <td>
                                    {{$post->title}}
                                </td>
                                <td>
                                    <a href="{{route('categories.show', $post->category->id)}}">{{$post->category->name}}</a>
                                    
                                </td>
                                <td>
                                    @if ($post->trashed())
                                        <form action="{{route('trashed-posts.update', $post->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-info btn-sm">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{route('posts.edit', $post->id)}}" class="btn btn-info btn-sm">Edit</a>
                                    @endif
    <!-- ================================================================================================================= -->
    <!--                Delete specific record using from an iteration : Modal + JS code + Laravel                         -->
    <!-- ================================================================================================================== -->

    <!--//---------------------------------------------------------------------------- -->
    <!--//                          Soft Delete + Trashed Posts                        -->
    <!--//---------------------------------------------------------------------------- -->
                                    <button class="btn btn-danger btn-sm" onclick="handleDelete({{$post->id}})">
                                        {{$post->trashed() ? 'Delete' : 'Trash'}}
                                    </button>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else  
                <h3 class="text-center">No Posts Yet</h3>
            @endif
        </div>
    </div>


    <!-- modals -->
    <div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <form action="" method="POST" id="deletePostForm">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this post?</p>
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
            var form = document.getElementById('deletePostForm');
            form.action = '/posts/' + id;
            $('#deleteModal').modal('show');
        }
    </script>
    
@endsection