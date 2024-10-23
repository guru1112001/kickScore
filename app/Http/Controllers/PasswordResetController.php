<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'current' => 'required|string',
            'new_password' => 'required|string|min:6',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['message' => 'Current password is wrong'], 401);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['message' => 'Password changed successfully'], 201);
    }
}
