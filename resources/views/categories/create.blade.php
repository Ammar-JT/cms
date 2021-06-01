@extends('layouts.app')


@section('content')
    <div class="card card-default">
        <div class="card-header">Create Category</div>
        <div class="card-body">
            @include('inc.messages')
            <form action="{{route('categories.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Add Category</button>
                </div>
            </form>
        </div>
    </div>
@endsection