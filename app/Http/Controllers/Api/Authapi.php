<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
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
    return $this->response($user);
  }

  public function login(Request $request)
  {
    $cred = $request->validate([
      'email' => 'required|email|exists:users',
      'password' => 'required',
    ]);
    if (!Auth::attemp($cred)) {
      return response()->json([
        'message' => 'Unauthorized.'
      ], 401);
      return $this->response(Auth::user());
    }
  }

  public function logout()
  {
    Auth::user()->tokens()->delete();
    return response()->json([
      'message' => 'You have successfully logged out and token was successfull deleted.'
    ]);
  }
}
