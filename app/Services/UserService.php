<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    // Method to register a new user
    public function register($data)
    {
        // Create and return a new User model instance with hashed password
        return User::create([
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // Method to retrieve all users
    public function getAllUsers()
    {
        // Retrieve and return all User model instances
        return User::all();
    }

    // Method to delete a user by ID
    public function deleteUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // If user exists, delete it and return true
        if ($user) {
            $user->delete();
            return true;
        }

        // If user does not exist, return false
        return false;
    }

    // Method to update user details by ID
    public function updateUser($id, $data)
    {
        // Find the user by ID
        $user = User::find($id);

        // If user does not exist, return null
        if (!$user) {
            return null;
        }

        // Update user's email if provided
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        // Update user's username if provided
        if (isset($data['username'])) {
            $user->username = $data['username'];
        }

        // Update user's password if provided (hash the new password)
        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Save the updated user details
        $user->save();

        // Return the updated user model instance
        return $user;
    }
}
