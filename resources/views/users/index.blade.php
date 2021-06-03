@extends('layouts.app')


@section('content')
    <div class="card card-default">
        <div class="card-header">Users</div>
        <div class="card-body">
            @include('inc.messages')
            
            @if ($users->count()>0)
                <table class="table">
                    <thead>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>


                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <img src="{{Gravatar::src($user->email)}}" width='40px' style="border-radios: 50%" alt="">
                                </td>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                    
                                </td>
                                <td>
                                    {{$user->role}}
                                    
                                </td>
                                <td>
                                    @if ($user->isAdmin())
                                        <form method="POST" action="{{route('users.make-writer', $user->id)}}">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm">Make Writer</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{route('users.make-admin', $user->id)}}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Make Admin</button>
                                        </form>
                                    @endif

                                    <button class="btn btn-danger btn-sm" onclick="handleDelete({{$user->id}})">
                                        {{$user ? 'Delete' : 'Trash'}}
                                    </button>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else  
                <h3 class="text-center">No Users Yet</h3>
            @endif
        </div>
    </div>


    <!-- modals -->
    <div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <form action="" method="POST" id="deleteUserForm">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
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
            var form = document.getElementById('deleteUserForm');
            form.action = '/users/' + id;
            $('#deleteModal').modal('show');
        }
    </script>
    
@endsection