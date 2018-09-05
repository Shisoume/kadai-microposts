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

      if ($exist && !($this->id == $userId)) {
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

    public function feed_microposts()
    {
      // タイムライン用にマイクロポストを取得するメソッド
      $follow_user_ids = $this->getFollowingsInformation()-> pluck('users.id')->toArray();
      $follow_user_ids[] = $this->id;
      return Micropost::whereIn('user_id', $follow_user_ids);
    }

    public function getFavoriteInfo()
    {
      return $this->belongsToMany(Micropost::class, 'micropost_favorite', 'user_id', 'favorite_micropost_id')->withTimestamps();
    }

    public function bookmark($id)
    {
      if ($this->is_favorite($id)) {
        return false;
      }
      else {
        $this->getFavoriteInfo()->attach($id);
        return true;
      }
    }

    public function unbookmark($id)
    {
      if ($this->is_favorite($id)) {
        $this->getFavoriteInfo()->detach($id);
        return true;
      }
      else {
        return false;
      }
    }

    public function is_favorite($id)
    {
      return $this->getFavoriteInfo()->where('favorite_micropost_id', $id)->exists();
    }

}
