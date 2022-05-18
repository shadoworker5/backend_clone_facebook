<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * This method is use to authenticate user by API
     */
    public function login(Request $request){         
        $validator = Validator::make($request->all(), [
            'email'             => 'required|string|email',
            'password'          => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ], 202);
        }else{
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'status'    => 401,
                    'message'   => 'Email/password is incorrect',
                    'pass'  => $user
                ]);
            }else{
                $token = $user->createToken($user->email.'_Token')->plainTextToken;
        
                return response()->json([
                    'status'=> 200,
                    'user'  => $user,
                    'app_token' => $token,
                ]);
            }
        }
    }

    /**
     * This method is use to register user by API
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|min:5',
            'email'             => 'required|string|unique:users,email',
            'pseudo'            => 'required|string|min:5',
            'phone'             => 'required|min:8',
            'password'          => 'required|string|same:confirm_password',
            'confirm_password'  => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ], 202);
        }else{
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'user_name' => $request->pseudo,
                'contact'   => $request->phone,
                'token'     => Str::random(64),
                'password'  => Hash::make($request->password),
            ]);
    
            $app_token = $user->createToken($user->email.'_Token')->plainTextToken;
    
            return response()->json([
                'status'    => 200,
                'user'      => $user,
                'app_token' => $app_token,
            ]);
        }

    }

    public function logout(){
        auth()->user()->tokens()->delete();

        // $user->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            'status'    => 200,
            'message'   => 'Logged out sucess'
        ]);
    }
}
