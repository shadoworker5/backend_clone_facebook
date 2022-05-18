<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show($id)
    {
        return Comment:: //with(['user:id,name,email,token,image_path'])
            // ->
            where('comments.id', '=', $id)
            ->get();
    }
}
