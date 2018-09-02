@if (Auth::id() != $user->id)
  @if (Auth::user()->is_following($user->id))
    {!! Form::open(['route' => ['users.unfollow', $user->id], 'method' => 'delete']) !!}
      {!! Form::submit('Unfollow', ['class' => "btn btn-danger btn-block"]) !!}
    {!! Form::close() !!}
  @else
    {!! Form::open(['route' => ['users.follow', $user->id]]) !!}
      {!! Form::submit('Follow', ['class' => "btn btn-primary btn-block"]) !!}
    {!! Form::close() !!}
  @endif
@endif
