<?php

namespace App\Http\Controllers;
use App\Models\TeachingMaterialTitle;
use Illuminate\Http\Request;

class TeachingMaterialTitleController extends Controller
{
    private $result = 400;
    private $data = null;
    
    public function listTitles(Request $request)
    {
        try {
            $titles = TeachingMaterialTitle::orderBy('order', 'asc')->get();
            $this->data = $titles;
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
