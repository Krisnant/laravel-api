<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    // public function index(Request $request){
    //             // Set your Merchant Server Key
    //     \Midtrans\Config::$serverKey = 'SB-Mid-server-zdes1ucDzdeTx4kKL3hUi1y1';
    //     // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    //     \Midtrans\Config::$isProduction = false;
    //     // Set sanitization on (default)
    //     \Midtrans\Config::$isSanitized = true;
    //     // Set 3DS transaction for credit card to true
    //     \Midtrans\Config::$is3ds = true;

    //     $params = array(
    //         'transaction_details' => array(
    //             'order_id' => rand(),
    //             'gross_amount' => 10000,
    //         ),
    //         'customer_details' => array(
    //             'first_name' => 'budi',
    //             'last_name' => 'pratama',
    //             'email' => 'budi.pra@example.com',
    //             'phone' => '08111222333',
    //         ),
    //     );

    //     $snapToken = \Midtrans\Snap::getSnapToken($params);

    //     return view('welcome', ['snap_token'=>$snapToken]);
    // }

    public function register()
    {
        $validator = Validator::make(request()->all(),[
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages());
        }

        $user = User::create([
            'name'=> request('name'),
            'email'=> request('email'),
            'password'=> Hash::make (request('password')),
        ]);
        if($user){
            return response()->json(['message' => 'Registration Successful']);
        }else{
            return response()->json(['message' => 'Registration Failed']);
        }   
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
};
