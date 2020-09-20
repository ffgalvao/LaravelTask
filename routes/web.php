<?php

use App\Alias\Routes;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes(['register' => false]);

Route::get('/', [HomeController::class, 'index'])
    ->name(Routes::DASHBOARD);

/**
 *              COMPANIES ROUTES
 */
Route::get('/companies', [CompanyController::class, 'index'])
    ->name(Routes::COMPANIES);

Route::post('/company/create', [CompanyController::class, 'store'])
    ->name(Routes::COMPANY_SAVE);

Route::get('/company/create', [CompanyController::class, 'create'])
    ->name(Routes::COMPANY_NEW);

Route::get('/company/{company:slug}', [CompanyController::class, 'show'])
    ->name(Routes::COMPANY_VIEW);

Route::put('/company/{company:slug}/edit', [CompanyController::class, 'update'])
    ->name(Routes::COMPANY_UPDATE);

Route::get('/company/{company:slug}/edit', [CompanyController::class, 'edit'])
    ->name(Routes::COMPANY_EDIT);

Route::delete('/company/{company:slug}/delete', [CompanyController::class, 'destroy'])
    ->name(Routes::COMPANY_DEL);


/**
 *              EMPLOYEES ROUTES
 */
Route::get('/employees', [EmployeeController::class, 'index'])
    ->name(Routes::EMPLOYEES);

Route::post('/employee', [EmployeeController::class, 'store'])
    ->name(Routes::EMPLOYEE_SAVE);

Route::get('/employee', [EmployeeController::class, 'create'])
    ->name(Routes::EMPLOYEE_NEW);

Route::get('/employee/{employee:code}', [EmployeeController::class, 'show'])
    ->name(Routes::EMPLOYEE_VIEW);

Route::put('/employee/{employee:code}/edit', [EmployeeController::class, 'update'])
->name(Routes::EMPLOYEE_UPDATE);

Route::get('/employee/{employee:code}/edit', [EmployeeController::class, 'edit'])
    ->name(Routes::EMPLOYEE_EDIT);

Route::delete('/employee/{employee:code}/edit', [EmployeeController::class, 'destroy'])
    ->name(Routes::EMPLOYEE_DEL);
