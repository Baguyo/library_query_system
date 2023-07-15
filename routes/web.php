<?php

use App\Mail\NotifyStudentBookReturn;
use App\Mail\StudentCreation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//HOME
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Route::get('email', function(){
//     $user = User::find(2);
//     $password = 'sample';
//     return new StudentCreation($user,$password);
// });

// Route::get('/bookReturn', function(){
//     $transaction = Transaction::with('user', 'book')->find(3);
//     return new NotifyStudentBookReturn($transaction);
// });

Auth::routes();

//USER ROUTES
Route::get('/user', [\App\Http\Controllers\User\dashboardController::class, 'index'])->name('user.dashboard')->middleware(['auth', 'access:user']);
//USER BOOK
Route::get('user/books', [\App\Http\Controllers\User\BookController::class, 'index'])->name('user.books')->middleware('access:user', 'auth');
Route::post('user/books', [\App\Http\Controllers\User\BookController::class, 'create'])->name('user.books')->middleware('access:user','auth');
Route::delete('user/books', [\App\Http\Controllers\User\BookController::class, 'destroy'])->name('user.books.destroy')->middleware('access:user','auth');

Route::get('register/gy', [\App\Http\Controllers\User\ProfileController::class, 'registerGetYear'])->name('register.getYear');

//USER PROFILE
Route::get('user/profile/{user}', [App\Http\Controllers\User\ProfileController::class, 'edit'])->middleware('access:user','auth')->name('user.profile.edit');
Route::put('user/profile/{user}', [App\Http\Controllers\User\ProfileController::class, 'update'])->middleware('access:user','auth')->name('user.profile.update');

Route::get('user/account/{user}', [App\Http\Controllers\User\AccountController::class, 'edit'])->middleware('access:user','auth')->name('user.account.edit');
Route::put('user/account/{user}', [App\Http\Controllers\User\AccountController::class, 'update'])->middleware('access:user','auth')->name('user.account.update');

//ADMIN ROUTES
Route::get('/admin_dashboard', [App\Http\Controllers\Admin\dashboardController::class, 'index'])->name('admin.dashboard')->middleware(['access:admin','auth']);
Route::as('admin')->resource('admin/student', App\Http\Controllers\Admin\StudentController::class)->middleware(['access:admin','auth'])->except('destroy');

Route::as('admin')->resource('admin/books', \App\Http\Controllers\Admin\BooksController::class)->middleware(['access:admin', 'auth']);
Route::post('admin/books/release', [\App\Http\Controllers\Admin\BooksController::class, 'release'])->middleware(['access:admin', 'auth'])->name('admin.books.release');
Route::post('admin/books/return', [\App\Http\Controllers\Admin\BooksController::class, 'return'])->middleware(['access:admin', 'auth'])->name('admin.books.return');
Route::get('admin/book/view', [\App\Http\Controllers\Admin\BooksController::class, 'ajaxView'])->middleware(['access:admin', 'auth'])->name('admin.books.ajaxView');
Route::get('admin/book/viewInfo', [\App\Http\Controllers\Admin\BooksController::class, 'ajaxViewBookInfo'])->middleware(['access:admin', 'auth'])->name('admin.books.ajaxViewBookInfo');
Route::post('admin/bookImport', [\App\Http\Controllers\Admin\BooksController::class, 'import'])->middleware(['access:admin', 'auth'])->name('admin.books.import');
//ADMIN PROFILE
Route::get('admin/profile/{admin}', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->middleware('access:admin','auth')->name('admin.profile.edit');
Route::put('admin/profile/{admin}', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->middleware('access:admin','auth')->name('admin.profile.update');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ADMIN ADD ADMIN
Route::get('admin/add', [App\Http\Controllers\Admin\ProfileController::class, 'create'])->middleware('access:admin','auth')->name('admin.add.create');
Route::post('admin/add', [App\Http\Controllers\Admin\ProfileController::class, 'store'])->middleware('access:admin','auth')->name('admin.add.store');





