<?php

namespace App\Http\Controllers;

use Google_Client;
use App\Models\User;
use Firebase\JWT\JWT;
use Facebook\Facebook;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
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
            'fcm_token' => 'nullable|string',
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
        // if (Hash::needsRehash($user->password)) {
        //     $user->password = Hash::make($request->password);
        //     $user->save();
        // }
        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
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
        'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
        'contact_number' => 'nullable|string|max:255|unique:users,contact_number,' . $user->id,
        'birthday' => 'nullable|date',
        'gender' => 'nullable|string',
        'country' => 'nullable|string|max:255',
        'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    // Check if the country was provided
    if (!empty($validatedData['country'])) {
        // Find or create the country in the countries table
        $country = Country::firstOrCreate(['name' => $validatedData['country']]);

        // Set the country_id in the validated data
        $validatedData['Country_id'] = $country->id;

        // Remove the 'country' field from the validated data (since it's not a column in the users table)
        unset($validatedData['country']);
    }

    // Check if the request contains an avatar file
    if ($request->hasFile('avatar_url')) {
        $file = $request->file('avatar_url');
        // Store the file in the 'public' directory (this will place it in storage/app/public)
        $path = $file->store('', 'public');
        // Get the file name to store in the database
        $filename = basename($path);

        // Save the filename or path in the avatar_url field of the user
        $validatedData['avatar_url'] = $filename;
    }

    // Update the user's profile with the validated data
    $user->update($validatedData);

    return response()->json(['message' => 'Profile updated successfully']);
}

public function getProfile(Request $request)
{
    // Get the authenticated user and ensure the 'country' relationship is loaded
    $user = auth()->user()->load('country');

    // Determine if the avatar URL is an external link or local storage
    $avatarUrl = $user->avatar_url;
    if ($avatarUrl) {
        if (preg_match('/^(http|https):\/\//', $avatarUrl)) {
            $avatarUrl = $avatarUrl; // External URL, use as-is
        } else {
            $avatarUrl = url("storage/" . $avatarUrl); // Local storage URL
        }
    }

    // Return the user profile data as JSON, including the country name
    return response()->json([
        'name' => $user->name,
        'email' => $user->email,
        'contact_number' => $user->contact_number,
        'birthday' => $user->birthday,
        'gender' => $user->gender,
        'avatar_url' => $avatarUrl,
        'country' => $user->country ? $user->country->name : null, // Ensure country name is returned
    ]);
}


public function handleToken(Request $request)
{
    $request->validate([
        'token' => 'required|string',
        'provider' => 'required|string|in:google,facebook,instagram,apple',
    ]);

    try {
        // Retrieve the user information from the provider using the token
        $socialUser = Socialite::driver($request->provider)->userFromToken($request->token);

        // Find or create the user in your database
        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'avatar_url' => $socialUser->getAvatar(),
                'provider' => $request->provider,
                'provider_id' => $socialUser->getId(),
            ]
        );

        // You may want to generate a new token for your app here
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Unable to authenticate user '.$e->getmessage()], 401);
    }
}

