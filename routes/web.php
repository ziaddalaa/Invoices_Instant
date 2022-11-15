<?php

use App\Http\Controllers\CustomerReportsController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceAttachementsController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoiceReportsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoicesController::class);

Route::resource('sections', SectionsController::class);

Route::resource('products', ProductsController::class);

Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);

Route::get('/InvoiceDetails/{id}', [InvoiceDetailsController::class, 'index']);

Route::get('/view_file/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'view_attachement']);

Route::get('/download_file/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'download_attachement']);

Route::post('delete_file', [InvoiceDetailsController::class, 'destroy'])->name('delete_file');

Route::post('invoiceAttachements', [InvoiceAttachementsController::class, 'store']);

Route::get('edit_invoice/{id}', [InvoicesController::class, 'edit']);

Route::get('status_show/{id}', [InvoicesController::class, 'show']);

Route::post('/status_update/{id}', [InvoicesController::class, 'status_update']);

Route::get('paid_invoices', [InvoicesController::class, 'paid_invoices']);
Route::get('unpaid_invoices', [InvoicesController::class, 'unpaid_invoices']);
Route::get('partial_invoices', [InvoicesController::class, 'partial_invoices']);

Route::resource('archive', InvoiceArchiveController::class);

Route::get('print_invoice/{id}', [InvoicesController::class, 'print_invoice']);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('invoice_reports', [InvoiceReportsController::class , 'index']);

Route::post('search_invoices', [InvoiceReportsController::class , 'search_invoices']);

Route::get('customer_reports', [CustomerReportsController::class , 'index']);
Route::post('search_customers', [CustomerReportsController::class , 'search_customers']);


Route::get('/{page}', 'App\Http\Controllers\AdminController@index');
