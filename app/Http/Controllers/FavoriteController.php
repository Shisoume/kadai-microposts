<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
      \Auth::user()->bookmark($id);
      return redirect()->back();
    }

    public function destroy($id)
    {
      \Auth::user()->unbookmark($id);
      return redirect()->back();
    }

    public function index()
    {
      $favorite_microposts = \Auth::user()->getFavoriteInfo()->orderBy('created_at', 'desc')->paginate(10);
      $data = [];
      $data = [
        'favorite_microposts' => $favorite_microposts,
      ];

      return view('favorites.index', $data);
    }
}
