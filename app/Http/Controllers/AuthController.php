<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
//    use SendsPasswordResetEmails, ResetsPasswords;
    /**
     * Handle the login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'login_type' => 'required|in:email,contact_number', // Login type can be either email or contact_number
            'login' => 'required',
            'password' => 'required',
        ]);
    
        // Check whether the login is through email or contact_number
        $loginType = $request->login_type;
        $loginField = $loginType === 'email' ? 'email' : 'contact_number';
        $loginValue = $request->login;
    
        // Try to find the user based on the login type (email or contact number)
        $user = User::where($loginField, $loginValue)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            // If the user is not found or the password does not match, return an error
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        // Optionally rehash the password if needed
        if (Hash::needsRehash($user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
    
        // Generate a Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }


    /**
     * Handle the logout request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function register(Request $request)
    {
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:users,email', // Email can be provided but is optional
        'contact_number' => 'nullable|digits:10|unique:users,contact_number', // Contact number can be provided but is optional
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // Ensure that at least one of email or contact number is provided
    if (!$request->email && !$request->contact_number) {
        return response()->json([
            'message' => 'Either email or contact number is required.'
        ], 422);
    }

    // Create the new user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email, // This can be null if not provided
        'contact_number' => $request->contact_number, // This can be null if not provided
        'password' => Hash::make($request->password),
        'role_id'=>2,
    ]);

    // Assign role with ID 2 (for example, 'user' role)
    // $user->role_id(2); // Assuming you're using Spatie's Laravel Permission package or have role with ID 2

    // Generate Sanctum token for the user
    // $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Registration successful',
        // 'token' => $token,
        'user' => $user,
    ]);
}


    public function updateProfile(Request $request)
{
    $user = auth()->user();

    $validatedData = $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255|unique:users,email,'.$user->id,
        'contact_number' => 'nullable|string|max:255|unique:users,contact_number,'.$user->id,
        'birthday' => 'nullable|date',
        'gender' => 'nullable|string',
        'city' => 'nullable|integer',
        'avatar_url' => 'nullable|string',
    ]);

    $user->update($validatedData);

    return response()->json(['message' => 'Profile updated successfully']);
}
}
