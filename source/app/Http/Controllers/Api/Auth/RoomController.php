<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Config;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Api\Auth\Handler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Handle a room create request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        Log::debug("=== RoomAPI start ===", ['Request' => $request, 'file' => __FILE__, 'line' => __LINE__]);

        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'username' => 'required|alpha_num|max:255',
                'start_time' => 'required|date_format:Y-m-d H:i',
                'end_time' => 'required|date_format:Y-m-d H:i',
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
            
            // ルームの作成
            $room = $this->create_room($request->all());
            Log::debug("room", ['Room' => $room, 'line' => __LINE__]);

            // 生成できない場合エラー
            if (!$room) {
                Log::error("get room error", ['room_id' => $request->room_id, 'line' => __LINE__]);
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                        ], 400);
            }

            $room_id = $room->room_id;
            $room_name = $room->room_name;
            Log::debug("room_id", ['Room_id' => $room_id, 'line' => __LINE__]);
            Log::debug("createroom OK", ['line' => __LINE__]);
            return response()->json(['result' => 0, 'room_id' => $room_id]);
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
        
        Log::debug("RoomAPI end", ['line' => __LINE__]);
        // jsonを返却
        return response($data);
    }


    public function update(Request $request)
    {
        Log::debug("=== RoomAPI start ===", ['Request' => $request, 'file' => __FILE__, 'line' => __LINE__]);

        try {
            $validator = Validator::make($request->all(), [
                'room_id' => 'required|exists:rooms',
                'start_time' => 'required|date_format:Y-m-d H:i',
                'end_time' => 'required|date_format:Y-m-d H:i',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => $errors,
                ]);
            }
            
            // ルームの作成
            $room = Room::where('room_id', $request->room_id)->whereNull('deleted_at')->first();

            Log::debug("room", ['Room' => $room, 'line' => __LINE__]);
    
            // 生成できない場合エラー
            if (!$room) {
                Log::error("get room error", ['room_id' => $room->room_id, 'line' => __LINE__]);
                return response()->json([
                        'result' => '-1',
                        'error_code' => '400',
                        'error_message' => 'Bad Request',
                            ], 400);
            }
            $room->start_time = $request->start_time;
            $room->end_time = $request->end_time;
            $room->save();
            Log::debug("room_id", ['Room_id' => $room->room_id, 'line' => __LINE__]);
            Log::debug("changeroom OK", ['line' => __LINE__]);
            return response()->json(['result' => 0,
                'room_id' => $room->room_id,
                'start_time' => $room->start_time,
                'end_time' => $room->end_time
            ]);
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
        
        Log::debug("RoomAPI end", ['line' => __LINE__]);
        // jsonを返却
        return response($data);
    }


    public function destroy(Request $request)
    {
        Log::debug("=== RoomAPI start ===", ['Request' => $request, 'file' => __FILE__, 'line' => __LINE__]);

        try {
            $validator = Validator::make($request->all(), [
                'room_id' => 'required|exists:rooms'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => $errors,
                ]);
            }
            
            // ルームの作成
            $room = Room::where('room_id', $request->room_id)->first();

            Log::debug("room", ['Room' => $room, 'line' => __LINE__]);
    
            // 生成できない場合エラー
            if (!$room) {
                Log::error("get room error", ['room_id' => $room->room_id, 'line' => __LINE__]);
                return response()->json([
                        'result' => '-1',
                        'error_code' => '400',
                        'error_message' => 'Bad Request',
                            ], 400);
            }
            $room->deleted_at = date('Y-m-d H:i:s');
            $room->save();
            Log::debug("room_id", ['Room_id' => $room->room_id, 'line' => __LINE__]);
            Log::debug("deleteroom OK", ['line' => __LINE__]);
            return response()->json([
                'result' => '0'
            ]);
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
        
        Log::debug("RoomAPI end", ['line' => __LINE__]);
        // jsonを返却
        return response($data);
    }

    /**
     * Create a new room instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Room
     */
    protected function create_room(array $data)
    {
        $room = Room::create([
            'room_id' => hash('sha256', $plainTextToken = \Illuminate\Support\Str::random(20)),
            'user_name' => $data['username'],
        ]);
        $room_id_text = 'room' . $room->id . \Illuminate\Support\Str::random(20);
        $room->room_id = hash('sha256', $room_id_text);
        $room->start_time = $data['start_time'];
        $room->end_time = $data['end_time'];
        $room->save();

        return $room;
    }

    public function info(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'room_id' => 'required'
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

            $data = Room::where('room_id',$request->room_id)->first();
            if(empty($data)){
                return response()->json([
                    'result' => '-1',
                    'error_code' => '-1',
                    'error_message' => "Get room info failed",
                    ], 200);
            } else{
                return response()->json(['result' => 0,
                    'room_id' => $data->room_id,
                    'start_time' => $data->start_time,
                    'end_time' => $data->end_time
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
