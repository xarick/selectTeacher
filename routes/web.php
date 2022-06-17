<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\StudentController;

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

// Route::middleware('guest')->group(function () {
//     Route::get('/', function () {
//         return view('auth.login');
//     })->name('login');
// });

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BaseController::class, 'index'])->name('dashboard');

    Route::get('/sciense-mand', [StudentController::class, 'scienseM'])->name('student.scienseM');
    Route::get('/select-to-student-mand/{id}', [StudentController::class, 'selectToStudentM'])->name('student.selectToStudentM');
    Route::get('/selected-scienses-mand', [StudentController::class, 'selectToStudentShowM'])->name('student.selectToStudentShowM');

    Route::get('/sciense-opt', [StudentController::class, 'scienseO'])->name('student.scienseO');
    Route::get('/select-to-student-opt/{id}', [StudentController::class, 'selectToStudentO'])->name('student.selectToStudentO');
    Route::get('/selected-scienses-opt', [StudentController::class, 'selectToStudentShowO'])->name('student.selectToStudentShowO');
});

require __DIR__ . '/auth.php';
