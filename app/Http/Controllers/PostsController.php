<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\Posts\CreatePostRequest;



class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        //upload the image
        $image = $request->image->store('images/posts');
        

        //create the post
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at
        ]);

        //redirect the user with the success message
        return redirect(route('posts.index'))->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //----------------------------------------------------------------------------
    //                          Soft Delete + Trashed Posts
    //----------------------------------------------------------------------------
    public function destroy($id) // notice we didn't use (Post $post) cuz it won't get the trashed one
    {
        //get the post even if it's trashed:
        $post = Post::withTrashed()->where('id', $id)->firstOrFail(); //firstOrFail for security, so if it doesn't exist it should show 404 page

        //if it's been soft deleted already, then delete it permanantly: 
        if($post->trashed()){
            $post->forceDelete();

            $currentPath = getcwd();
            //I used unlink instead of storage cuz storage won't work in hostgator!
            unlink($currentPath .'/storage/'. $post->image);

            $msg = 'Post Deleted Successfully';
        }else{
            $post->delete();
            $msg = "Post Trashed Successfully";
        }

        return redirect(route('posts.index'))->with('success', $msg);
    }

    /**
     * Display a list of all trashed posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function trashed(){
        //this method get all the posts including the trashed posts: 
        $trashed = Post::withTrashed()->get();

        //we will return the same view but with trashed

        return view('posts.index')->with('posts', $trashed);
        //same as
        //return view('posts.index')->withPosts( $trashed);

    }
}
