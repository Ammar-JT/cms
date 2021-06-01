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
Route::resource('posts', App\Http\Controllers\PostsController::class);

Route::get('/trashed-posts', [App\Http\Controllers\PostsController::class, 'trashed'])->name('trashed-post.index');






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


//-----------------------------------------------------------------------------------------------
//                  Simplest way to upload a file in laravel (using store method)!!!!!!!!!!!!!!   
//-----------------------------------------------------------------------------------------------
/*

- You don't have to separate the name of the file and its extinsion
- You don't have to use storage or link methods
- You don't have to generate a unique name by yourself cuz laravel do it for you!
- You don't have to do a lot of things... 

- You can change where this new method store the files from the env file
    .. so instead it store it in a private file and you make a shortcut in the public
    .. folder, you will store it directly in the public folder!!
- look at filesystem and at .env file
- change the FILESYSTEM_DRIVER in .env to public

- Too much to explain it here, if you want to understand it see this video: 
    https://www.youtube.com/watch?v=m-8dqFK28wM&list=PL78sHffDjI74qqNlqtqV_tx5E0_NG1IXQ&index=28&ab_channel=EasyLearningEasyLearning


*/

//----------------------------------------------------------------------------
//                          Migration tricks
//----------------------------------------------------------------------------
/*

- If you want to delete all the migration and migrate it again, use: 
        php artisan migrate:refresh
  But notice that it will ERASE everything!! 
  So Never use it in production app

- Never use refresh in a production app

- Instead use: 
        php artisan make:migration add_soft_deletes_to_posts_table --table=posts
  which will add new migration to the table posts

- Now to migrate just wirte:
        php artisan migrate
- To rollback the last migration:
        php artisan migrate:rollback

*/

//----------------------------------------------------------------------------
//                          Soft Delete + Trashed Posts
//----------------------------------------------------------------------------
/*

- Soft delete means you don't realy delete it, you just put it in the trash
- to make it in laravel it's very easy, just add it in the migration as a column: 
        $table->softDeletes();
  and add this to the down method if you are adding new migration to an exising table: 
        $table->dropSoftDeletes();
- add to the model you want this: 
    use Illuminate\Database\Eloquent\SoftDeletes;
  and in the class
    use SoftDeletes;


*/







  





