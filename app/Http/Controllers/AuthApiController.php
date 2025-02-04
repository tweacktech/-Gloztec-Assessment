<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Trait\RespondsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthApiController extends Controller
{
    use RespondsTrait;
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->success(['user' => $user], 'registration successful');
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }



    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            // Generate a Sanctum token for the user
            $token = $user->createToken('authToken')->plainTextToken;

            return $this->success(['token' => $token], 'Login successfully');
        } catch (Throwable $th) {
            Log::error('Login failed: ' . $th->getMessage());
            return $this->error('Failed to process login: ' . $th->getMessage());
        }
    }


    public function logout(Request $request)
{
    try {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        return $this->success([], 'Logged out successfully');
    } catch (Throwable $th) {
        Log::error('Logout failed: ' . $th->getMessage());
        return $this->error('Failed to process logout: ' . $th->getMessage());
    }
}
}
