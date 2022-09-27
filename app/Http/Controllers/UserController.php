<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // REGISTER REPOSITORY
   public function register(Request $request)
   {
    //VALIDATION
    $data = $request->validate([
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:3|confirmed',
        
    ]);
    //CREATION
    $user = User::create([
        'first_name' => $data['firstName'],
        'last_name' => $data['lastName'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        
    ]);

    $token = $user->createToken('User Password Grant Client')->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token,
    ];

    return response($response, 200);
    }

    // LOGIN REPOSITORY
   public function login(Request $request){

    $data = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $data['email'])->first();

    if(!$user || !Hash::check($data['password'], $user->password)){

        return response(['message: Invalid credentials'], 404);
    }
    else
    {
        $token = $user->createToken('User Password Grant Client')->plainTextToken;
            
            $response = [
                'user' => $user,
                'token' => $token,
            ];
    
            return response($response, 200);
    }
    
   }

   // LOGOUT REPOSITORY
   public function logout(Request $request){
    $request->user()->tokens()->delete();
    return response(['message: Successfully logged out', 200]);
   }
}
