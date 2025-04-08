<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OTPController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'phone' => ['required'],
        ]);

        $user = auth()->user();

        // Verify the phone number using Aywa API
        $response = Http::post('https://aywa.sd/otp/UserVerificationCheck.php', [
            'phone' => $request->phone,
            'otp' => $request->otp,
        ]);


        if ($response->ok() && $response->json('verified') == 1) {
            // ✅ Update the user's phone number and verification status
            $user->update([
                'phone' => $request->phone,
                'phone_verified_at' => now(),
                'is_phone_verified' => true,
            ]);

            return response()->json([
                'verified' => true,
                'message' => 'Phone number has been updated and verified successfully.',
            ]);
        }

        return response()->json([
            'verified' => false,
            'message' => 'Verification failed. Please try again.',
        ], 422);
    }

    public function verifySuccess(Request $request)
    {
        $user = auth()->user();

        // Get the phone number from the request
        $phone = $request->input('phone');
        // Validate the phone number

        if (!$phone) {
            return response()->json(['status' => 'no_phone_provided'], 422);
        }

        // Check with Aywa API
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post('https://aywa.sd/otp/UserVerificationCheck.php', [
            'phone' => $phone,
            'otp' => session('otp'),
        ]);

        $data = $response->json();
        if (isset($data['status']) && $data['verified'] == 1) {
            $user->update([
                'phone' => $phone,
                'phone_verified_at' => now(),
            ]);
            // Optionally, you can clear the OTP session after successful verification
            return response()->json(['status' => 'verified']);
        }
        // If verification fails, you can return an error response
        return response()->json(['status' => 'not_verified'], 422);
    }
}
