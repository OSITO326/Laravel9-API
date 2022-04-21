<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;

class Authapi extends Controller
{
  public function response($user)
  {
    $token = $user->createToken(str()->random(40))->plainTextToken;
    return response()->json([
      'user' => $user,
      'token' => $token,
      'token_type' => 'Bearer'
    ]);
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed'
    ]);
    $user = User::create([
      'name' => ucwords($request->name),
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);
    $token = $user->createToken('myapptoken')->plainTextToken;
    $response = [
      'user' => $user,
      'token' => $token
    ];
    return response($response, 201);
  }

  public function login(Request $request)
  {
    $cred = $request->validate([
      'email' => 'required|string',
      'password' => 'required|string'
    ]);
    // Check email
    $user = User::where('email', $cred['email'])->first();
    // Check password
    // Check password
    if (!$user || !Hash::check($cred['password'], $user->password)) {
      return response([
        'message' => 'Unauthorized'
      ], 401);
    }

    $token = $user->createToken('myapptoken')->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token
    ];
    return response($response, 201);
  }

  public function logout()
  {
    auth()->user()->tokens()->delete();
    return [
      'message' => 'You have successfully logged out and token was successfull deleted.'
    ];
  }
}
