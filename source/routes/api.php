<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RoomController;
use App\Http\Controllers\Api\Auth\MeetingController;
use App\Http\Controllers\Api\Auth\TestCallbackController;
use App\Http\Controllers\Api\Auth\UserDeleteController;
use App\Http\Controllers\Api\Auth\ChangePasswordController;
use App\Http\Controllers\Api\Auth\AdminRegisterController;
use App\Http\Controllers\Api\Auth\logcollectionController;
use App\Http\Controllers\Api\Auth\TestController;
use App\Http\Controllers\Api\Auth\TestAdminController;
use App\Http\Controllers\Api\Auth\AdminRegisterController2;
use App\Http\Controllers\Api\Auth\RecordVideoController;
use App\Http\Controllers\Api\Auth\StreamTargetsController;
use App\Http\Controllers\TeachingMaterialController;
use App\Http\Controllers\TeachingMaterialTitleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RoomConfigController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */






Route::group(['middleware' => ['auth:sanctum']], function () {

   // Route::post('/createroom', [RoomController::class, 'create']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/recordvideo', [RecordVideoController::class, 'list']);

    //管理者アカウント作成API
    Route::post('/AdminRegister', [AdminRegisterController::class, 'AdminRegister']);
    Route::post('/AdminRegister2', [AdminRegisterController2::class, 'AdminRegister2']);
    //PW変更
    Route::post('/ChangePassword', [ChangePasswordController::class, 'ChangePassword']);
    Route::post('/logcollection', [logcollectionController::class, 'logcollection']);
    Route::post('/startmeeting', [MeetingController::class, 'start']);
});

Route::get('/', function() {
    return "API";
});

Route::post('/room', [RoomController::class, 'create']);
Route::post('/room_change', [RoomController::class, 'update']);
Route::post('/room_delete', [RoomController::class, 'destroy']);
Route::post('/room_info', [RoomController::class, 'info']);

Route::get('/material/category', [TeachingMaterialController::class, 'category']);
Route::get('/material/textbook', [TeachingMaterialController::class, 'textbook']);
Route::get('/material/textbook/file', [TeachingMaterialController::class, 'file']);
Route::get('/material/textbook/zip-file', [TeachingMaterialController::class, 'filezip']);
Route::post('/whiteboard', [TeachingMaterialController::class, 'upload_whiteboard']);
Route::get('/whiteboard', [TeachingMaterialController::class, 'download_whiteboard']);



//Route::post('/startmeeting', [MeetingController::class, 'start']);
Route::post('/endmeeting', [MeetingController::class, 'end']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
//Userの論理削除
// Route::post('/delete', [UserDeleteController::class, 'delete']);
// //パスワードリセットの論理削除
// Route::post('/password_delete', [UserDeleteController::class, 'password_delete']);
// //session_logsの論理削除
// Route::post('/log_delete', [UserDeleteController::class, 'log_delete']);
// //roomの論理削除
// Route::post('/room_delete', [UserDeleteController::class, 'room_delete']);
// //OnlineMeetingInfoの論理削除
// Route::post('/MeetingInfo_delete', [UserDeleteController::class, 'MeetingInfo_delete']);

Route::post('/callbacktest', [TestCallbackController::class, 'callback']);

Route::post('/add_role', [TestAdminController::class, 'add_role']);

Route::post('/streamtargets', [StreamTargetsController::class, 'streamtargets']);
Route::post('/stream', [StreamTargetsController::class, 'stream']);

Route::group(['prefix' => 'user'], function () {
    Route::post('login', [UserController::class, 'login']);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user/check-auth', [UserController::class, 'checkAuth']);
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::group(['prefix' => 'teaching-material'], function () {
        Route::post('list', [TeachingMaterialController::class, 'index']);
        Route::get('last-index', [TeachingMaterialController::class, 'getLastIndex']);
        Route::post('add', [TeachingMaterialController::class, 'store']);
        Route::get('{id}/detail', [TeachingMaterialController::class, 'info']);
        Route::post('{id}/update', [TeachingMaterialController::class, 'update']);
        Route::post('{id}/delete', [TeachingMaterialController::class, 'remove']);
    });

    Route::group(['prefix' => 'room-setting'], function () {
        Route::get('info', [RoomConfigController::class, 'info']);
        Route::post('upsert', [RoomConfigController::class, 'upsert']);
    });
});

Route::post('/log_register', [LogController::class, 'upSert']);
Route::post('/log', [LogController::class, 'index']);

Route::group(['prefix' => '/end-user/teaching-material'], function () {
    Route::post('list', [TeachingMaterialController::class, 'list']);
});
Route::get('teaching-material/{id}/download', [TeachingMaterialController::class, 'download']);

Route::group(['prefix' => 'thumbnail'], function () {
    Route::post('/', [TeachingMaterialController::class, 'infoThumbnail']);
    Route::get('list', [TeachingMaterialController::class, 'listThumbnail']);
});

Route::get('/room_config_info', [RoomConfigController::class, 'infoForEndUser']);

Route::post('/chatregister', [ChatController::class, 'add']);
Route::post('/chatrecovery', [ChatController::class, 'index']);
Route::post('/chatrecovery/v1', [ChatController::class, 'index1']);
Route::delete('/chathistory/{id}', [ChatController::class, 'delete']);
Route::get('/chat-get-file/{id}', [ChatController::class, 'getFile']);
Route::get('/chatdownload/{room_id}/{file_name?}', [ChatController::class, 'download']);
Route::get('/download_message/{id}', [ChatController::class, 'downloadMessage']);
Route::post('/note_register', [NoteController::class, 'upSert']);
Route::get('/note_get', [NoteController::class, 'index']);
Route::get('/download_note', [NoteController::class, 'download']);

Route::group(['prefix' => '/teaching-material-titles'], function () {
    Route::get('list', [TeachingMaterialTitleController::class, 'listTitles']);
});