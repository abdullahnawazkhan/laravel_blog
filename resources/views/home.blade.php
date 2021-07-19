@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/posts/create" class='btn btn-primary mb-3'>Create New Post</a>
                    
                    <h3>Your Blog Posts</h3>
                    
                    @if (count($posts) > 0)
                        <table class='table table-striped'>
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Created On</th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td><a href="/posts/{{ $post->id }}" class='btn btn-primary'>View</a></td>
                                    <td><a href="/posts/{{ $post->id }}/edit" class='btn btn-secondary'>Edit</a></td>
                                    {{-- delete button --}}
                                    <td>
                                        {{-- button to open up boostrap modal --}}
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                            Delete
                                        </button>

                                        {{-- Bootstrap Modal used as confirmation dialog --}}
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
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        {{-- continue with delete button --}}
                                                        {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                                                            {{Form::hidden('_method', 'DELETE')}}
                                                             {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                        {!!Form::close()!!}
                                                    </div>
                                              </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $post->created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no Posts</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
