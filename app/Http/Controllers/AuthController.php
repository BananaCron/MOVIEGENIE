<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user_table',
            'username' => 'required|unique:user_table',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User successfully registered'], 201);
    }

    /**
     * Login a user and return a JWT token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Log in successfully',
            'token' => $token
        ]);
    }

    /**
     * Show all registered users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllUsers()
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User successfully deleted']);
    }

    /**
     * Update a user by ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $this->validate($request, [
            'email' => 'sometimes|required|email|unique:user_table,email,' . $id,
            'username' => 'sometimes|required|unique:user_table,username,' . $id,
            'password' => 'sometimes|required|min:6',
        ]);

        $user->email = $request->get('email', $user->email);
        $user->username = $request->get('username', $user->username);

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['message' => 'User successfully updated', 'user' => $user]);
    }
}
