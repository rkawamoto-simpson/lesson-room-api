<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Note;
use Illuminate\Support\Facades\Log;
use ZipArchive;
class NoteController extends Controller
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

            $note = Note::where('room_id', $request->room_id)->first();

            if (!$note) {
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                        ], 400);
            }

            return response()->json(['result' => 0, 'log' => $note]);
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
                'room_id' => 'required|exists:rooms,room_id'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'result' => '-1',
                    'error_code' => '1',
                    'error_message' => $errors,
                ]);
            }
            $flight = Note::where('room_id', $request->room_id)->first();
            if($flight){
                $is_updated = Note::where('room_id', $request->room_id)->update($params);
                if($is_updated)
                    $this->data = Note::where('room_id', $request->room_id)->first();
            }else{
                $this->data = Note::create($params);
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
                    'room_id' => $this->data->room_id
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

    public function download(Request $request)
    {
        try {
           
            $file_name = 'Eigox_Note_'. (new \DateTime())->format('YmdHis'). '.txt';;
            $headers = [
                'Content-type' => 'text/plain', 
                'Content-Disposition' => sprintf('attachment; filename="%s"', $file_name),
              ];
            if($request->is_zip){
                date_default_timezone_set("Asia/Tokyo");
                $zip_file_name = 'Eigox_Note_'. (new \DateTime())->format('YmdHis'). '.zip';
                $zip = new ZipArchive;
                if ($zip->open(public_path($zip_file_name), ZipArchive::CREATE) === TRUE) {
                    $zip->addFromString($file_name, $request->content);
                    $zip->close();
                }
                $file_path = public_path($zip_file_name);
                if (file_exists($file_path)) {
                    $headers = array('Content-Type' => 'application/octet-stream');
                    return response()->download($file_path, $zip_file_name, $headers)->deleteFileAfterSend(true);
                }
            }
            else return \Response::make($request->content, 200, $headers);
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
