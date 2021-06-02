@extends('layouts.app')


@section('content')
    <div class="card card-default">
        <div class="card-header">
            <!-- let's use very abbreviated (short way) way to make an if else -->
            {{isset($tag) ? 'Edit Tag' : 'Create Tag'}}
        </div>
        <div class="card-body">
            @include('inc.messages')
            <form action="{{ isset($tag) ? route('tags.update', $tag->id) : route('tags.store') }}" method="POST">
                @csrf
                @if (isset($tag))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="{{isset($tag) ? $tag->name : ''}}" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-success">
                        {{isset($tag) ? "Update Categroy" : "Add Tag"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection