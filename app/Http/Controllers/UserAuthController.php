<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    function signup(Request $req)
    {
        $input = $req->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $token = $user->createToken("my-app")->plainTextToken;

        // Store the generated token in the 'token' field
        $user->token = $token;
        $user->save();

        $success['token'] = $token;
        return response()->json(['success' => true, 'msg' => "User registered successfully.", 'user' => $user], 201);
    }

    function login(Request $req)
    {
        return "login";
    }
}
