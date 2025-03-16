<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\ListContactController;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\Api\TagController;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Login
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    ['middleware' => 'auth:sanctum']
    , function () {

        // Tags
        Route::group(['prefix' => 'tags'], function() {
            Route::get('/', [TagController::class, 'index']);
            Route::post('/', [TagController::class, 'store']);
            Route::get('/{id}', [TagController::class, 'detail']);
            Route::put('/{id}', [TagController::class, 'update']);
            Route::delete('/{id}', [TagController::class, 'delete']);
        });

        // ListContact
        Route::group(['prefix' => 'list-contacts'], function() {
            Route::get('/', [ListContactController::class, 'index']);
            Route::post('/', [ListContactController::class, 'store']);
            Route::get('/{id}', [ListContactController::class, 'detail']);
            Route::put('/{id}', [ListContactController::class, 'update']);
            Route::delete('/{id}', [ListContactController::class, 'delete']);
        });

        // Managers
        Route::group(['prefix' => 'managers'], function() {
            Route::post('/', [ManagerController::class, 'store']);
            Route::get('/{id}', [ManagerController::class, 'detail']);
            Route::post('/{id}', [ManagerController::class, 'update']);
            Route::delete('/{id}', [ManagerController::class, 'delete']);
        });

        // Contacts
        Route::group(['prefix' => 'contacts'], function() {
            Route::get('/', [ContactController::class, 'index']);
            Route::post('/', [ContactController::class, 'store']);
            Route::get('/{id}', [ContactController::class, 'detail']);
            Route::post('/updates', [ContactController::class, 'update']);
            Route::post('/deletes', [ContactController::class, 'delete']);
        });

        // Export
        Route::group(['prefix' => 'export/excel'], function() {
            Route::post('/contacts', [ExportController::class, 'exportContacts']);
        });

        // Logout
        Route::get('logout', [AuthController::class, 'logout']);
    }
);
