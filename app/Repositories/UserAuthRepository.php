<?php

namespace App\Repositories;

use App\Interfaces\UserAuthRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserAuthRepository implements UserAuthRepositoryInterface
{
    public function signup(Request $req)
    {
        // Implement signup logic here
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

    public function login(Request $req)
    {
        // Implement login logic here
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

    public function logout(Request $req)
    {
        // Implement logout logic here
        try {
            // Check if the user is authenticated
            $user = $req->user();  // Get the authenticated user from the request

            // If no user is authenticated, return a custom response
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'msg' => "No user is logged in."
                ], 401);  // 401 Unauthorized (if no user is logged in)
            }

            // Proceed with logging out the user by deleting their tokens
            $user->tokens()->delete();  // Delete all tokens to log out the user
            $user->token = null;         // Clear the current token
            $user->save();               // Save the updated user

            // Return success response
            return response()->json([
                'success' => true,
                'msg' => "Logout successful."
            ], 200);  // Return 200 OK on successful logout

        } catch (\Exception $e) {
            // Catch any exceptions and return an error response
            return response()->json([
                'success' => false,
                'msg' => "Logout failed.",
                'error' => $e->getMessage()
            ], 500);  // 500 Internal Server Error in case of failure
        }
    }
}
