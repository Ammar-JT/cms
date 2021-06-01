<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('categories', App\Http\Controllers\CategoriesController::class);





//===============================================================
//          Why this project?
//===============================================================
/*

*/


//----------------------------------------------------------------
//                  Mass Assignments
//----------------------------------------------------------------
/*

-It's bascially assigining all values to the db in an array at once, instead of assigning it one by one
-To understand more, look at the CategoriesController@store 
-Also you have to put a protected fillable property in the model

*/


//----------------------------------------------------------------
//                  Request Object For Validation
//----------------------------------------------------------------
/*

-Instead of validating the values in the old way, you make a request object that has all the validation details there
-look at CategoriesController@store 
-To make request object:
        php artisan make:request CreateCategoryRequest

*/

//-----------------------------------------------------------------------------------------------
//                  Delete specific record using from an iteration : Modal + JS code + Laravel   
//-----------------------------------------------------------------------------------------------
/*

- I tried to solve this specific problem myself before one months, and I didn't do it cuz i was lazy
    .. now, this dude did it for me using a very clean code!!

- Go to categories/index.blade.php 

*/

  





