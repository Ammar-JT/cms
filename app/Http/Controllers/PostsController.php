<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

use App\Http\Requests\Posts\CreatePostRequest;



class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('verifyCategoryCount')->only(['create','store']);
    }
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
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
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
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,
            'category_id' => $request->category,
            'user_id' => auth()->user()->id

        ]);

        //----------------------------------------------------------------------------
        //                          Many to Many Relationship + attach() function
        //----------------------------------------------------------------------------

        //if post has tag, save it in the n to n table using attach
        //.. notice you submit more thang one tag at once through the array "tags"
        
        if($request->tags){
            $post->tags()->attach($request->tags);
        }

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
    public function edit(Post $post)
    {
        return view('posts.create')->with(['post' => $post, 'categories' => Category::all(), 'tags' => Tag::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //for security, so the hacker coudn't mass assign any other things: 
        $data = $request->only(['title','description','published_at','content', 'category_id']);

        //check if new image
        if($request->hasFile('image')){
            //upload image
            $image = $request->image->store('images/posts');


            //delete old one (I did the deletion code in the Post model)
            $post->deleteImage();
            

            //we add the image url to the array: 
            $data['image'] = $image;
        }

        //----------------------------------------------------------------------------
        //                          Many to Many Relationship + sync() function
        //----------------------------------------------------------------------------


        //here we use sync method to make sure if the new selected tag
        //.. is tha same, if not it will be synced to the new one
        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        //update attribues
        $post->update($data);

        //redirect with message
        return redirect(route('posts.index'))->with('success', 'Post Updated Successfully');
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

            //delete image (I did the deletion code in the Post model)
            $post->deleteImage();

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
        //$trashed = Post::withTrashed()->get();
        $trashed = Post::onlyTrashed()->get();

        //we will return the same view but with trashed

        return view('posts.index')->with('posts', $trashed);
        //same as
        //return view('posts.index')->withPosts( $trashed);

    }

    public function restore($id){
        //get the post even if it's trashed:
        $post = Post::withTrashed()->where('id', $id)->firstOrFail(); //firstOrFail for security, so if it doesn't exist it should show 404 page

        $post->restore();

        $trashed = Post::onlyTrashed()->get();

        
            
        //Wow, a very convenient way to redirect to the same page
        return redirect(route('trashed-posts.index'))->with('success','Post Restored Successfuly');
    }
}
