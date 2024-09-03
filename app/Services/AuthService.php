<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

/**
 * Log in user with the given credentials.
 * 
 * @param Array $credentials.
 * 
 * @return successOrFail message with data of user and if success.
 */
    public function login(array $credentials)
    {
        if(!$token = Auth::attempt($credentials))
        {
            return [
                'status' => 'error',
                'message' => 'Unauthorized',
                'code' => 404,
            ];
        }

        return [
            'status' => 'success', 
            'user' => Auth::user(),
            'token' => $token,
            'code' => 200,
        ];
    }

    /**
     * Register new user with given.
     * 
     * @param array $data data to register new user. 
     * 
     * @return string message new user is registered.
     * @return array $user the data of new user.
     * @return string $token .
     */
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('client');

        $token = Auth::login($user);

        return [
            'status' => 'success',
            'message' => 'New user is registered',
            'user' => $user,
            'token' => $token,
            'code' => 201,
        ];
    }

    
/**
 * Logout the current user
 * 
 * @return array[status, message , code].  
 */

    public function logout()
    {
        Auth::logout();

        return [
            'status' => 'success',
            'message' => 'Logout successfully',
            'code' => 200,
        ];
    }
}
?>