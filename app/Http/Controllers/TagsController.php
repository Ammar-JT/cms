<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tag;
use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;


class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index')->with('tags', Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //----------------------------------------------------------
    //              Request Object for Validation
    //----------------------------------------------------------

    //when you use a custom request object that has your own validation,
    //.. it laravel will inject those validation to you request
    //.. and you can use this request as a regular request, but a validated one!!
    public function store(CreateTagRequest $request)
    {

        //----------------------------------------------------------
        //                  Mass Assignment
        //----------------------------------------------------------

        //insead of the traditional way this way is called mass assignment
        //.. you can't use this method unless you put a protected fillable property in the model Tag
        //.. after that you can do the following here: 
        Tag::create([
            'name' => $request->name
        ]);

        return redirect(route('tags.index'))->with('success', 'Tag Create Successfully');
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
    public function edit(Tag $tag)
    {
        return view('tags.create')->with('tag', $tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        
        $tag->update([
            'name' => $request->name
        ]);

        return redirect(route('tags.index'))->with('success', 'Tag Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect(route('tags.index'))->with('success', 'Tag Deleted Successfully');
    }
}
