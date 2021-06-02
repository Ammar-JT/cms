@extends('layouts.app')


@section('content')
    <div class="card card-default">
        <div class="card-header">
            <!-- let's use very abbreviated (short way) way to make an if else -->
            {{isset($post) ? 'Edit Post' : 'Create Post'}}
        </div>
        <div class="card-body">
            @include('inc.messages')
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($post))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" value="{{isset($post) ? $post->title : ''}}" name="title" id="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description"  rows="3">{{isset($post) ? $post->description : ''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <input id="content" type="hidden" name="content" value="{{isset($post) ? $post->content : ''}}">
                    <trix-editor input="content"></trix-editor>
                </div>


                <div class="form-group">
                    <label for="published_at">Published At</label>
                    <input type=text" value="{{isset($post) ? $post->published_at : ''}}" name="published_at" id="published_at" class="form-control">
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" id="category">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" 
                                @if (isset($post))
                                    {{($post->category_id == $category->id) ? 'selected' : ''}}
                                @endif 
                                >{{$category->name}}</option>
                        @endforeach
                        
                    </select>
                </div>

                @if (isset($post))
                    <div class="form-group">
                        <img src="{{asset('/storage/'.$post->image)}}" class="w-100" alt="">
                    </div>
                @endif
                

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <div class="form-group">
                    @if ($tags->count()>0)
                        <label for="tags">Tags</label>
                        <!-- Notice multiple select for MULTIPLE SELECT!!! 
                             Also you must put tags[] in the name so html know you want to submit
                             .. multiple options in an array

                            
                            -->
                        <select name="tags[]" id="tags" class="form-control tags-selector" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{$tag->id}}"
                                    @if (isset($post))
                                        @if($post->hasTag($tag->id))
                                            selected
                                        @endif
                                    @endif
                                    
                                    >
                                    {{$tag->name}}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    
                </div>

                <div class="form-group">
                    <button type='submit' class="btn btn-success">
                        {{isset($post) ? "Update Post" : "Add Post"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        flatpickr('#published_at', {
            enableTime: true
        });

        // jQuery:
        $(document).ready(function() {
            $('.tags-selector').select2();
        });
    </script>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection