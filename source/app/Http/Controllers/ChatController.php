<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Models\ChatHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use ZipArchive;
use SplFileInfo;

class ChatController extends Controller
{
    private $result = 400;

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
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'result' => '-1',
                    'error_code' => '1',
                    'error_message' => $errors,
                ]);
            }
            $chat_recovery = ChatHistory::list($request->all());
            foreach ($chat_recovery as $chat) {
                if (!empty($chat->file_link)) {
                    $s3 = Storage::disk('s3');
                    $client = $s3->getDriver()->getAdapter()->getClient();
                    $expiry = "+60 minutes";
                    $command = $client->getCommand('GetObject', [
                        'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                        'Key'    => $chat->file_link
                    ]);
                    $request = $client->createPresignedRequest($command, $expiry);
                    $chat->file_link = (string) $request->getUri();
                }
            }

            if (!$chat_recovery) {
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                ], 400);
            }
            return response()->json(['result' => 0, 'chat_histories' => $chat_recovery]);
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



    public function index1(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'room_id' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'result' => '-1',
                    'error_code' => '1',
                    'error_message' => $errors,
                ]);
            }
            $query = ChatHistory::withTrashed()
            ->select('id', 'room_id', 'name as username', 'start_time', 'end_time', 'message', 'created_at', 'deleted_at', 'type', 'file_link', 'file_name')
            ->orderBy('id', 'DESC')
            ->where('room_id', '=', $request->room_id);
            $count = $query->count();
            $chat_recovery = $query->offset($request->offset ?? 0)->limit($request->limit ?? 15)->get()->reverse()->values();
            foreach ($chat_recovery as $chat) {
                if (!empty($chat->file_link)) {
                    $s3 = Storage::disk('s3');
                    $client = $s3->getDriver()->getAdapter()->getClient();
                    $expiry = "+60 minutes";
                    $command = $client->getCommand('GetObject', [
                        'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                        'Key'    => $chat->file_link
                    ]);
                    $request = $client->createPresignedRequest($command, $expiry);
                    $chat->file_link = (string) $request->getUri();
                }
            }

            if (!$chat_recovery) {
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                ], 400);
            }
            return response()->json(['result' => 0, 'chat_histories' => $chat_recovery, 'count'=> $count]);
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

    public function add(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'room_id' => 'required|exists:rooms,room_id',
                'username' => 'required',
            ]);


            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'result' => '-1',
                    'error_code' => '1',
                    'error_message' => $errors,
                ]);
            }

            if ($request->hasFile('file')) {
                $file = $request->file;
                $params['type'] = $file->getMimeType();
                $params['file_name'] = $file->getClientOriginalName();
                $s3 = Storage::disk('s3');
                if ($s3) {
                    $path = $s3->put('chat_files', $file);
                    $params['file_link'] = $path;
                }
            }
            if(array_key_exists('start_time', $params)) $params['start_time'] =  date('Y-m-d H:i:s');
            if(array_key_exists('end_time', $params)) $params['end_time'] =  date('Y-m-d H:i:s');
            $params['name'] = $request->username;
            $this->data = ChatHistory::create($params);
            
            if (!empty($this->data->file_link)) {
                $s3 = Storage::disk('s3');
                $client = $s3->getDriver()->getAdapter()->getClient();
                $expiry = "+60 minutes";
                $command = $client->getCommand('GetObject', [
                    'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                    'Key'    => $this->data->file_link
                ]);
                $request = $client->createPresignedRequest($command, $expiry);
                $this->data->file_link = (string) $request->getUri();
            }

            if (empty($this->data)) {
                return response()->json([
                    'result' => '-1',
                    'error_code' => '-1',
                    'error_message' => "Update failed",
                ], 200);
            } else {
                return response()->json([
                    'result' => 0,
                    'id' => $this->data->id,
                    'room_id' => $this->data->room_id,
                    'username' => $this->data->name,
                    'start_time' => $this->data->start_time,
                    'end_time' => $this->data->end_time,
                    'message' => $this->data->message,
                    'type' => $this->data->type,
                    'file_name' => $this->data->file_name,
                    "file_link" => $this->data->file_link
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

    public function delete($id)
    {
        try {
            $chat_history = ChatHistory::find($id);  
            if(!$chat_history){
                return response()->json([
                    'result' => '-1',
                    'error_code' => '404',
                    'error_message' => 'message not found',
                        ], 404);
            }
           
            $chat_history->deleted_at = date('Y-m-d H:i:s');
            $chat_history->save();
            return response()->json([
                'result' => 200,
                'id' => $chat_history->id,
                'created_at' => $chat_history->created_at
            ]
            );
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
    }

    public function download($room_id, $save_file_name = "chat_attachment")
    {

        try {
            $chat_recovery = ChatHistory::whereNull('deleted_at')->where('room_id', '=', $room_id)->get();
            $attachment = ChatHistory::whereNotNull('file_link')->whereNull('deleted_at')->where('room_id', '=', $room_id)->get();
            if (count($chat_recovery) == 0) {
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                ], 400);
            }
            //$columns = array('Name', 'Time', 'Chat', 'File');
            $columns = array('Time', 'Name', 'Chat');
            $csv_file_name = time() . "_chat.csv";
            $chat_file = fopen($csv_file_name, 'w');
            fputs($chat_file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($chat_file, $columns);
            foreach ($chat_recovery as $chat) {
                // if (!empty($chat->message) || !empty($chat->file_name)) {
                if (!empty($chat->message) && empty($chat->start_time) && empty($chat->end_time)) {
                    //$row['Name'] = "[" . $chat->name . "]";
                    $row['Name'] = $chat->name;
                    $row['Time'] = $chat->created_at;
                    $row['Chat'] = $chat->message;
                    //$row['File'] = $chat->file_name;
                    //fputcsv($chat_file, array($row['Name'], $row['Time'], $row['Chat'], $row['File']));
                    fputcsv($chat_file, array($row['Time'], $row['Name'], $row['Chat']));
                }
            }
            fclose($chat_file);

            $public_dir = public_path();
            $file_name = time() . '_chat_attachment.zip';
            $zip = new ZipArchive;

            if ($zip->open(public_path($file_name), ZipArchive::CREATE) === TRUE) {
                if (count($attachment) > 0) {
                    foreach ($attachment as $chat) {
                        $s3 = Storage::disk('s3');
                        $zip->addFromString($chat->file_name, $s3->get($chat->file_link));
                    }
                }
                header('Content-Type', 'text/csv; charset=UTF-8');
                $temp = file_get_contents($csv_file_name);
                $zip->addFromString('chat.csv', $temp);
                unlink($csv_file_name);
                $zip->close();
            }

            $file_path = $public_dir . '/' . $file_name;
            if (file_exists($file_path)) {
                $headers = array('Content-Type' => 'application/octet-stream');
                return response()->download(public_path($file_name), $save_file_name . '.zip', $headers)->deleteFileAfterSend(true);
            }
        } catch (\Exception $e) {
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            if (file_exists($csv_file_name)) {
                unlink($csv_file_name);
            }
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
    public function downloadMessage($id, Request $request)
    {
        try {
            $chat_history = ChatHistory::find($id);
            if ($chat_history && $chat_history->file_link) {
                $file = Storage::disk('s3')->get($chat_history->file_link);
                $file_name = $chat_history->file_name;
                if($request->is_zip){
                    $zip_file_name = time() . '_chat_file.zip';
                    $zip = new ZipArchive;
                    if ($zip->open(public_path($zip_file_name), ZipArchive::CREATE) === TRUE) {
                        $zip->addFromString($file_name, $file);
                        $zip->close();
                    }
                    $file_path = public_path($zip_file_name);
                    if (file_exists($file_path)) {
                        $download_file_name = substr($file_name, 0 , (strrpos($file_name, "."))) . ".zip";
                        $headers = array('Content-Type' => 'application/octet-stream');
                        return response()->download($file_path, $download_file_name, $headers)->deleteFileAfterSend(true);
                    }
                }
                else{
                    $headers = [
                        'Content-Type' => 'application/octet-stream',
                        'Content-Description' => 'File Transfer',
                        'Content-Disposition' => "attachment; filename*=UTF-8''" . rawurlencode($file_name),
                    ];
                    return response($file, 200, $headers);
                }
            }
            $chat_history_del = ChatHistory::where('id', $id)->onlyTrashed()->get();
            if($chat_history_del->count() > 0) {
                  return  response()->json([
                    'result' => '-1',
                    'error_code' => '404',
                    'error_message' => 'This message was deleted',
                ], 404);
            }
            return response()->json([
                'result' => '-1',
                'error_code' => '404',
                'error_message' => 'message not found',
            ], 404);
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
    }


    public function getFile($id)
    {

        try {
            $chat_file = ChatHistory::find($id);
            if ($chat_file && $chat_file->file_link) {
                $file = Storage::disk('s3')->get($chat_file->file_link);
                $response = Response::make($file, 200);
                $response->header('Content-Type', $chat_file->type);
                return $response;
            }

            return response()->json([
                'result' => '-1',
                'error_code' => '404',
                'error_message' => 'File not found',
                    ], 404);
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
    }
}