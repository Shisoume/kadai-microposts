<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    //
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
      // code...
      return $this->belongsTo(User::class);
    }

    public function getFavoriteUserInfo()
    {
      return $this->belongsToMany(User::class, 'micropost_favorite', 'favorite_micropost_id', 'user_id')->withTimestamps();
    }

    public function is_favorite($userId)
    {
      return $this->getFavoriteUserInfo()->where('user_id', $userId)->exists();
    }

    public function bookmark($id)
    {
      if ($this->is_favorite($id)) {
        return false;
      }
      else {
        $this->getFavoriteInfo()->attach($id);
        return ture;
      }
    }

    public function unbookmark($userId)
    {
      if ($this->is_favorite($userId)) {
        $this->getFavoriteInfo()->detach($id);
        return true;
      }
      else {
        return false;
      }
    }
}
