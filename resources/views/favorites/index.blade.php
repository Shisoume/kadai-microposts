@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-xs-8">
      @if (count($favorite_microposts) > 0)
        @include('microposts.microposts', ['microposts' => $favorite_microposts])
      @endif
    </div>
  </div>
@endsection
