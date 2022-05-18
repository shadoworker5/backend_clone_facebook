<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use App\Models\RelationShip;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $file_name;

    public function index(){
        return User::all();
    }

    public function getUserList($user_token){
        $user = User::where('token', $user_token)->get();
        $result = User::find($user[0]->id)->relationShip()->where("user_id", "!=", $user[0]->id)->orWhere('user_id2', "!=", $user[0]->id)->get();
        // $result = User::with("");
        // KNAlSp87HzTFfJEtzohiBNOckC8dOZmPcIf1OCAoeqvHOVmKJqmbj0XzIQXOlZ6Q
        return $result;
    }

    public function show($user_token){
        // $user = User::where('email', $email)->get();
        $user = User::where('token', $user_token)->get();
        return response()->json([
            'status'    => 200,
            'user'      => $user,
        ]);
    }

    public function sendFriendRequest(Request $request){
        $user = User::find($request->user_id1);
        $relation = new RelationShip();
        $relation->user_id2 = $request->user_id2;
        $user->relationShip()->save($relation);

        return  response()->json([
            'status'    => 200,
            'message'   => 'Friend request send with success!!!'
        ]);
    }

    public function getPostByUser($token){
        $user = User::where('token', $token)->get();
        return User::find($user[0]->id)->post;
    }

    public function getNofifyByUser($user_token){
        $user = User::where('token', $user_token)->get();
        $result = User::find($user[0]->id)->relationShip()->where('status', '0')->get();
        
        return response()->json([
            'count' => count($result),
            'user_id' => $result
        ]);
    }

    public function sendPostByPost(Request $request){
        
        if(is_file($request->file('post_img'))){
            $this->file_name = md5(date('YmdHis')).'.'. explode('.', $request->file('post_img')->getClientOriginalName())[1];
            $request->file('post_img')->move(public_path('post_image_path'), $this->file_name);
        }

        $user = User::find($request->user_id);
        $post = new Post();
        $post->content = $request->content;
        $post->image_path = $request->file_name;
        $user->post()->save($post);
        
        return  response()->json([
            'status'    => 200,
            'message'   => 'Post save seccufuly!!!!!!!',
        ]);
    }

    public function addLike(Request $request){
        $user = User::find($request->user_id);
        $like = new Like();
        $like->post_id = $request->post_id;
        if($request->value === 'like'){
            $like->like += 1;
        }else{
            $like->dislike += 1;
        }
        $user->like()->save($like);

        return  response()->json([
            'status'    => 200,
            'message'   => 'Emotion save seccufuly!!!!!!!',
        ]);
    }

    public function addDislike(Request $request){
        return $request;
    }

    public function searchUser($name){
        $user = User::where('name', 'LIKE' ,'%'.$name.'%')->get();
        return response()->json([
            'user'      => $user,
        ]);
    }

    public function showUser($id){
        $user = User::find($id)->get(["name"])[0];
        return $user;
    }
}