<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function counts($user)
    {
      // code...
      $count_microposts = $user->microposts()->count();
      $count_followings = $user->getFollowingsInformation()->count();
      $count_followers = $user->getFollowersInformation()->count();
      $count_favorites = $user->getFavoriteInfo()->count();

      return [
        'count_microposts' => $count_microposts,
        'count_followings' => $count_followings,
        'count_followers' => $count_followers,
        'count_favorites' => $count_favorites,
      ];
    }
}
