<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Log as Log2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class LogController extends Controller
{

    /**
     * Handle a list of log request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'room_id' => 'required',
                'user_name' => 'required'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                return response()->json([
                    'result' => '-1',
                    'error_code' => '1',
                    'error_message' => $errors,
                ]);
            }

            $log = Log2::list($request->all());
            Log::debug("log", ['Log' => $log, 'line' => __LINE__]);

            if (!$log) {
                Log::error("get log error");
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                        ], 400);
            }

            Log::debug("get list of log successfully", ['line' => __LINE__]);
            return response()->json(['result' => 0, 'log' => $log]);
        } catch (\Exception $e) {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        }
        return $this->doResponse($this->success, $this->data, $this->error);
    }

    public function upSert(Request $request){
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'room_id' => 'required|exists:rooms,room_id',
                'user_name' => 'required'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                return response()->json([
                    'result' => '-1',
                    'error_code' => '1',
                    'error_message' => $errors,
                ]);
            }
        
            $data = $request->except('id');
            $agent = $request->header('user-agent');
            $data = Arr::add($data, 'user_agent', $agent);
            if(array_key_exists('start_time', $data)) $data['start_time'] =  date('Y-m-d H:i:s');
            if(array_key_exists('end_time', $data)) $data['end_time'] =  date('Y-m-d H:i:s');

            if(!empty($request->id)){
                $is_updated = Log2::where('id', $request->id)->update($data);
                if($is_updated)
                    $this->data = Log2::where('id', $request->id)->first();
            }else{
                $this->data = Log2::create($data);
            };
            if(empty($this->data)){
                return response()->json([
                    'result' => '-1',
                    'error_code' => '-1',
                    'error_message' => "Update failed",
                    ], 200);
            } else{
                return response()->json(['result' => 0,
                    'id' => $this->data->id,
                    'room_id' => $this->data->room_id,
                    'user_name' => $this->data->user_name,
                    'user_agent' => $this->data->user_agent,
                    'version' => $this->data->version,
                    'start_time' => $this->data->start_time,
                    'end_time' => $this->data->end_time
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
}
