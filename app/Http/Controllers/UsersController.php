<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Micropost;

class UsersController extends Controller
{
    //
    public function index()
    {
      // code...
      $users = User::paginate(10);

      return view('users.index', [
        'users' => $users,
      ]);
    }

    public function show($id)
    {
      // code...
      $user = User::find($id);
      $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

      $data = [
        'user' => $user,
        'microposts' => $microposts,
      ];

      $data += $this->counts($user);

      return view('users.show', $data);
    }

    public function followings($id)
    {
      $user = User::find($id);
      $followings = $user->getFollowingsInformation()->paginate(10);

      $data = [
        'user' => $user,
        'users' => $followings,
      ];

      $data += $this->counts($user);

      return view('users.followings', $data);
    }

    public function followers($id)
    {
      $user = User::find($id);
      $followers = $user->getFollowersInformation()->paginate(10);

      $data = [
        'user' => $user,
        'users' => $followers,
      ];

      $data += $this->counts($user);

      return view('users.followers', $data);
    }
}
