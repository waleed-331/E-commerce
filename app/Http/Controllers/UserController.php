<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\UserProfileResource;
use App\Models\Product;
use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function sendResponse($result, $message): \Illuminate\Http\JsonResponse
    {

        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errormessage = [], $code = 404): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'data' => $error
        ];
        if (!empty($errormessage)) {
            $response['data'] = $errormessage;
        }
        return response()->json($response, $code);
    }

    public function Register(Request $request): \Illuminate\Http\JsonResponse
    {
       $request->headers->set('Accept','application/json');
        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'name' => $request->name,
        ]);
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'token' => $token
        ],200);
    }

    public function Login(Request $request): \Illuminate\Http\JsonResponse
    {

        $request->headers->set('Accept', 'application/json');
        $user = User::where('email', $request->email)->first();
        if ($user && $request->password == $user->password) {
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'message' => "incorrect credentials"
            ], 401);
        }
         }

          public function show_profile()
          {
              $user=Auth::user();

              $details=Product::where('user_id',Auth::id())->get();

              return  response()->json(array($user,$details));

          }

    public function Logout(Request $request): \Illuminate\Http\JsonResponse
    {
//        $request->user()->token()->revoke();
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}


