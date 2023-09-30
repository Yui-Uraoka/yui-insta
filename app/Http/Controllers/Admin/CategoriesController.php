<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;
    
    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    private function uncategorizedCount() {
        $uncategorized_count = 0;
        $all_posts = $this->post->all();
        foreach($all_posts as $post) {
            if($post->categoryPost->count()==0) {
                // $uncategorized_count[] = [data] *save and push data in an empty array variable
                $uncategorized_count++; 
                // this is to count and add 1 on every instance when IF-condition is satisfied
                // $uncategorized_count = $uncategorized_count + 1;
                /**
                 * $uncategorized_count = 0
                 * itr #1, post id = 1 (no category)
                 * $uncategorized_count = 0 + 1     = 1
                 * itr #2, post id = 2 (category)
                 *  $uncategorized_count = 1 + 0    = 1
                 * itr #3, post id = 3 (no category)
                 * $uncategorized_count = 1 + 1     = 2
                 */
            }
        }

        return $uncategorized_count;

    }

    public function index() {
        $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(5);

        // to get the number of uncategorized post
        $uncategorized_count = 0;
        $all_posts = $this->post->all();
        foreach($all_posts as $post) {
            if($post->categoryPost->count()==0) {
                // $uncategorized_count[] = [data] *save and push data in an empty array variable
                $uncategorized_count++; 
                // this is to count and add 1 on every instance when IF-condition is satisfied
                // $uncategorized_count = $uncategorized_count + 1;
                /**
                 * $uncategorized_count = 0
                 * itr #1, post id = 1 (no category)
                 * $uncategorized_count = 0 + 1     = 1
                 * itr #2, post id = 2 (category)
                 *  $uncategorized_count = 1 + 0    = 1
                 * itr #3, post id = 3 (no category)
                 * $uncategorized_count = 1 + 1     = 2
                 */
            }
        }
        // dd($uncategorized_count);
        return view('admin.categories.index')
            ->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name'
        ]);

        $this->category->name = ucwords(strtolower($request->name));
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $request->validate([
            'new_name' => 'required|min:1|max:50|unique:categories,name,' . $id
        ]);
        $category = $this->category->findOrFail($id);
        $category->name = ucwords(strtolower($request->new_name));
        $category->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $this->category->destroy($id);
        return redirect()->back();
    }

    public function search(Request $request) {
        $categories = $this->category
            ->where('name', 'like', '%' . $request->search . '%')          
            ->get();
        $uncategorized_count = $this->uncategorizedCount();
        
        return view('admin.categories.search')
            ->with('categories',$categories)
            ->with('uncategorized_count', $uncategorized_count);
    }
}
