<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        return Post::with(['user:id,name,token,image_path'])
            ->withSum('like', 'like')
            ->withSum('like', 'dislike')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function show($id)
    {
        return Post::with(['user:id,name,email,token,image_path'])
            ->withSum('like', 'like')
            ->withSum('like', 'dislike')
            ->where('posts.id', '=', $id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function addPost()
    {
        $post = new Post();
        $post->content = "Test agina";
        $post->save();
    }

    public function addComment(Request $request)
    {
        $post = Post::find($request->post_id);
        $comment = new Comment();
        $comment->comment = $request->commente;
        $comment->user_id = $request->user_id;
        $post->comments()->save($comment);

        return response()->json([
            'message' => 'Comment save with success'
        ]);
    }

    public function getCommentByPost($id)
    {
        return DB::select("SELECT * FROM comments INNER JOIN users WHERE post_id = '$id' AND user_id = users.id ");
        // return Post::find($id)->comments;
    }

    public function getPost()
    {
        return Post::with('user:id,name,token,image_path')->get();
    }
}

// En mode web je n'arrives pas à lire les écritures car la qualité de l'image n'est pas bonne. Je suis obligé à chaque fois de faire suivant lorsque je termines une partie. Aussi quand je mets la formation en pause et que je revienne une autre fois, ma progression n'est pas prise en compte. Je reprends souvent tous une section avant de me retrouver.