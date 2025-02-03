<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    function signup(Request $req)
    {
        try {
            $validatedData = $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $validatedData["password"] = bcrypt($validatedData["password"]);
            $user = User::create($validatedData);
            $token = $user->createToken("my-app")->plainTextToken;

            // Store the generated token in the 'token' field
            $user->token = $token;
            $user->save();

            return response()->json(['success' => true, 'msg' => "User registered successfully.", 'user' => $user, 'token' => $token], 201);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'msg' => "Validation failed.", 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => "User registration failed.", 'error' => $e->getMessage()], 500);
        }
    }

    function login(Request $req)
    {
        $validatedData = $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            $user = User::where('email', $req->email)->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($req->password, $user->password)) {
                return response()->json([
                    "success" => false,
                    "msg" => "Invalid email or password."
                ], 401);
            }

            // Generate new token
            $token = $user->createToken("my-app")->plainTextToken;

            // Store the new token in the 'token' field
            $user->token = $token;
            $user->save();

            return response()->json([
                'success' => true,
                'msg' => "Login successful.",
                'user' => $user,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => "Login failed.", 'error' => $e->getMessage()], 500);
        }
    }

    function logout(Request $req)
    {
        try {
            $user = $req->user();
            $user->tokens()->delete();
            $user->token = null;
            $user->save();

            return response()->json([
                'success' => true,
                'msg' => "Logout successful."
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => "Logout failed.", 'error' => $e->getMessage()], 500);
        }
    }
}