public function verifyGoogleToken(Request $request)
{
    $request->validate([
        'token' => 'required|string',
        'fcm_token' => 'nullable|string', // Validate FCM token if provided
    ]);

    $token = $request->input('token');
    $fcmToken = $request->input('fcm_token'); // Retrieve FCM token from the request

    Log::info('Attempting to verify Google token: ' . substr($token, 0, 10) . '...');

    $client = new Google_Client(['client_id' => config('services.google.client_id_mobile')]);

    try {
        Log::info('Google Client ID: ' . config('services.google.client_id'));

        $payload = $client->verifyIdToken($token);

        if ($payload) {
            Log::info('Token verified successfully. Payload: ' . json_encode($payload));

            // User creation/update logic
            $user = User::updateOrCreate(
                ['email' => $payload['email']],
                [
                    'name' => $payload['name'],
                    'provider_id' => $payload['sub'],
                    'avatar_url' => $payload['picture'],
                    'role_id' => 2,
                    'provider' => 'google',
                    'fcm_token' => $fcmToken, // Store or update the FCM token
                ]
            );

            Log::info('User created/updated: ' . $user->id);

            // Generate token for user
            $authToken = $user->createToken('google-token')->plainTextToken;

            Log::info('Authentication token created for user');

            // Log in the user
            Auth::login($user);

            Log::info('User logged in successfully');

            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $authToken,
            ]);

        } else {
            Log::error('Google token verification failed: Payload is empty');
            return response()->json(['success' => false, 'message' => 'Invalid token: Payload is empty'], 401);
        }
    } catch (\Google_Exception $e) {
        Log::error('Google_Exception during token verification: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Google token verification failed: ' . $e->getMessage(),
        ], 401);
    } catch (\Exception $e) {
        Log::error('Unexpected error during Google token verification: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Unexpected error: ' . $e->getMessage(),
        ], 500);
    }
}

    public function handleFacebookToken(Request $request)
{
    try {
        $accessToken = $request->input('access_token');
        
        // Verify the token
        $verifyResponse = Http::get('https://graph.facebook.com/oauth/access_token_info', [
            'client_id' => config('services.facebook.client_id_mobile'),
            'access_token' => $accessToken
        ]);
        
        if (!$verifyResponse->successful()) {
            return response()->json([
                'error' => 'Invalid Facebook token'
            ], 401);
        }
        
        // Get user info from Facebook
        $userResponse = Http::get('https://graph.facebook.com/me', [
            'fields' => 'id,name,email,picture',
            'access_token' => $accessToken
        ]);
        
        if (!$userResponse->successful()) {
            return response()->json([
                'error' => 'Failed to fetch user data'
            ], 400);
        }
        
        $userData = $userResponse->json();
        
        // Check if a user with the same email exists
        $existingUser = User::where('email', $userData['email'])->first();
        
        if ($existingUser) {
            // If user exists, update their Facebook info
            $existingUser->update([
                'provider_id' => $userData['id'],
                'provider' => 'facebook',
                'avatar_url' => $userData['picture']['data']['url'] ?? null,
            ]);
            $user = $existingUser;
        } else {
            // Create new user if no existing email match
            $user = User::create([
                'provider_id' => $userData['id'],
                'name' => $userData['name'],
                'email' => $userData['email'] ?? null,
                'avatar_url' => $userData['picture']['data']['url'] ?? null,
                'role_id' => 2, // Default role ID
                'provider' => 'facebook',
            ]);
        }
        
        // Generate Sanctum token for authentication
        $token = $user->createToken('facebook_token')->plainTextToken;

        // Return user data and token
        return response()->json([
            'user' => $user,
            'token' => $token,
            'facebook_data' => $userData
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}
public function handleFacebookTokenios(Request $request)
{
    try {
        // Get Facebook token from request
        $token = $request->input('access_token');
        if (!$token) {
            return response()->json(['error' => 'No token provided'], 400);
        }

        // Decode JWT token
        list($header, $payload, $signature) = explode('.', $token);
        $userData = json_decode(base64_decode($payload), true);

        if (!$userData) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        // Check if user exists by email
        $existingUser = User::where('email', $userData['email'] ?? null)->first();

        if ($existingUser) {
            // Update existing user with Facebook data
            $existingUser->update([
                'provider_id' => $userData['sub'], // Facebook ID
                'provider' => 'facebook',
                'avatar_url' => $userData['picture'] ?? null,
            ]);
            $user = $existingUser;
        } else {
            // Create new user
            $user = User::create([
                'provider_id' => $userData['sub'],
                'name' => $userData['name'] ?? 'Unknown',
                'email' => $userData['email'] ?? null,
                'avatar_url' => $userData['picture'] ?? null,
                'role_id' => 2, // Default role
                'provider' => 'facebook',
                // 'password' => Hash::make(uniqid()), // Random password
            ]);
        }

        // Generate Sanctum token
        $token = $user->createToken('facebook_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}

public function GetUsersById(Request $request){
    $validatedData=$request->validate([
        'user_ids'=>'required|array'
    ]);
    $users=User::whereIn('id',$validatedData['user_ids'])
    ->select('id','name','avatar_url')
    ->get()
    ->map(function($user){
        $avatarUrl = $user->avatar_url;
        if ($avatarUrl) {
            if (preg_match('/^(http|https):\/\//', $avatarUrl)) {
                $user->avatar_url = $avatarUrl; // External URL, use as-is
            } else {
                $user->avatar_url = url("storage/" . $avatarUrl); // Local storage URL
            }
        }
        return $user;
    });
    
    return response()->json([
        // 'message'=>'hi',
        'users'=>$users,
        
        

    ]);

}

public function handleMicrosoftToken(Request $request)
{
    $request->validate([
        'access_token' => 'required|string',
        // 'fcm_token' => 'nullable|string',
    ]);

    try {
        $accessToken = $request->input('access_token');
        // $fcmToken = $request->input('fcm_token');

        // Verify the token and get user info
        $userResponse = Http::withToken($accessToken)->get('https://graph.microsoft.com/v1.0/me');

        if (!$userResponse->successful()) {
            return response()->json(['error' => 'Invalid Microsoft token'], 401);
        }

        $userData = $userResponse->json();

        $email = $userData['mail'] ?? $userData['userPrincipalName'] ?? null;

        if (!$email) {
            return response()->json(['error' => 'No email provided in user data'], 400);
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'provider_id' => $userData['id'],
                'provider' => 'microsoft',
                'name' => $userData['displayName'] ?? 'Microsoft User',
                // 'fcm_token' => $fcmToken,
            ]
        );

        $token = $user->createToken('microsoft_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'microsoft_data' => $userData
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}
}