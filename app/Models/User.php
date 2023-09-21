<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes; 

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    // To get all the followers of a user
    public function followers() {
        return $this->hasMany(Follow::class, 'following_id');
    }

    // To get all the users that the user is following
    public function following() {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    // return true if the login user is following a certain user
    public function isFollowed() {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
    }
    /**
     * Explanation for the isFollowed() method
     * Example:
     * Login id = 1
     * User id = 2
     * 
     * SAMPLE ENTRIES in TABLE FOLLOWS
     * follower_id, following_id
     * 1,2
     * 1,3
     * 2,1
     * 4,1
     * 
     * PART 1: $this->followers()
     * ->this refers to the user model (the user that is followed) using the followers() method this will return all the followers of the Login user
     * OUTPUT : [{"follower_id" : 2, "following_id" : 1}, 
     *           {"follower_id" : 4, "following_id" : 1}]
     * 
     * PART 2: ->where('follower_id', Auth::user()->id)
     * ->this will filter the collection of followers and return only the followers that has the follower_id = 1 (login user)
     * OUTPUT: [2]
     * 
     * part3: exists()
     * ->this will return true if the collection is not empty
     * OUTPUT: [2] => true
     *         [4] => false
     */

    
    // return true if a user is following the login user
     public function isFollowing() {
        return $this->following()->where('following_id', Auth::user()->id)->exists();
    }
}
