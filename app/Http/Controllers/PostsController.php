<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostsController extends Controller {
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // handle file upload
        if ($request->hasFile('cover_image')) {
            // getting filename of upload file
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            // get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            // uploading the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else {
            $fileNameToStore = 'noimage.jpg';
        }
        
        // creating a post
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
    
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $post = Post::find($id);

        if ($post->user_id == auth()->user()->id) {
            return view('posts.edit')->with('post', $post);
        }

        return redirect('/posts')->with("error", 'Unauthorized Page');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // deleting old image
        $post = Post::find($id);
        $old_image = $post->cover_image;

        if ($old_image != 'noimage.jpg' && $request->hasFile('cover_image')) {
            Storage::delete('public/cover_images/'.$old_image);
        }

        // handle file upload
        if ($request->hasFile('cover_image')) {
            // getting filename of upload file
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            // get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            // uploading the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else {
            $fileNameToStore = $old_image;
        }
        
        // creating a post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        $post->save();
    
        return redirect('/posts/' . $post->id)->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // TODO: need to add proper json response here
        $post = Post::find($id);

        // checking if logged in user has made this post
        if ($post->user_id == auth()->user()->id) {
            if ($post->cover_image != 'noimage.jpg') {
                Storage::delete('public/cover_images/'.$post->cover_image);
            }

            $post->delete();
            // return Response()->json([
            //     'response' => '200',
            //     'message' => 'Post Deleted'
            // ]);
            return redirect('/posts')->with('success', 'Post Deleted');
        }
        else {
            return redirect('/posts')->with('error', 'Error in deleting post');
        }
        
        // return Response()->json([
        //     'response' => '400',
        //     'message' => 'Deletion Error'
        // ]);
    }
}
