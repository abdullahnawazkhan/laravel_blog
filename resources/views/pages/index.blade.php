@extends('layouts.app')

@section('content')
    <div class='jumbotron text-center'>
        <h1>Homepage - {{$title}}</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus iure fugit odio voluptas quia recusandae sequi qui ad doloribus numquam veniam reiciendis incidunt ipsa, inventore, ipsam accusamus quis earum soluta.</p>
        
        @if (Auth::guest())
            <p><a class='btn btn-primary' href="/login">Login</a> <a class='btn btn-success' href="/register">Register</a></p>
        @endif
        
    </div>
   
@endsection