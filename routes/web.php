<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/people', [HomeController::class, 'search'])->name('search');
    Route::get('/suggestions',[HomeController::class, 'suggestions'])->name('suggestions');

    // this route will serve the views>users>posts>create.blade.php
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    // this route will save a post details
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    // this route will seve the views>users>posts>show.blade.php
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');
    // this route will serve the views>users>posts>edit.blade.php
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    // this route will update a post
    Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
    // this route will delete a post
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');


    // this route will save a comment 
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
    // this route will delete a comment from comment.blade.php
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    // this route will serve the views>users>profile>show.blade.php
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    // this route will the views>users>profile>edit.blade.php
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // this route will update the login user's information
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // this route will serve the views>users>profile>followers.blade.php
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    // this route will serve the views>users>profile>following.blade.php
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');

    // this route will save a like 
    Route::post('/like/{post_id}/store',[LikeController::class, 'store'])->name('like.store');
    // this route will delete a like
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    // this route will store follower and following
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    // this route will delete follow 
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        Route::get('/posts', [PostsController::class, 'index'])->name('posts');
        Route::delete('/posts/{id}/hide', [PostsController::class, 'hide'])->name('posts.hide');
        Route::patch('/posts/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');

        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });
});

