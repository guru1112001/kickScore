<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\LeagueController;
//use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FanPhotoController;
use App\Http\Controllers\AgoraTokenController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\LiveFixtureController;
use App\Http\Controllers\QuestionBankController;

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
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\TeachingMaterialController;

Broadcast::routes(['middleware' => ['auth:sanctum']]);


Route::post('/send-notification', [\App\Http\Controllers\NotificationController::class, 'sendNotification']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/social/token', [AuthController::class, 'handleToken']);
Route::post('/verify-google-token', [AuthController::class, 'verifyGoogleToken']);
Route::post('/verify-microsoft-token',[AuthController::class,'handleMicrosoftToken']);
// Route::post('/verify-facebook-token',[AuthController::class,'facebookLogin']);
Route::post('/verify-facebook-token',[AuthController::class,'handleFacebookToken']);
Route::post('/verify-facebook-token-ios', [AuthController::class, 'handleFacebookTokenios']);

Route::middleware(['auth:sanctum'
    //, 'verified'
])->group(function () {
    Route::get('/user', function (Request $request) {
        return new \App\Http\Resources\UserResource($request->user());
    });

    Route::put('/user', [UserController::class, 'update']);
});

// Authentication Routes




Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    
    $status = Password::sendResetLink(
        $request->only('email')
    );
    
    return $status === Password::RESET_LINK_SENT
    ? response()->json(['status' => true, 'message' => __($status)])
    : response()->json(['status' => false, 'message' => __($status)]);
})->middleware('guest')
->name('password.email');


//Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
//Route::post('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
//Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');

Route::get('/getlivefixtures',[LiveFixtureController::class,'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Place protected routes here
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('/getusersbyid',[AuthController::class,'GetUsersById']);
    //api for profile update
    Route::post('/profile', [AuthController::class, 'updateProfile']);
    Route::get('get/profile', [AuthController::class, 'getProfile']);
    
    Route::post('reset/password', [PasswordResetController::class, 'changePassword']);
    //api for notifications
    Route::get('/notifications',[\App\Http\Controllers\NotificationController::class,'index']);
    
    Route::post('/notifications/mark-read/{id}',[\App\Http\Controllers\NotificationController::class, 'markAsRead']);
    
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'delete']);
    
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
    
    Route::get('/notifications/count', [\App\Http\Controllers\NotificationController::class, 'count']);
    
    //calendar
    Route::get('/calenders/list', [CalendarController::class, 'fetchData']);
    
    
    //api for fan meeting room
    Route::post('/groups', [GroupController::class, 'createGroup']);
    Route::get('/groups', [GroupController::class, 'getAllGroups']);
    Route::post('/groups/{group}/toggle-status', [GroupController::class, 'toggleGroupStatus']);
    Route::get('/groups/search', [GroupController::class, 'searchGroups']);
    Route::post('/groups/filter-by-country', [GroupController::class, 'filterGroupsByCountry']);

    Route::post('/groups/{groupId}/join', [MessageController::class, 'joinGroup']);
    Route::post('/groups/{groupId}/leave', [MessageController::class, 'leaveGroup']);
    Route::post('/groups/{groupId}/messages', [MessageController::class, 'sendMessage']);
    Route::get('/groups/{groupId}/messages', [MessageController::class, 'getOldMessages']);

    Route::post('/agora/token',[AgoraTokenController::class,'generateToken']);
    
    //Api for annoucements
    Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'index']);
    
    
    //api for leagues 
    Route::get('leagues', [LeagueController::class, 'getAllLeagues']);
    Route::get('league', [LeagueController::class, 'getLeagueById']);
    Route::get('leagues/live', [LeagueController::class, 'getLiveLeagues']);
    Route::get('leagues/fixture-date/{date}', [LeagueController::class, 'getLeaguesByFixtureDate']);
    Route::get('leagues/country/{countryId}', [LeagueController::class, 'getLeaguesByCountryId']);
    Route::get('leagues/search/{name}', [LeagueController::class, 'searchLeaguesByName']);

    //api for prediction
    Route::get('predictions',[PredictionController::class,'index']);
    
    //api for league selection 
    Route::post('/user/select-leagues', [LeagueController::class, 'selectLeagues']);
    Route::get('/get/select-leagues',[LeagueController::class,'getSelectedLeagues']);
    // Api for Post/match_disccusion
    
    Route::get('posts', [PostController::class, 'index']);
    // Route::get('posts/{id}', [PostController::class, 'show']);
    Route::post('posts/like', [PostController::class, 'like']);
    Route::post('posts/comment', [PostController::class, 'comment']);
    Route::get('posts/comments', [PostController::class, 'getComments']);
    
    //api for fan photos
    Route::post('post/fan-photos', [FanPhotoController::class, 'store']);
    Route::get('get/fan-photos', [FanPhotoController::class, 'index']);
    Route::get('/fan-photos/leaderboard', [FanPhotoController::class, 'leaderboard']);

    Route::post('/photos/{id}/react', [FanPhotoController::class, 'reactToFanPhoto']);
    Route::post('/photos/{id}/unreact', [FanPhotoController::class, 'removeReaction']);
    
    //api for polls
    
    Route::get('polls', [PollController::class, 'index']);
    Route::post('polls/vote/{pollId}', [PollController::class, 'vote']);
    
    
    //api for question bank/Quizzes
    Route::get('/question-banks', [QuestionBankController::class, 'index']);

    Route::get('/question-banks/questions/{id}', [QuestionBankController::class, 'getQuestionsForBank']);

    Route::get('/get/countries', [CountryController::class,'index']);
    //	 Route::get('/attendances', [AttendanceController::class, 'index']);
    //	  Route::get('/batches',[BatchController::class,'get_batches']);
});

// Route::get('/batches', [BatchController::class,'index']);
// Route::get('/{id}/batch', [BatchController::class,'view']);

// //Sections By Batch
// Route::get('/{id}/curriculum',[CurriculumController::class,'index']);

// //Sections By Batch
// Route::get('/{id}/sections/{curriculum_id?}',[SectionController::class,'index']);

// //Teaching Material
// Route::get('/{id}/materials/{curriculum_id?}/{section_id?}/',[TeachingMaterialController::class,'index']);

// Route::get('assignments', [TeachingMaterialController::class, 'getPendingAssignments']);

// Route::post('/submit-assignment', [TeachingMaterialController::class, 'submitAssignment']);

// Route::get('/assignment-chart', [TeachingMaterialController::class, 'getChartData']);




// Route::post('/leaves/apply', [LeaveController::class, 'applyLeave']);
// Route::get('/leaves/list',[LeaveController::class,'index']);

// Route::get('/tutors', [\App\Http\Controllers\UserController::class, 'tutors']);
// Route::get('/syllabus/list', [\App\Http\Controllers\SyllabusController::class, 'getCompletedSyllabus']);
// //Api for attendances
// Route::get('/attendances', [\App\Http\Controllers\AttendanceController::class, 'index']);

// Route::get('/attendance-report', [\App\Http\Controllers\AttendanceController::class, 'getAttendanceReport']);

// Route::get('/attendance-chart', [\App\Http\Controllers\AttendanceController::class, 'getChartData']);
//Route::get('/Syllabus',[\App\Http\Controllers\SyllabusController::class,'getUserSyllabus']);
// Route::get('states', function() {
//     return \App\Http\Resources\StateResource::collection(\App\Models\State::all());
// });
// Route::get('qualifications', function() {
//     return \App\Http\Resources\QualificationResource::collection(\App\Models\Qualification::all());
// });