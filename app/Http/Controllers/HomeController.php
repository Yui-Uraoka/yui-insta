<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;

    public function __construct(Post $post, User $user) {

        $this->post = $post;
        $this->user = $user;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // Get the posts of the users that the login user is following and the login user's post
    private function getHomePosts() {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach($all_posts as $post) {
            /**
             * LOGICAL OPERATOR(||) **similar to plus
             * T || T = T
             * T || F = T
             * F || T = T
             * F || F = F
             */
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
                // home_posts = $home_posts + $post
                // array_push($home_posts, $post);
            }
        }
        return $home_posts;
    }

    private function getSuggestedUsers() {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user) {
            /**
             * Initial reference : 
             *                     login user = 2
             *                     all user [1,2,3,4]
             *                     follows table
             *                                [
             *                                  [1,2],
             *                                  [2,1],
             *                                  [2,3]
             *                                 ]
             * 
             * Iteration #1 : USER id = 1, $all_users = [1,3,4]
             * check if the login user is following the user id = 1
             * $user->isFollowed() = True
             * if(!$user->isFollowed()) = if(!T) = if(F)
             * $suggested_users[] = []
             * 
             * Iteration #2 : USER id = 3, $all_users = [1,3,4]
             * check if the login user is following the user id = 3
             * $user->isFollowed() = True
             * if(!$user->isFollowed()) = if(!T) = if(F)
             * $suggested_users[] = []
             * 
             * Iteration #3 : USER id = 4, $all_users = [1,3,4]
             * check if the login user is following the user id = 4
             * $user->isFollowed() = False
             * if(!$user->isFollowed()) = if(!F) = if(T)
             * $suggested_users[] = [4]
             * 
             * EXIT LOOP
             * $suggested_users = [4]
             * 
             */
            if(!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }
        return array_slice($suggested_users, 0, 10);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();

        return view('users.home')
            ->with('all_posts', $all_posts)
            ->with('suggested_users', $suggested_users);
    }

    public function search(Request $request) {
        // maryann          ('%' .$request->serch)
        // annmary smith    ($request->serch . '%')
        // lilly ann smith  ('%' . $request->serch . '%')
        // search = ann
        $users = $this->user->where('name', 'like', '%' . $request->search . '%')->get();
        return view('users.search')->with('users',$users)->with('search', $request->search);
    }

    public function suggestions() {
        $all_users = $this->user->all()->except(Auth::user()->id);
        // $following = $this->user->following();
        $suggested_users = [];

        foreach($all_users as $user) {
            if(!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        return view('users.suggestions')
            ->with('suggested_users', $suggested_users);
           
    }
}
