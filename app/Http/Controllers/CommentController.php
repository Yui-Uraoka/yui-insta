<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;
    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id) {
        // dd($request);
        $request->validate(
            [
                'comment_body' . $post_id =>'required|max:150'
            ],
            [
                'comment_body' . $post_id . '.required' => 'You cannot submit an empty comment.',
                'comment_body' . $post_id . '.max' => 'The comment must not have more than 150 characters.'
            ]
        );

        $this->comment->body = $request->input('comment_body' . $post_id);
        /**
         * input('comment_body' . $post_id) = $request->comment_body1
         * input() is used to get the value of the input field with the name of attribute of comment_body1
         * We do not use $request->comment_body because the name attribute of the input field has a number appended to it (comment_body1, comment_body2, comment_body3 etc.)
         * if we use $request->comment_body1, we will get an error because the name attribute of the inputfielf is not comment_body1 but comment_body1, comment_body2, comment_body3, etc
         */
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $this->comment->destroy($id);
        return redirect()->back();
    }


}
