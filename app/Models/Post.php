<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // to get the categories under a post
    // $post->categoryPost->details
    public function categoryPost() {
        return $this->hasMany(CategoryPost::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    // return TRUE if the login user already liked the post
    public function isLiked() {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        /**
         * ex.1) likes table = [user 2, post 8], auth-user-id = 3,
         * redult:
         * get() => []
         * exists() => FALSE
         * 
         * ex.2) likes table = [user 2, post 8], auth-user-id = 2,
         * result:
         * get() => [2, 8]
         * exists() => TRUE
         */
    }
}
