<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Models\posts;
use Illuminate\Http\Request;
use App\Http\Resources\PostsResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only('store', 'update', 'delete');
        $this->middleware(['PemilikPost'])->only('update', 'delete');
    }

    public function index()
    {
        $posts = posts::all();
        // return response()->json(['data' => $posts]);
        return PostsResource::collection($posts);
    }

    public function show($id) {
        
        $post = posts::findOrFail($id);
        return new PostDetailResource($post);
        // return response()->json(['data' => $post]);

    }

    public function show2($id) {
        
        $post = posts::findOrFail($id);
        return new PostDetailResource($post);
        // return response()->json(['data' => $post]);

    }
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function store(Request $request)
    {
        $request['author'] = Auth()->id();
        $request->validate([
            'title' => 'required',
            'news_content' => 'required'
        ]);

        $post = posts::create([
            'title' => $request->input('title'),
            'news_content' => $request->input('news_content'),
            'author' => Auth::user()->id,
        ]);
        

        return new PostDetailResource($post);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'news_content' => 'required|string'
        ]);

        $post = posts::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer'));
    }

    public function delete($id)
    {
        $post = posts::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'your post has been deleted'
        ]);
    }

}
