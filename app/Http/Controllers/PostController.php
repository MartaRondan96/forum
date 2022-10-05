<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function show(Post $post)  // Con esto estamos inyectando el Post completo
	{
		$replies = $post->replies()->with('autor')->paginate(2);
		
		return view('posts.detail', compact('post','replies'));
	}

	public function store(PostRequest $post_request) 
	{
		$post_request->merge(['user_id' => auth()->id()]);
		Post::create($post_request->input()); // Esto coge todos los datos que vienen vía Post y los inserta
		return back()->with('message', ['success', __('Post creado correctamente')]);	
	}
}
