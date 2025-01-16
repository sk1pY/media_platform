<?php /** @noinspection ReturnTypeCanBeDeclaredInspection */

/** @noinspection ALL */

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {

        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($validate)) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'User is not authenticated'], 401);
        }

        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out from all devices']);

    }
}
