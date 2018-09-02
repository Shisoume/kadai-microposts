<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function microposts()
    {
      // code...
      return $this->hasMany(Micropost::class);
    }

    public function getFollowingsInformation()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function getFollowersInformation()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    public function follow($userId)
    {
      $exist = $this->is_following($userId);

      if ($exist || ($this->id == $userId)) {
        return false;
      } else {
        $this->getFollowingsInformation()->attach($userId);
        return true;
      }
    }

    public function unfollow($userId)
    {
      $exist = $this->is_following($userId);

      if ($exist || ($this->id == $userId)) {
        $this->getFollowingsInformation()->detach($userId);
        return true;
      } else {
        return false;
      }
    }

    public function is_following($userId)
    {
      return $this->getFollowingsInformation()->where('follow_id', $userId)->exists();
    }

}
