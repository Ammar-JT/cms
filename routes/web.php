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

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
Route::get('/blog/posts/{post}', [App\Http\Controllers\Blog\PostsController::class, 'show'])->name('blog.show');
Route::get('/blog/categories/{category}', [App\Http\Controllers\Blog\PostsController::class, 'show'])->name('blog.category');
Route::get('/blog/tags/{tag}', [App\Http\Controllers\Blog\PostsController::class, 'show'])->name('blog.tag');


Auth::routes();


Route::middleware(['auth'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('categories', App\Http\Controllers\CategoriesController::class);
    Route::resource('posts', App\Http\Controllers\PostsController::class);
    Route::resource('tags', App\Http\Controllers\TagsController::class);

    
    Route::get('/trashed-posts', [App\Http\Controllers\PostsController::class, 'trashed'])->name('trashed-posts.index');
    
    Route::put('/restore-posts/{post}', [App\Http\Controllers\PostsController::class, 'restore'])->name('trashed-posts.update');    


});

Route::middleware(['auth','isAdmin'])->group(function(){
    Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');

    //if you put '/users/{id}' instead of '{user}' laravel will recive it as ID literally,
    //.. so, in the controller you won't be able to use makeAdmin(User $user){}.. 
    //.. cuz laravel will make a new user instead of finding the user u ask for!!
    Route::post('/users/{user}/make-admin', [App\Http\Controllers\UsersController::class, 'makeAdmin'])->name('users.make-admin');
    Route::post('/users/{user}/make-writer', [App\Http\Controllers\UsersController::class, 'makeWriter'])->name('users.make-writer');

    Route::get('/users/profile', [App\Http\Controllers\UsersController::class, 'editProfile'])->name('users.edit-profile');
    Route::put('/users/profile', [App\Http\Controllers\UsersController::class, 'updateProfile'])->name('users.update-profile');

});




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
        php artisan make:request Categories/CreateCategoryRequest
        php artisan make:request Categories/UpdateCategoryRequest

- I made also: 
        php artisan make:request Users/UpdateProfileRequest


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

- Later I add a pivot table for the many to many relationship between posts and tags:
  .. and as you can see both are singular and I orderd them alphabatically
  .. laravel is smart, writing it that way it will make the column for the n to n table for you: 
        php artisan make:migration create_post_tag_table --table=post_tag

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

//----------------------------------------------------------------------------
//                          MiddleWare
//----------------------------------------------------------------------------
/*

- To make a middleware: 
    1-    php artisan make:middleware verifyCategorisCount
    2- write down your logic in the middleware
    3- register the middleware in kernel
    4- use the middleware in the route or in the consructor like any other middleware
-
*/


//----------------------------------------------------------------------------
//                          Route Group
//----------------------------------------------------------------------------
/*

- Instead of putting the middleware in every route, you can put it in a group of routes: 
    Route::middleware(['auth'])->group(function(){ ---- your authed routes ----});
*/


//----------------------------------------------------------------------------
//                          Many to Many Relationship + attach() + sync()
//----------------------------------------------------------------------------
/*

-  I add a pivot table for the many to many relationship between posts and tags:
  .. and as you can see both are singular and I orderd them alphabatically
  .. laravel is smart, writing it that way it will make the column for the n to n table for you: 
        php artisan make:migration create_post_tag_table --table=post_tag
- I fill up the migration table
- I put belongsToMany() in both the post and the tag models
- migrate

- use attach() function in PostsController@create

- use sync() function in PostsController@update

- use this library for a beautiful selector: 
    https://select2.org/tagging
*/






//----------------------------------------------
//                  Seeders
//----------------------------------------------
/*
- If you want to know a detailed explaination about seeds and factories go to todos project: 
        https://github.com/Ammar-JT/Todos

- To make a seeder: 
        php artisan make:seeder UsersTableSeeder

- Fill up the seed with the records you want, you can use seeder to make a specific record (like admin),
  .. or you can use a seeder with a factory to make a massive number of records.
  .. If you want to know about factories go to the todos proejct.

- After making the seeder, make sure you add this seeder in DatabaseSeeder.php in the run function:
        $this->call(UsersTableSeeder::class);

---------------------------------------
    Migration: refresh + seed!!!!! 
--------------------------------------
- If you want to refresh the database (delete all tables and migration the new tables) use: 
        php artisan migrate:refresh

- If you want to seed the db with the seeders you made: 
        php artisan db:seed

- If you want both: refresh + seed: 
        php artisan migrate:refresh --seed
        

*/


//----------------------------------------------
//                  Roles (without an external library)
//----------------------------------------------
/*

1- Put a role record in the users table, and make it not admin by default (writer for example)
2- Put a seeder that make an admin account, so website db will had an admin account when you refresh --seed
3- Make an isAdmin() function in the User's model to check for admin in blade or controllers
4- For security you better make verifyIsAdmin() function as a middleware, 
   ..so you can use it in the routes and construct, with this code: 
        php artisan make:middleware verifyIsAdmin
5- Don't forget to register this middleware in the kernel
6- Better to use route group so you can use this middleware for many routes at once

7- Now, with isAdmin(in model) + verifyIsAdmin(as middleware for routes): 
    - non admin users can't see the buttons using isAdmin() in the views
    - non admin users can't inter the routes at all using verifyIsAdmin()
    - So, it means a clean views + Secure App
    
*/

//----------------------------------------------
//                  Some useful front-end libraries
//----------------------------------------------
/*
- Laravel Gravatar: for the user avatar: 
    https://github.com/thomaswelton/laravel-gravatar

- Trix: a simple text editor for <input>: 
    https://github.com/basecamp/trix

- Flatpicker: for very beautiful time and date picker: 
    https://flatpickr.js.org/getting-started/

- Select2: for many things, but I use the tool for tag selecting (like when you select email in gmail):
    https://select2.org/tagging

- Comment section (now thier server has some issues, it so slow that i couldn't set the comment section up!): 
    https://disqus.com/


    
*/












  





