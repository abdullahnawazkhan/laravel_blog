@extends('layouts.app')

@section('content')
    <a href='/posts' class='btn btn-outline-secondary mb-2'>Go Back</a>
    <h1>{{ $post->title }}</h1>

    <img src="/storage/cover_images/{{ $post->cover_image }}" style='width:100%'>
    <br><br>

    <div>
        {{ $post->body }}
    </div>

    <hr>

    <small>Written on {{ $post->created_at }} by {{ $post->user->name }}</small>
    
    <hr>
    
    @if (!Auth::guest())
        @if (Auth::user()->id == $post->user_id)
            <a href="/posts/{{ $post->id }}/edit" class='btn btn-primary'>Edit</a>

            {{-- button to open up boostrap modal --}}
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                Delete
            </button>

            {{-- Bootstrap modal used as confirmation dialog --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Deleted posts cannot be recovered
                        </div>
                        <div class="modal-footer">
                            {{-- cancel button --}}
                            <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Cancel</button>
                            {{-- continue with delete button --}}
                            {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}
                        </div>
                </div>
                </div>
            </div>
        @endif
    @endif
    
@endsection