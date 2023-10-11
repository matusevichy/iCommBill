<?php

use App\Http\Controllers\AbonentController;
use App\Http\Controllers\AccrualController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\CounterValueController;
use App\Http\Controllers\Dictionary\BudgetItemTypeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NoticeForOwnerController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationExpenceController;
use App\Http\Controllers\OrganizationIncomeController;
use App\Http\Controllers\OrganizationSaldoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PersonalAreaController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\TarifController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/abonents/{organization}/create', [AbonentController::class, 'create'])->name('abonents.create');
Route::resource('abonents', AbonentController::class)->except('create');

Route::get('/tarifs/{organization}/create', [TarifController::class, 'create'])->name('tarifs.create');
Route::resource('tarifs', TarifController::class)->except('create');

Route::get('/notices/{organization}/create', [NoticeController::class, 'create'])->name('notices.create');
Route::resource('notices', NoticeController::class)->except('create');

Route::get('/organizationexpences/{organization}/create', [OrganizationExpenceController::class, 'create'])->name('organizationexpences.create');
Route::resource('organizationexpences', OrganizationExpenceController::class)->except('create');

Route::get('/organizationincomes/{organization}/create', [OrganizationIncomeController::class, 'create'])->name('organizationincomes.create');
Route::resource('organizationincomes', OrganizationIncomeController::class)->except('create');

Route::get('/organizationsaldos/{organization}/create', [OrganizationSaldoController::class, 'create'])->name('organizationsaldos.create');
Route::resource('organizationsaldos', OrganizationSaldoController::class)->except('create');

Route::get('/noticeforowners/{organization}/create', [NoticeForOwnerController::class, 'create'])->name('noticeforowners.create');
Route::resource('noticeforowners', NoticeForOwnerController::class)->except('create');

Route::get('/saldos/{abonent}/create', [SaldoController::class, 'create'])->name('saldos.create');
Route::resource('saldos', SaldoController::class)->except('create');

Route::get('/accruals/{abonent}/create', [AccrualController::class, 'create'])->name('accruals.create');
Route::get('/accruals/{organization}/createByOrg', [AccrualController::class, 'createByOrg'])->name('accruals.createByOrg');
Route::post('/accrualsByOrg', [AccrualController::class, 'storeByOrg'])->name('accruals.storeByOrg');
Route::resource('accruals', AccrualController::class)->except('create');

Route::get('/payments/{abonent}/create', [PaymentController::class, 'create'])->name('payments.create');
Route::resource('payments', PaymentController::class)->except('create');

Route::get('/counters/{abonent}/create', [CounterController::class, 'create'])->name('counters.create');
Route::resource('counters', CounterController::class)->except('create');

Route::get('/countervalues/{counter}/create', [CounterValueController::class, 'create'])->name('countervalues.create');
Route::resource('countervalues', CounterValueController::class)->except('create');

Route::get('/personalarea', [PersonalAreaController::class, 'index'])->name('personalarea.index');
Route::resources([
    'organizations' => OrganizationController::class,
    'users' => UserController::class,
    'budgetitemtypes' => BudgetItemTypeController::class,
]);

Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']);
