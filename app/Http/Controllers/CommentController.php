<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('PemilikComment')->only('update', 'delete');
    }
    public function store(Request $request)
    {
        $request['author'] = Auth::user()->id;
        // dd($request);

        $validated = $request->validate([
            'author' => 'required',
            'post_id' => 'required|exists:posts,id' ,
            'comments_content' => 'required',
        ]);



        $comment = comments::create($request->all());

        return new CommentsResource($comment);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comments_content' => 'required|string'
        ]);

        $comment = comments::findOrFail($id);
        $comment->update($request->all());

        return new CommentsResource($comment->loadMissing('commentator'));
    }

    public function delete($id){

        $comment = comments::findOrFail($id);
        $comment->delete();

        return response()->json([
            'message' => 'comment has been deleted'
        ]);
    }
}
