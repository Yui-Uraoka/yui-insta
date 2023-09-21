<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category) {

        $this->post = $post;
        $this->category = $category;
    }

    // CODE REFACTORING 
    private function saveCategories($request, $post) {
        foreach($request->category as $category_id) {
            $category_post[] = [
                'category_id' => $category_id
            ];
        }
        $post->categoryPost()->createMany($category_post);
    }

    public function create() {
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request) {
        // dd($request);
        // 1. validate
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        // 2. save post to post table
        $this->post->user_id = Auth::user()->id;
        $this->post->image = 'data:image/'. $request->image->extension(). ';base64,'. base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        // 3. save the post and category ids in the pivot table
        // $i += 2, i = i+2
        // $i ++, i = i+1
        /**
         * References:
         * $request->catefory = [1,2]
         * 
         * Initial state:
         * $category_post[] = []
         * 
         * 1st itr: 
         *      $category_post[]=
         *      [
         *          ['category_id'=>1']
         *      ]
         * 2nd itr: 
         *      $category_post[]=
         *      [
         *          ['category_id'=>1'],
         *          ['category_id'=>2']
         *      ]
         * 
         * RESULT:
         *      $category_post[]=
         *      [
         *          ['category_id'=>1'],
         *          ['category_id'=>2']
         *      ]
         * 
         */ 
        // foreach($request->category as $category_id) {
        //     $category_post[] = [
        //         'category_id'=>$category_id
        //     ];
        // }

        // $this->post->categoryPost()->createMany($category_post);

        // CODE REFACTORING
        $this->saveCategories($request, $this->post);
        /**
         * Explanation:
         * 
         * The parameter $request is the request object that contains the data from the form.
         * The parameter $this->post is the post object that contains the data from the post table. 
         * We pass the $request and $this->post to the saveCategories function because we need to access the $request->category and $this->post->categoryPost() in the saveCategories function.
         * We do not need redeclare 'Request' on the saveCategories PRIVATE METHOD because we already declared it on the store function and update function.
         */

        return redirect()->route('index');
    }

    public function show($id) {
        $post = $this->post->findOrFail($id);
        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id) {
        $post = $this->post->findOrFail($id);
        // if the login user is NOT the owner of the post, redirect to homepage
        if(Auth::user()->id != $post->user->id) {
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();
        
        $selected_categories = [];
        foreach($post->categoryPost as $category_post) {
            $selected_categories[] = $category_post->category_id;
        }
        
        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id) {
         // 1. validate
         $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        // 2. Update the post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        // to check if the request has a image file
        if($request->image) {
            $post->image = 'data:image/'. $request->image->extension(). ';base64,'. base64_encode(file_get_contents($request->image));
        }

        $post->save();

        // 3.Update the entries on the pivot table

        // this will use the relationship to query all the post id and delete them
        $post->categoryPost()->delete();

        // create new entries on the pivot table
        // foreach($request->category as $category_id) {
        //     $category_post[] = [
        //         'category_id'=>$category_id
        //     ];
        // }

        // $post->categoryPost()->createMany($category_post);

        // CODE REFACTORING
        $this->saveCategories($request, $post);

        return redirect()->route('post.show', $id);
    }

    public function destroy($id) {
        // $this->post->destroy($id);
        $post = $this->post->findOrFail($id);
        $post->forceDelete();
        return redirect()->route('index');
    }

}
