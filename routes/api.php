<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Expert\ExpertController;
use App\Http\Controllers\Student\StudentController;

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


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(AdminController::class)->middleware('checkadmin')->prefix('admin/dashboard')->group(function () {
    Route::post('/courses', 'AddCourse');
    Route::put('/courses/{id}', 'UpdatetCourse');
    Route::delete('/courses/{id}', 'DeleteCourse');
    Route::post('/frequently', 'addFrequentlyquestion');
    Route::delete('/frequently/{id}', 'deleteFrequentlyquestion');
});

Route::controller(ExpertController::class)->middleware('checkexpert')->prefix('expert/')->group(function () {
    Route::post('/profile', 'AddProfileInfo');
    Route::put('/profile/{id}', 'UpdateProfile');
    Route::post('/image', 'updateImage');

    Route::post('/videogroup', 'addVideoGroup');
    Route::delete('/videogroup/{id}', 'deleteVideoGroup');

    Route::post('/video', 'addVideo');
    Route::put('/video/{id}', 'updateVideo');
    Route::delete('/video/{id}', 'deleteVideo');

    Route::post('/quiz', 'addQuiz');
    Route::put('/quiz/{id}', 'updateQuiz');
    Route::delete('/quiz/{id}', 'deleteQuiz');

    Route::post('/quizitem', 'addQuizItem');
    Route::put('/quizitem/{id}', 'updateQuizItem');
    Route::delete('/quizitem/{id}', 'deleteQuizItem');

    Route::post('/choice', 'addChoice');
    Route::delete('/choice/{id}', 'deleteChoice');


    Route::post('/discount', 'addDiscount');
    Route::delete('/discount/{id}', 'cancelDiscount');

    Route::get('/students/{id}', 'getStudentsInCourse');
    Route::get('/students/{id}', 'getStudentsInCourse');

});

Route::controller(StudentController::class)->group(function () {

    Route::get('/category', 'getCategory');
    Route::get('/courses/{id}', 'getCourses');
    Route::get('/enrolments/{id}', 'getCoursesOfStudent');
    Route::post('/student/course', 'enrolmentCourse')->middleware('checkstudent');
    Route::get('/videogroups/{id}', 'getVideoGroups');
    Route::get('/videos/{id}', 'getVideos');
    Route::get('/quiz/{id}', 'getQuiz');
    Route::post('/quize', 'checkresult');
    Route::get('/profiles', 'getProfileExperts');
    Route::get('/explorecourse', 'getExplore');
    Route::get('/searchcourse/{name}', 'searchCourse');
    Route::get('/searchexpert/{name}', 'searchExpert');
    Route::get('/explorestudent', 'exploreStudentSuccesses');


});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
