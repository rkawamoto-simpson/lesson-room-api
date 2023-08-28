<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PersonalAccessToken;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $result = 400;
    private $data = null;

    public function login(Request $request)
    {
        try {
            $input = $request->all();
            $attributes = [
                'email' => 'メールアドレス',
                'password' => 'パスワード',
            ];
            $validate = Validator::make($input, [
                'email' => 'required',
                'password' => 'required'
            ], [
                'email.required' => config('message.error.required.email'),
                'password.required' => config('message.error.required.password'),
            ], $attributes);
            if ($validate->fails()) {
                $this->error = $validate->errors()->all();
                return response()->json([
                    'result' => '-1',
                    'error_code' => '401',
                    'error_message' => 'Unauthorized',
                        ], 401);
            }
            $credentials = request(['email', 'password']);
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $infoUser = Auth::guard('api')->user();
            $personAccessToken = [
                'tokenable_type' => "App\Models\User",
                'tokenable_id' => $infoUser->id,
                'name' => $infoUser->name,

                'token' => $token,
            ];
            PersonalAccessToken::updateOrCreate(['tokenable_id' => $infoUser->id], $personAccessToken);
            $this->result = 200;
            $data = $infoUser->token;
            $this->data = $data;
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        } catch (Exception $e) {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        }
        return response()->json([
            'result' => '0',
            'data'=> $this->data,],
            $this->result);
    }

    public function checkAuth()
    {
        try {
            if (auth('api')->check()) {
                $infoUser = Auth::guard('api')->user();
                $this->result = 200;
                $this->data = $infoUser->token;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        } catch (Exception $e) {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        }
        return response()->json([
            'result' => '0',
            'data'=> $this->data,],
            $this->result);
    }

    public function logout()
    {
        try {
            if (auth('api')->check()) {
                auth('api')->logout();
                $this->result = 200;
                $this->data = true;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        } catch (Exception $e) {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        }
        return response()->json([
            'result' => '0',
            'data'=> $this->data],
            $this->result);
    }

}
