<?php

namespace App\Http\Controllers;

use App\Models\RoomConfig;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoomConfigController extends Controller
{

    public function info()
    {
        try {
            $this->data = RoomConfig::orderBy('id', 'desc')->first();
            $this->result = 200;
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
        return response()->json(
            [
            'result' => '0',
            'data'=> $this->data,
        ],
            $this->result
        );
    }

    public function infoForEndUser()
    {
        try {
            $this->data = RoomConfig::select('before_time','after_time')->orderBy('id', 'desc')->first();
            if(empty($this->data)){
                return response()->json([
                    'result' => '-1',
                    'error_code' => '-1',
                    'error_message' => "Get room config failed",
                    ], 200);
            } else{
                return response()->json(['result' => 0,
                    'before_time' => $this->data->before_time,
                    'after_time' => $this->data->after_time
                ]);
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
    }

    public function upSert(Request $request){
        try {
            $data  = $request->except('id');
            if(!empty($request->id)){
                $this->data = RoomConfig::where('id', $request->id)->update($data);
            }else{
                $this->data = RoomConfig::create($data);
            };
            $this->result = 200;
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
        return response()->json(
            [
            'result' => '0',
            'data'=> $this->data,
        ],
            $this->result
        );
    }
}
