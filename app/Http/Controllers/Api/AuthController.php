<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function __construct()
    {
      //  $this->middleware('auth:api')->expect(['login','register']);
    }


    public function register(RegisterRequest $request){
        try {
            DB::beginTransaction();
            $user=User::create($request->validated());
            DB::commit();
          return response()->json([
              'data'=>"Registration successful",
              'status'=>Response::HTTP_CREATED
          ],Response::HTTP_OK);

        }catch (Exception $exception){
            DB::rollBack();

            return response()->json([
                'data'=>$exception->getMessage(),
                'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function login(LoginRequest $request){

        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'message' => ['The provided credentials are incorrect.'],
                ]);
            }
            return  $this->makeToken($user);
        }catch (QueryException $exception){
            return response()->json([
                'data'=>$exception->getMessage(),
                'status'=>$exception->getCode(),
                'type'=>'error'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    private function  makeToken($user){
        $token= $user->createToken('bearer-token')->plainTextToken;
        return AuthResource::make($user)->additional(['meta' => [
            'token' => $token,
            'token_type' => 'Bearer',
        ]]);
    }

    public function me(){
        return auth()->user();
    }


    public function logout(Request $request){

        try {
            $request->user()->tokens()->delete();
            return response([
                'data'=>'Successfully logout',
                'status'=>Response::HTTP_OK,
                'type'=>'success'
            ]);
        } catch (\Exception $e) {
            return response([
                'data'=>$e->getMessage(),
                'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                'type'=>'error'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
