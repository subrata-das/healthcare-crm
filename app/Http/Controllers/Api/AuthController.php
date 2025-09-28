<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    use ApiResponser;
 
    public function login(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return $this->error('Unprocessable input', $validator->errors(), 422);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('ApiToken')->plainTextToken; 
            $success['user'] =  $user->name;
            $success['type'] =  "Bearer";
            return $this->success($success, 'User login successfully.');
        }else{ 
            return $this->error('Authentication Failed.', ['error'=>'Unauthorized'], 401);
        }
    }
 
    public function users()
    {
        // $users = User::select('name', 'email')->get();
 
        return $this->success([
            'users' => auth()->user()
        ], 'User list featched successfully!!');
    }
 
    public function logout()
    {
        auth()->user()->tokens()->delete();
 
        return response()->json([
            'message' => 'Logout successfully!!'
        ]);
    }
}
