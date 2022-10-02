<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // return bcrypt(123123123);
        // return $request->all();
        // $data = $request->only(['email', 'password']);
        // if(Auth::attempt($data)) {

        // }else {

        // }

        $user = User::where('email', $request->email)->first();
        if($user) {

            if(Hash::check($request->password, $user->password)) {

                Auth::login($user);

                $token = $user->createToken('login')->plainTextToken;

                return response()->json([
                    'message' => 'Login Successfully',
                    'status' => 'Success',
                    'data' => [
                        'token' => $token
                    ]
                ], 200);

            }else {
                return response()->json([
                    'message' => 'Password does Not Match',
                    'status' => 'Success',
                    'data' => []
                ], 200);
            }

        }else {
            return response()->json([
                'message' => 'No User Found',
                'status' => 'Success',
                'data' => []
            ], 404);
        }

        // Auth::logout();
        // User::create();
        // bcrypt();
        // Hash::make();
    }
}
