<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user_table',
            'username' => 'required|unique:user_table',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $userData = [
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        $user = $this->userService->register($userData);

        return response()->json(['message' => 'User successfully registered'], 201);
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            return response()->json([
                'message' => 'Log in successfully',
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Login failed. Please try again later.'], 500);
        }
    }

    public function showAllUsers()
    {
        $users = $this->userService->getAllUsers();

        return response()->json($users);
    }

    public function deleteUser($id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User successfully deleted']);
    }

    public function updateUser(Request $request, $id)
    {
        $userData = $request->only(['email', 'username', 'password']);

        $updatedUser = $this->userService->updateUser($id, $userData);

        if (!$updatedUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User successfully updated', 'user' => $updatedUser]);
    }
}
