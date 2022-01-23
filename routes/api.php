<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\MemberController;

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

Route::get('/get-all-plots', [PlotController::class, 'getAllPlots']);
Route::get('/get-by-plot-no', [PlotController::class, 'getByPlotNo']);
Route::get('/get-by-file-no', [PlotController::class, 'getByFileNo']);
Route::get('/get-by-member-no', [PlotController::class, 'getByMemberNo']);
Route::get('/get-by-member-name', [PlotController::class, 'getByMemberName']);
Route::post('/add-new-plot-member', [PlotController::class, 'addNewPlotMember']);
Route::post('/update-member', [MemberController::class, 'update']);
Route::post('/add-new-member', [MemberController::class, 'store']);
Route::get('/get-member-details', [MemberController::class, 'getMemberDetails']);

// Route::post('/login-instructor', [InstructorController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });