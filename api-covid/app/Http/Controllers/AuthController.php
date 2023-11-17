<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    #membuat fitur register
    public function register(Request $request){
        #menangkap inputan
        $input = [
            'name'=> $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password), 
        ];
        #menginsert data ke tabel user
        $user = User::create($input);
        $data = [
            'message' => 'User is Created Succesfully',
        ];
        #mengirim response JSON 
        return response()->json($data,200);
    }

    #membuat fitur login
    public function login(Request $request){
        #menangkap input user
        $input = [
            'email'=> $request->name,
            'password'=> $request->password,
        ];

        #mengambil data user (DB)
        $user = User::where('email',$input['email'])->first();
        #membandingkan input user dengan data user (DB)
        $isLoginSuccesfully = (
            $input['email'] == $user->email
            &&
            Hash ::check($input['password'], $user->password)
        );
        #melakukan autentifikasi
        if($isLoginSuccesfully){
            #membuat token
            $token = $user->createToken('auth_token');

            $data = [
                'message'=> 'Login Succesfully',
                'token' => $token-> plainTextToken,
            ];
            #mengembalikan response JSON
            return response()->json($data,200);
        }else{
            $data = [
                'message'=> 'Username or Password is wrong',
            ];
            #mengembalikan response JSON
            return response()->json($data,401);
        }
    }
}