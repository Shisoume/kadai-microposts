<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class MicropostsController extends Controller
{
    //
    public function index()
    {
      // code...
      $data = [];
      if (\Auth::check()) {
        // code...
        $user = \Auth::user();
        $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
          'user' => $user,
          'microposts' => $microposts,
        ];
      }
      return view('welcome', $data);
    }

    public function store(Request $request)
    {
      // code...
      $this->validate($request, [
        'content' => 'required|max:191',
      ]);
      $request->user()->microposts()->create([
        'content' => $request->content
      ]);

      return redirect()->back();
    }

    public function destroy($id)
    {
      // code...
      $micropost = \App\Micropost::find($id);

      if (\Auth::id() === $micropost->user_id) {
        // code...
        $micropost->delete();
      }
      return redirect()->back();
    }
}
