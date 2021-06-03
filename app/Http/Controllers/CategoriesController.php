<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
    public function store(CreateCategoryRequest $request)
    {

        //----------------------------------------------------------
        //                  Mass Assignment
        //----------------------------------------------------------

        //insead of the traditional way this way is called mass assignment
        //.. you can't use this method unless you put a protected fillable property in the model Category
        //.. after that you can do the following here: 
        Category::create([
            'name' => $request->name
        ]);

        return redirect(route('categories.index'))->with('success', 'Category Create Successfully');
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
    public function edit(Category $category)
    {
        return view('categories.create')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        
        $category->update([
            'name' => $request->name
        ]);

        return redirect(route('categories.index'))->with('success', 'Category Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->posts->count() > 0){
            return redirect()->back()->with('error', 'Category cannot be deleted because it has some posts');
        }
        $category->delete();

        return redirect(route('categories.index'))->with('success', 'Category Deleted Successfully');
    }
}
