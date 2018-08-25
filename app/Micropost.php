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
}
