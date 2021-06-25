<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
//---------------------------------------------------------------------------------------------
//                              Query Local Scopes
//---------------------------------------------------------------------------------------------
      // This commented code is replaced by the local scope scopeSearcher() in Post model (then used it down there ////): 
      /*
      //you can use request like this, instead of taking it from the parameter:
      $search = request()->query('search');

      if($search){
        $posts = Post::where('title', 'LIKE', "%{$search}%")->simplePaginate(3);
      }else{
        $posts = Post::simplePaginate(3);
      }
      */

      ////here we used the local scope scopeSearched to get the query result
      return view('welcome')
        ->with('categories', Category::all())
        ->with('tags', Tag::all())
        ->with('posts', Post::searched()->simplePaginate(4)); //searched() is a local scope query, look at the model Post
    }
}
