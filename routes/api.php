<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\DescriptionController;

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
Route::get('/get-all-nph-holders', [PlotController::class, 'getAllNphHolders']);
Route::get('/get-by-plot-no', [PlotController::class, 'getByPlotNo']);
Route::get('/get-by-file-no', [PlotController::class, 'getByFileNo']);
Route::get('/get-by-member-no', [PlotController::class, 'getByMemberNo']);
Route::get('/get-by-member-name', [PlotController::class, 'getByMemberName']);
Route::post('/add-new-plot-member', [PlotController::class, 'addNewPlotMember']);
Route::post('/update-member', [MemberController::class, 'update']);
Route::post('/add-new-member', [MemberController::class, 'store']);
Route::get('/get-member-details', [MemberController::class, 'getMemberDetails']);
Route::get('/get-finance-details', [FinanceController::class, 'getFinanceDetails']);
Route::get('/search-member-number', [MemberController::class, 'searchMemberNumber']);
Route::get('/get-current-owner-details', [PlotController::class, 'getCurrentOwner']);
Route::get('/get-ledger-details', [FinanceController::class, 'getLedgerDetails']);
Route::post('/update-ledger-details', [FinanceController::class, 'update']);
Route::post('/add-ledger', [FinanceController::class, 'store']);
Route::get('/all-descriptions', [DescriptionController::class, 'getAllDescriptions']);
Route::get('/get-all-members', [MemberController::class, 'getAllMembers']);



// Route::post('/login-instructor', [InstructorController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });