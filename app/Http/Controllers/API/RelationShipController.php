<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RelationShip;
use App\Models\User;
use Illuminate\Http\Request;

class RelationShipController extends Controller
{
    public function update(Request $request){
        $relation_ship = RelationShip::findOrFail($request->id);
        $relation_ship->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => $request->status === '1' ? "You have new friend: $relation_ship" : 'Friend request refuse',
        ]);
    }

    public function getNofifyByUser($user_token){
        $user = User::where('token', $user_token)->get();
        $result = RelationShip::with('user:id,name,token,image_path')->where('status', '0')->where('user_id2', $user[0]->id)->get();
        
        return response()->json([
            'count' => count($result),
            'user'  => $result
        ]);
    }
}
