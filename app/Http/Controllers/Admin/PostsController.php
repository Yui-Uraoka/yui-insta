<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index() {
        $all_posts = $this->post->withTrashed()->latest()->paginate(4);

        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    public function hide($id) {
        $this->post->destroy($id);
        return redirect()->back();
    }

    public function unhide($id) {
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    public function search(Request $request) {
        $user = User::where('name', 'like', '%' .  $request->search . '%')->withTrashed()->first();    
        $category = Category::where('name','like', '%' . $request->search . '%')->first();
        
        if(strtolower($request->search) === "uncategorized") {
            $all_posts = [];
            $categories_id = [];
            $post_count = 0;

            $posts = $this->post->withTrashed()->get();
            foreach($posts as $post) {
                if($post->categoryPost->count() == 0) {
                    $categories_id[] = $post->id;
                    $post_count++;
                }
            }
            $all_posts = $this->post->withTrashed()->whereIn('id', $categories_id)->get();
            return view('admin.posts.search') 
                        ->with('all_posts',$all_posts)
                        ->with('post_count', $post_count); 
        }

        if($user && $category) {
            $postsByUser = $user->posts()->withTrashed()->get();
            $postsByCategory = $category->categoryPost;
            $all_postsByCategory = [];
            foreach($postsByCategory as $post){
                $all_postsByCategory [] = $post->post;
            }
            $all_posts = $postsByUser->merge($all_postsByCategory);
            $post_count = $all_posts->count();
    
            return view('admin.posts.search') 
                        ->with('all_posts',$all_posts)
                        ->with('post_count', $post_count);       
        }
        elseif($category) {
            $postByCategory = $category->categoryPost;
            $all_posts = [];
            $post_count = 0;
            foreach($postByCategory as $post){
                $all_posts [] = $post->post;
                if($post->post) {
                    $post_count++;
                }
            }
            return view('admin.posts.search')
                        ->with('all_posts',$all_posts)
                        ->with('post_count', $post_count);                   
        }
        elseif($user) {
            $all_posts= $user->posts()->withTrashed()->get();
            $post_count = $all_posts->count();
    
            return view('admin.posts.search')
                        ->with('all_posts',$all_posts)
                        ->with('post_count', $post_count);        
        }
        elseif(!$user && !$category) {
            return view('admin.posts.nouser');
        }
        }
}
