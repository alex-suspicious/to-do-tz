<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\Tasks;
use App\Models\User;

class AuthController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function login( Request $request )
    {
        if (!Auth::attempt($request->only('login', 'password'))) {
            return response()->json([
                'message' => 'Incorrect login or password'
            ], 401);
        }

        $user = User::where('login', $request['login'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout( Request $request )
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->user('sanctum')->currentAccessToken()->delete();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function hash( Request $request )
    {
        return Hash::make( $request->input("password") );
    }

}
