<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $userService;

    // Constructor to inject UserService dependency
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Method to register a new user
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user_table',
            'username' => 'required|unique:user_table',
            'password' => 'required|min:6',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Prepare user data for registration
        $userData = [
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Register the user using the UserService
        $user = $this->userService->register($userData);

        // Return success response
        return response()->json(['message' => 'User successfully registered'], 201);
    }

    // Method to login a user
    public function login(Request $request)
    {
        try {
            // Get email and password from the request
            $credentials = $request->only(['email', 'password']);

            // Attempt to create a token using the credentials
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Return success response with the token
            return response()->json([
                'message' => 'Log in successfully',
                'token' => $token
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions during login
            return response()->json(['error' => 'Login failed. Please try again later.'], 500);
        }
    }

    // Method to get all users
    public function showAllUsers()
    {
        // Get all users from the UserService
        $users = $this->userService->getAllUsers();

        // Return the list of users
        return response()->json($users);
    }

    // Method to delete a user by ID
    public function deleteUser($id)
    {
        // Attempt to delete the user
        $deleted = $this->userService->deleteUser($id);

        // Return error if user not found
        if (!$deleted) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return success response
        return response()->json(['message' => 'User successfully deleted']);
    }

    // Method to update a user by ID
    public function updateUser(Request $request, $id)
    {
        // Get the new user data from the request
        $userData = $request->only(['email', 'username', 'password']);

        // Attempt to update the user
        $updatedUser = $this->userService->updateUser($id, $userData);

        // Return error if user not found
        if (!$updatedUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return success response with the updated user data
        return response()->json(['message' => 'User successfully updated', 'user' => $updatedUser]);
    }
}
