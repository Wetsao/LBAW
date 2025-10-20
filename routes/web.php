<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\TaskAssignedController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectPageController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectCoordinatorController;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::redirect('/', '/login');

Route::controller(HomepageController::class)->group(function () {
    Route::get('/homepage', 'index')->middleware('auth')->name('homepage');
    Route::get('delete/{id}', 'remove')->middleware('auth');
    Route::get('/add','add')->middleware('auth');
    Route::post('insertProject','insertProject')->middleware('auth');
    Route::get('deleteAccount/{id}', 'removeAccount')->middleware('auth');
});

Route::controller(ProjectMemberController::class)->group(function () {
    Route::get('/addProjectMember/{projectId}', 'showAddProjectMember')->middleware('auth')->name('addProjectMember');
    Route::post('insert','insert')->middleware('auth');
    Route::delete('removeUser','removeUser')->name('removeUser')->middleware('auth');
    Route::patch('updateFavorite/{project}', 'updateFavorite')->name('updateFavorite')->middleware('auth'); 

});

Route::controller(TaskAssignedController::class)->group(function () {
    Route::get('/addTaskMember/{taskId}', 'showAddTaskMember')->middleware('auth')->name('addTaskMember');
    Route::post('taskInsert', 'insert')->middleware('auth')->name('taskInsert');
    Route::delete('taskRemoveUser', 'removeUser')->middleware('auth')->name('removeTaskUser');
});
// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->middleware('guest')->name('login');
    Route::post('/login', 'authenticate')->middleware('guest');
    Route::get('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->middleware('guest')->name('register');
    Route::post('/register', 'register')->middleware('guest');
});

// Password
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'forgotPasswordForm')->middleware('guest')->name('password.request');
    Route::post('/forgot-password', 'sendResetLink')->middleware('guest')->name('password.email');
    Route::get('/reset-password/{token}', 'resetPasswordForm')->middleware('guest')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->middleware('guest')->name('password.update');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/profile', 'showProfile')->middleware('auth')->name('profile');
    Route::get('/edit-profile', 'showEditUserPage')->middleware('auth')->name('edit-profile.show');
    Route::post('/edit-profile', 'userpageUpdate')->middleware('auth')->name('edit-profile.update');
    Route::get('deleteAccount/{id}', 'removeAccount')->middleware('auth');

});

Route::controller(TaskController::class)->group(function () {
    Route::get('/project-page/{projectId}/task/{taskId}', 'showTask')->middleware('auth')->name('task');
    Route::post('/project-page/{projectId}/task/{taskId}/update', 'update')->middleware('auth')->name('update.task');
    Route::get('/project-page/{projectId}/addTask', 'showCreate')->middleware('auth')->name('addTask');
    Route::post('/project-page/{projectId}/addTask', 'create')->middleware('auth')->name('addTaskupdate');

});

// Project routes
Route::get('/project-page/{projectId}', [ProjectPageController::class, 'showProject'])->middleware('auth')->name('project-page');
Route::get('leave/{projectId}', [ProjectPageController::class,'leave'])->middleware('auth');
Route::get('/addCoordinator/{projectId}', [ProjectCoordinatorController::class,'showProjectCoordinator'])->middleware('auth');
Route::post('insertCoordinator',[ProjectCoordinatorController::class,'insertCoordinator'])->middleware('auth');
Route::delete('removeCoordinator',[ProjectCoordinatorController::class, 'removeCoordinator'])->name('removeCoordinator')->middleware('auth');


Route::get('/action', [HomepageController::class, 'action'])->middleware('auth')->name('action');

Route::get('/about-us', function () {
    return view('pages.about-us');
});

Route::get('/faq', function () {
    return view('pages.faq');
});

Route::get('/contact-us', function () {
    return view('pages.contact-us');
});


// Task routes
