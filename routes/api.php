<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FrequentlyQuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EnrolmentCourseController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizItemController;
use App\Http\Controllers\StudentController ;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoGroupController;

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

Route::controller(FrequentlyQuestionController::class)->middleware('checkadmin')->group(function () {
    Route::post('/frequently', 'addFrequentlyquestion');
    Route::delete('/frequently/{id}', 'deleteFrequentlyquestion');
});

Route::controller(CourseController::class)->group(function () {
    Route::post('/courses/{id}', 'AddCourse')->middleware('checkadmin');
    Route::put('/courses/{id}', 'UpdatetCourse')->middleware('checkadmin');
    Route::delete('/courses/{id}', 'DeleteCourse')->middleware('checkadmin');
    Route::get('/courses/{id}', 'getCourses');
    Route::get('/enrolments/{id}', 'getCoursesOfStudent');
    Route::get('/searchcourse/{name}', 'searchCourse');
});
Route::controller(VideoGroupController::class)->group(function () {
    Route::post('/videogroup/{id}', 'addVideoGroup')->middleware('checkexpert');
    Route::delete('/videogroup/{id}', 'deleteVideoGroup')->middleware('checkexpert');
    Route::get('/videogroups/{id}', 'getVideoGroups');
});
Route::controller(VideoController::class)->group(function () {
    Route::post('/video', 'addVideo')->middleware('checkexpert');
    Route::put('/video/{id}', 'updateVideo')->middleware('checkexpert');
    Route::delete('/video/{id}', 'deleteVideo')->middleware('checkexpert');
    Route::get('/videos/{id}', 'getVideos');
});
Route::controller(QuizController::class)->group(function () {
    Route::post('/quiz/{id}', 'addQuiz')->middleware('checkexpert');
    Route::put('/quiz/{id}', 'updateQuiz')->middleware('checkexpert');
    Route::delete('/quiz/{id}', 'deleteQuiz')->middleware('checkexpert');
    Route::get('/quiz/{id}', 'getQuiz');
    Route::post('/quize/{id}', 'checkresult')->middleware('checkstudent');
});
Route::controller(QuizItemController::class)->middleware('checkexpert')->group(function () {
    Route::post('/quizitem/{id}', 'addQuizItem');
    Route::put('/quizitem/{id}', 'updateQuizItem');
    Route::delete('/quizitem/{id}', 'deleteQuizItem');
});
Route::controller(ChoiceController::class)->middleware('checkexpert')->group(function () {
    Route::post('/choice', 'addChoice');
    Route::delete('/choice/{id}', 'deleteChoice');
});
Route::controller(DiscountController::class)->middleware('checkexpert')->group(function () {
    Route::post('/discount/{id}', 'addDiscount');
    Route::delete('/discount/{id}', 'cancelDiscount');
});

Route::controller(ExpertController::class)->group(function () {
    Route::post('/profile', 'AddProfileInfo')->middleware('checkexpert');
    Route::put('/profile/{id}', 'UpdateProfile')->middleware('checkexpert');
    Route::post('/image/{id}', 'updateImage')->middleware('checkexpert');
    Route::get('/searchexpert/{name}', 'searchExpert');
    Route::get('/profiles', 'getProfilesExperts');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/explorecourse', 'getExplore')->middleware('checkstudent');
    Route::get('/category', 'getCategory');
});

Route::controller(EnrolmentCourseController::class)->group(function () {
    Route::post('/student/course/{id}', 'enrolmentCourse')->middleware('checkstudent');
});

Route::controller(StudentController::class)->group(function () {
    Route::get('/students/{id}', 'getStudentsInCourse');
    Route::get('/explorestudent', 'exploreStudentSuccesses');


});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
