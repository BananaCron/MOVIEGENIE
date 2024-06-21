<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function register($username, $password, $gender)
    {
        try {
            // Create a new user instance
            $user = new User();
            $user->username = $username;
            $user->password = bcrypt($password); // Hash the password
            $user->gender = $gender;
            $user->save();

            return $user; // Return the created user instance
        } catch (\Exception $e) {
            // Log or handle any errors
            return null; // Return null to indicate failure
        }
    }
}
