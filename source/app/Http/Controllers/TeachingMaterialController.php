<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeachingMaterialCollection;
use App\Http\Resources\ThumbnailCollection;
use App\Http\Support\ImageMagic;
use App\Models\TeachingMaterial;
use App\Models\Thumbnail;
use App\Models\TeachingMaterialTargetAge;
use App\Models\TeachingMaterialLevel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use ZipArchive;
class TeachingMaterialController extends Controller
{
    private $result = 400;
    private $data = null;

    public function index(Request $request)
    {
        try {
            $name = 'name_ja as name';
            if($request->language_name == 2)
            $name = 'name_en as name';
            $query = TeachingMaterial::with('materialLevels','materialTargetAges','thumbnail')->select('id','users','category','sub_category',
            $name,'lesson_name','created_at','updated_at');

            if(!empty($request->user))
                $query = $query->where('users', '=', $request->user);
            if(!empty($request->category))
                $query = $query->where('category', '=', $request->category);
            $query = $query->where(function ($qu) use ($request) {
                if (!empty($request->level)) {
                    $qu->whereHas('materialLevels', function ($q) use ($request) {
                        $q->whereIn('level', $request->level);
                    });
                }
                if (!empty($request->target_age)) {
                    $qu->orWhereHas('materialTargetAges', function ($q) use ($request) {
                        $q->whereIn('target_age', $request->target_age);
                    });
                }
            });
            if(!empty($request->created_at_begin)&&!empty($request->created_at_end)){
                $query = $query->whereDate('created_at', '>=', $request->created_at_begin);
                $query = $query->whereDate('created_at', '<=', $request->created_at_end);
            }
            if(!empty($request->updated_at_begin)&&!empty($request->updated_at_end)){
                $query = $query->whereDate('updated_at', '>=', $request->updated_at_begin);
                $query = $query->whereDate('updated_at', '<=', $request->updated_at_end);
            } 
            if (trim($request->keyword) !='') {
                $keyword = $request->keyword;
                if (strpos($request->keyword, '%')>-1) {
                    $keyword = str_replace('%', '\%', $keyword);
                }
                if (strpos($request->keyword, '_')>-1) {
                    $keyword = str_replace('_', '\_', $keyword);
                }
                $query = $query->where(function ($q) use ($keyword) {
                    $q->where('sub_category', 'like', '%' .$keyword. '%');
                    $q->orWhere('lesson_name', 'like', '%' .$keyword. '%');
                    $q->orWhere('name_en', 'like', '%' .$keyword. '%');
                    $q->orWhere('name_ja', 'like', '%' .$keyword. '%');
                });
            }
            if (!empty($request->orderBy)) {
                $query->orderBy($request->orderBy, $request->sort);                
            }else{
                $query->orderBy('id', 'desc'); 
            }    
                
            $this->data = $query->paginate(isset($request->per_page) ? $request->per_page : 100);
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

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $attributes = [
                'materials_id'=> '教材ID',
                'user'=> 'ユーザー',
                'category'=> 'カテゴリー',
                'sub_category' => 'サブカテゴリー',
                'target_ages' => '対象年齢',
                'lesson_name' => 'Lesson名',
                'levels' => '英語レベル',
                'name_ja' => '教材名(日本語)',
                'name_en' => '教材名(英語)',
                'file' => '教材',
            ];
            $validator = Validator::make($params, [
                'materials_id' => 'required|unique:teaching_materials,materials_id',
                'user' => 'required',
                'category' => 'required',
                'target_ages' => 'required',
                'lesson_name' => 'required|max:255',
                'levels' => 'required',
                'name_ja' => 'required|max:255',
                'name_en' => 'required|max:255',
                "file" => "required|mimes:pdf"
            ], [], $attributes);
            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                $this->error = $validator->errors()->first();
                return response()->json([
                    'result' => '0',
                    'data'=> $this->error,
                ], 400);
            }
            unset($params['file']);
            $params['teaching_materials'] = null;
            $params['page'] = 0;
            $thumbnailImage = null;
            if($request->hasFile('file')){
                $params['file_name'] = $request->file->getClientOriginalName();
                $s3 = Storage::disk('s3');
                if($s3){
                    $file = $request->file;
                    $path = $s3->put('teaching-material', $file);
                    $params['teaching_materials'] = $path;
                    $params['page'] = preg_match_all("/\/Page\W/", file_get_contents($file->getRealPath()));

                    $thumbnailImage = time().'_thumbnail'.'.png';
                    ImageMagic::parseForFirstImageFromPDF($file, Storage::disk('local')->path("public/thumbnail/".$thumbnailImage));
                    if(Storage::exists("public/thumbnail/".$thumbnailImage)){
                        $content = Storage::get("public/thumbnail/".$thumbnailImage);
                        if($s3->put('thumbnail/'.$thumbnailImage,  $content)){
                            $pathThumbnail = 'thumbnail/'.$thumbnailImage;
                            Storage::delete('public/thumbnail/'.$thumbnailImage);
                        }
                    }
               }
            }
            $params['users'] = $request->user; 
            $teaching = TeachingMaterial::create($params);
            if($teaching){
                $data = [
                    'materials_id' => $teaching->materials_id,
                    'thumbnail' => $pathThumbnail,
                    'users' => $teaching->users,
                    'category' => $teaching->category,
                    'sub_category' => $teaching->sub_category,
                    'lesson_name' => $teaching->lesson_name,
                    'name_ja' => $teaching->name_ja,
                    'name_en' => $teaching->name_en
                ];
                $a = Thumbnail::create($data);

                $material_target_ages = [];
                $target_age_arr =  explode(',', $request->target_ages);
                foreach ($target_age_arr as $target_age) {
                    $material_target_ages[] = [
                        'target_age' => $target_age,
                        'teaching_material_id' => $teaching->id
                    ];
                }
                TeachingMaterialTargetAge::insert($material_target_ages);

                $material_levels = [];
                $level_arr =  explode(',', $request->levels);
                foreach ($level_arr as $level) {
                    $material_levels[] = [
                        'level' => $level,
                        'teaching_material_id' => $teaching->id
                    ];
                }
                TeachingMaterialLevel::insert($material_levels);                
            }
            
            DB::commit();
            $this->result = 200;
            $this->data = $teaching;
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $e->getMessage());
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        } catch (Exception $e) {
            DB::rollBack();
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


    public function info($id)
    {
        try {
            $params['id'] = $id;
            $validator = Validator::make($params, [
                'id' => 'required|exists:teaching_materials,id,deleted_at,NULL',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                $this->error = $validator->errors()->first();
                return response()->json([
                    'result' => '0',
                    'data'=> $this->error,
                ], 400);
            }

            $data = TeachingMaterial::with('materialLevels','materialTargetAges')->whereId($id)->first();
            if(!empty($data->teaching_materials)){
                $s3 = Storage::disk('s3');
                $client = $s3->getDriver()->getAdapter()->getClient();
                $expiry = "+60 minutes";
                $command = $client->getCommand('GetObject', [
                    'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                    'Key'    => $data->teaching_materials
                ]);
                $request = $client->createPresignedRequest($command, $expiry);
                $data->teaching_materials = (string) $request->getUri();
            }
            $this->data = $data;
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

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $params['id'] = $id;

            $attributes = [
                'id' => 'id',
                'user'=> 'ユーザー',
                'category'=> 'カテゴリー',
                'sub_category' => 'サブカテゴリー',
                'target_ages' => '対象年齢',
                'lesson_name' => 'Lesson名',
                'levels' => '英語レベル',
                'name_ja' => '教材名(日本語)',
                'name_en' => '教材名(英語)',
                'file' => '教材',
            ];

            $validator = Validator::make($params, [
                'id' => 'required|exists:teaching_materials,id',
                'user' => 'required',
                'category' => 'required',
                'target_ages' => 'required',
                'lesson_name' => 'required|max:255',
                'levels' => 'required',
                'name_ja' => 'required|max:255',
                'name_en' => 'required|max:255',
                "file" => "nullable|mimes:pdf"
            ], [], $attributes);

            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                $this->error = $validator->errors()->first();
                return response()->json([
                    'result' => '0',
                    'data'=> $this->error,
                ], 400);
            }
            $teaching = TeachingMaterial::find($id);
            $thumbnail = Thumbnail::where('materials_id', $teaching->materials_id)->first();
            if($request->hasFile('file')){
                $s3 = Storage::disk('s3');

                if($s3){
                    $path = $s3->put('teaching-material', $request->file);
                     if(!empty($teaching->teaching_materials)){
                        if($s3->exists($teaching->teaching_materials)){
                            $s3->delete($teaching->teaching_materials);
                        }
                    }
                    $page = preg_match_all("/\/Page\W/", file_get_contents($request->file->getRealPath()));
                    $thumbnailImage = time().'_thumbnail'.'.png';
                    ImageMagic::parseForFirstImageFromPDF($request->file, Storage::disk('local')->path("public/thumbnail/".$thumbnailImage));
                    if(Storage::exists("public/thumbnail/".$thumbnailImage)){
                         $content = Storage::get("public/thumbnail/".$thumbnailImage);
                         if($s3->put('thumbnail/'.$thumbnailImage,  $content)){
                             $pathThumbnail = 'thumbnail/'.$thumbnailImage;
                             Storage::delete('public/thumbnail/'.$thumbnailImage);
                             if(!empty($thumbnail->thumbnail)){
                                if($s3->exists($thumbnail->thumbnail)){
                                    $s3->delete($thumbnail->thumbnail);
                                }
                            }
                             $thumbnail->thumbnail = $pathThumbnail;
                         }
                    }
                    $teaching->file_name = $request->file->getClientOriginalName();
                    $teaching->page = $page;
                    $teaching->teaching_materials = $path;
                }
            }
            $teaching->users = $request->user;
            $teaching->category = $request->category;
            $teaching->sub_category = $request->sub_category;
            $teaching->lesson_name = $request->lesson_name;
            $teaching->name_ja = $request->name_ja;
            $teaching->name_en = $request->name_en;
            $teaching->save();

            $thumbnail->users = $teaching->users;
            $thumbnail->category = $teaching->category;
            $thumbnail->sub_category = $teaching->sub_category;
            $thumbnail->lesson_name = $teaching->lesson_name;
            $thumbnail->name_ja = $teaching->name_ja;
            $thumbnail->name_en = $teaching->name_en;
            $thumbnail->save();

            TeachingMaterialTargetAge::where('teaching_material_id', $teaching->id)->delete();
            $material_target_ages = [];
            $target_age_arr =  explode(',', $request->target_ages);
            foreach ($target_age_arr as $target_age) {
                $material_target_ages[] = [
                    'target_age' => $target_age,
                    'teaching_material_id' => $teaching->id
                ];
            }
            TeachingMaterialTargetAge::insert($material_target_ages);

            TeachingMaterialLevel::where('teaching_material_id', $teaching->id)->delete();
            $material_levels = [];
            $level_arr =  explode(',', $request->levels);
            foreach ($level_arr as $level) {
                $material_levels[] = [
                    'level' => $level,
                    'teaching_material_id' => $teaching->id
                ];
            }
            TeachingMaterialLevel::insert($material_levels); 

            DB::commit();

            $this->result = 200;
            $this->data = $teaching;
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $e->getMessage());
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        } catch (Exception $e) {
            DB::rollBack();
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

    public function remove($id)
    {
        DB::beginTransaction();
        try {
            $params['id'] = $id;
            $attributes = [
                'id' => 'id',
            ];
            $validator = Validator::make($params, [
                'id' => 'required|exists:teaching_materials,id,deleted_at,NULL',
            ], [], $attributes);
            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                $this->error = $validator->errors()->first();
                return response()->json([
                    'result' => '0',
                    'data'=> $this->error,
                ], 400);
            }
            $teaching = TeachingMaterial::find($id);
            $thumbnail = Thumbnail::where('materials_id', $teaching->materials_id)->first();
            $s3 = Storage::disk('s3');
            if($s3){
                if(!empty($teaching->teaching_materials)){
                    if($s3->exists($teaching->teaching_materials)){
                        $s3->delete($teaching->teaching_materials);
                    }
                }
                if(!empty($thumbnail->thumbnail)){
                    if($s3->exists($thumbnail->thumbnail)){
                        $s3->delete($thumbnail->thumbnail);
                    }
                }
            }
            Thumbnail::where('materials_id', $teaching->materials_id)->delete();
            $teaching->delete();
            DB::commit();
            $this->result = 200;
            $this->data = $teaching;
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $e->getMessage());
            return response()->json([
                'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                ], 200);
        } catch (Exception $e) {
            DB::rollBack();
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

    public function getLastIndex(){
        try {
            $data = DB::table('teaching_materials')->whereNull('deleted_at')->orwhereNotNull('deleted_at')->orderBy('materials_id', 'desc')->first();
            if($data != null){
                $this->data = $data->materials_id + 1;
            }else{
                $this->data = 1;
            }
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
        return response()->json([
            'result' => '0',
            'data'=> $this->data,],
            $this->result);
    }

    public function list(Request $request)
    {
        try {
            $query = TeachingMaterial::with(['materialLevels' => function($q) { $q->orderBy('level', 'asc'); },'materialTargetAges','materialDownload'])->orderBy("order","asc");
            $query_get_total = TeachingMaterial::with('materialLevels','materialTargetAges','materialDownload');    
       
            if(!empty($request->users)){
                $query = $query->whereIn('users', $request->users);
                $query_get_total = $query_get_total->whereIn('users', $request->users);
            }
                
            if(!empty($request->category)){
                $query = $query->where('category', '=', $request->category);
                $query_get_total = $query_get_total->where('category', '=', $request->category);
            }

            if(!empty($request->name_en)){
                $query = $query->where('name_en', '=', $request->name_en);
                $query_get_total = $query_get_total->where('name_en', '=', $request->name_en);
            }

            if(!empty($request->name_ja)){
                $query = $query->where('name_ja', '=', $request->name_ja);
                $query_get_total = $query_get_total->where('name_ja', '=', $request->name_ja);
            }

            $query = $query->where(function ($qu) use ($request) {
                if (!empty($request->level)) {
                    $qu->whereHas('materialLevels', function ($q) use ($request) {
                        $q->whereIn('level', $request->level);
                    });
                }
                if (!empty($request->target_age)) {
                    $qu->orWhereHas('materialTargetAges', function ($q) use ($request) {
                        $q->whereIn('target_age', $request->target_age);
                    });
                }
            });

            $query_get_total = $query_get_total->where(function ($qu) use ($request) {
                if (!empty($request->level)) {
                    $qu->whereHas('materialLevels', function ($q) use ($request) {
                        $q->whereIn('level', $request->level);
                    });
                }
                if (!empty($request->target_age)) {
                    $qu->orWhereHas('materialTargetAges', function ($q) use ($request) {
                        $q->whereIn('target_age', $request->target_age);
                    });
                }
            });

            if (trim($request->keyword) !='') {
                $keyword = $request->keyword;
                if (strpos($request->keyword, '%')>-1) {
                    $keyword = str_replace('%', '\%', $keyword);
                }
                if (strpos($request->keyword, '_')>-1) {
                    $keyword = str_replace('_', '\_', $keyword);
                }
                $query = $query->where(function ($q) use ($keyword) {
                    $q->where('sub_category', 'like', '%' .$keyword. '%');
                    $q->orWhere('lesson_name', 'like', '%' .$keyword. '%');
                    $q->orWhere('name_en', 'like', '%' .$keyword. '%');
                    $q->orWhere('name_ja', 'like', '%' .$keyword. '%');
                });
                $query_get_total = $query_get_total->where(function ($q) use ($keyword) {
                    $q->where('sub_category', 'like', '%' .$keyword. '%');
                    $q->orWhere('lesson_name', 'like', '%' .$keyword. '%');
                    $q->orWhere('name_en', 'like', '%' .$keyword. '%');
                    $q->orWhere('name_ja', 'like', '%' .$keyword. '%');
                });
            }
            
            $data['current_page'] = (int)$request->page ? (int)$request->page : 1;
            $data['total'] = $query_get_total->get()->count();
            $data['data'] = new TeachingMaterialCollection($query->paginate(isset($request->per_page) ? $request->per_page : 100));
            $this->data = $data;
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

    public function listThumbnail(Request $request)
    {
        try {
            $query = Thumbnail::orderBy('id', 'desc');
            if (trim($request->name) !='') {
                $query = $query->where('name', 'like', "%$request->name%");
            }
            $this->data = new ThumbnailCollection($query->paginate(isset($request->per_page) ? $request->per_page : 100));
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

    public function infoThumbnail(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'materials_id' => 'required|exists:thumbnails,materials_id,deleted_at,NULL',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                Log::debug('Invalid Parameter', [$errors]);
                $this->error = $validator->errors()->first();
                return response()->json([
                    'result' => '0',
                    'data'=> $this->error,
                ], 400);
            }

            $data = TeachingMaterial::where('materials_id',$request->materials_id)->first();
            if(!empty($data->teaching_materials)){
                $s3 = Storage::disk('s3');
                if($s3->exists($data->teaching_materials)){
                    $client = $s3->getDriver()->getAdapter()->getClient();
                    $expiry = "+60 minutes";
                    $command = $client->getCommand('GetObject', [
                        'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                        'Key'    => $data->teaching_materials
                    ]);
                    $request = $client->createPresignedRequest($command, $expiry);
                    $data->teaching_materials = (string) $request->getUri();
                }else{
                    $data->teaching_materials = '';
                }             
            }
            //$this->data = $data;
            if(empty($data)){
                return response()->json([
                    'result' => '-1',
                    'error_code' => '-1',
                    'error_message' => "Get Thumbnail info failed",
                    ], 200);
            } else{
                return response()->json(['result' => 0,
                    'materials_id' => $data->materials_id,
                    'teaching_materials' =>  $data->teaching_materials
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
        return response()->json(
            [
            'result' => '0',
            'data'=> $this->data,
        ],
            $this->result
        );
        
    }

    public function download($id)
    {
        try {
            $data = TeachingMaterial::with('materialDownload')->find($id);
            if ($data && $data->teaching_materials && str_contains($data->teaching_materials, '.pdf') && $data['materialDownload'] && !!$data['materialDownload']->downloadable) {
                $file = Storage::disk('s3')->get($data->teaching_materials);
                if($data->file_name) {
                    $file_name = $data->file_name;
                } else {
                    $file_name = str_replace('teaching-material/','', $data->teaching_materials);
                }
                header('Content-Disposition:attachment;filename="' . $file_name . '"');
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Description' => 'File Transfer',
                    'filename' => $file_name
                ];
                return response($file, 200, $headers);
            }
            return response()->json([
                'result' => '-1',
                'error_code' => '404',
                'error_message' => 'teaching material not found',
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
    
    public function category(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'roomid' => 'required',
                'usertype' => 'required',
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
            $password = Config::get('material.password');
            $salt = Config::get('material.salt');
            $keyiv = openssl_pbkdf2($password, $salt, 32+16, 1000);
            $key = substr($keyiv, 0, 32);
            $iv = substr($keyiv, 32, 16);
            date_default_timezone_set("Asia/Tokyo");
            $plain_text="timestamp=" . date("YmdHis") . ":roomid=" . $request->roomid . ":usertype=" . $request-> usertype;
            $encrypted_text = openssl_encrypt($plain_text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            $encodeBase64 = base64_encode($encrypted_text);
            $urlEncode = urlencode($encodeBase64);
            $url = Config::get('material.url')."/category/list?param=". $urlEncode;
            $response = Http::get($url);
            return $response;
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
 
   
    public function textbook(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'categoryid' => 'required',
                'roomid' => 'required',
                'usertype' => 'required',
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
            $password = Config::get('material.password');
            $salt = Config::get('material.salt');
            $keyiv = openssl_pbkdf2($password, $salt, 32+16, 1000);
            $key = substr($keyiv, 0, 32);
            $iv = substr($keyiv, 32, 16);
            date_default_timezone_set("Asia/Tokyo");
            $plain_text="timestamp=" . date("YmdHis") . ":roomid=" . $request->roomid . ":usertype=" . $request-> usertype . ":categoryid=" . $request->categoryid;
            $encrypted_text = openssl_encrypt($plain_text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            $encodeBase64 = base64_encode($encrypted_text);
            $urlEncode = urlencode($encodeBase64);
            $url = Config::get('material.url')."/text/list?param=". $urlEncode;
            $response = Http::get($url);
            return $response;
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

    public function file(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'file_type' => 'required',
                'param' => 'required'
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
            $path = Config::get('material.url')."/text/file?param=". urlencode($request->param);
            if($request->file_type == "html"){
                $data= file_get_contents($path);
                return response()->json(['result' => 0, 'data' => $data]);
            }
            else if($request->file_type == "pdf"){
                $password = Config::get('material.password');
                $salt = Config::get('material.salt');
                $keyiv = openssl_pbkdf2($password, $salt, 32+16, 1000);
                $key = substr($keyiv, 0, 32);
                $iv = substr($keyiv, 32, 16);
                $decodeBase64 = base64_decode($request->param);
                $decrypted_text = openssl_decrypt($decodeBase64, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
                $array = explode(":filename=", $decrypted_text); 
                $filename = end($array);
                $pdfFile = tempnam(sys_get_temp_dir(), $filename ?? $request->file_name . '.pdf');
                copy($path, $pdfFile);
                return response()->download($pdfFile, $filename ?? $request->file_name . '.pdf')->deleteFileAfterSend(true);
            }
            
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

    public function filezip(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'param' => 'required'
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
            $path = Config::get('material.url')."/text/file?param=". urlencode($request->param);
            if($request->file_type == "html"){
                $data= file_get_contents($path);
                return response()->json(['result' => 0, 'data' => $data]);
            }
            //Get file name
            $password = Config::get('material.password');
            $salt = Config::get('material.salt');
            $keyiv = openssl_pbkdf2($password, $salt, 32+16, 1000);
            $key = substr($keyiv, 0, 32);
            $iv = substr($keyiv, 32, 16);
            $decodeBase64 = base64_decode($request->param);
            $decrypted_text = openssl_decrypt($decodeBase64, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            $array = explode(":filename=", $decrypted_text); 
            $filename = end($array);
            $zip = new ZipArchive;
            $zip_file_name = time() . '_textbook.zip';
            if ($zip->open(public_path($zip_file_name), ZipArchive::CREATE) === TRUE) {
                $zip->addFromString($filename, file_get_contents($path));
                $zip->close();
            }
            if (file_exists(public_path($zip_file_name))) {
                $headers = array('Content-Type' => 'application/octet-stream');
                return response()->download(public_path($zip_file_name),  str_replace(".pdf", "", $filename) .'.zip', $headers)->deleteFileAfterSend(true);
            }
            
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

    public function upload_whiteboard(Request $request)
    {
        try {
            echo $request->file_name;
            $params = $request->all();
            $validator = Validator::make($params, [
                'file_name' => 'required',
                'file' => 'required'
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
            $file_path = public_path($request->file_name);
            $request->file->move(public_path(), $request->file_name);            
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

    public function download_whiteboard(Request $request)
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'file_name' => 'required',
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
            $file_path = public_path($request->file_name);
            if (file_exists($file_path)) {
                if($request->is_zip){
                    $zip_file_name = 'whiteboard_'. (new \DateTime())->format('YmdHis'). '.zip';
                    $zip = new ZipArchive;
                    if ($zip->open(public_path($zip_file_name), ZipArchive::CREATE) === TRUE) {
                        $file = file_get_contents($file_path);
                        $zip->addFromString('whiteboard_'. (new \DateTime())->format('YmdHis'). '.png', $file);
                        unlink($file_path);
                        $zip->close();
                    }
                    $download_file_path = public_path($zip_file_name);
                    if (file_exists($download_file_path)) {
                        $headers = array('Content-Type' => 'application/octet-stream');
                        return response()->download($download_file_path, $zip_file_name, $headers)->deleteFileAfterSend(true);
                    }
                }
                else if($request->is_chrome_ios){
                    return response()->download($file_path, 'whiteboard_'. (new \DateTime())->format('YmdHis'). '.png' );
                }
                return response()->download($file_path, 'whiteboard_'. (new \DateTime())->format('YmdHis'). '.png' )->deleteFileAfterSend(true);
            }
            
            
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