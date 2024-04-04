<?php

use App\Http\Controllers\api\BlogAc;
use App\Http\Controllers\api\DestinationAc;
use App\Http\Controllers\api\EnquiryAc;
use App\Http\Controllers\api\GalleryAc;
use App\Http\Controllers\api\SeoAc;
use App\Http\Controllers\api\ServiceAc;
use App\Http\Controllers\api\StudentLoginAc;
use App\Http\Controllers\api\TestimonialAc;
use App\Http\Controllers\api\UniversityAc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/blog', [BlogAc::class, 'index']);
Route::get('/blog/{slug}', [BlogAc::class, 'detail']);
Route::get('/latest-blog/{no?}', [BlogAc::class, 'latestBlogs']);

Route::get('/services', [ServiceAc::class, 'index']);
Route::get('/service/{slug}', [ServiceAc::class, 'detail']);

Route::get('/gallery', [GalleryAc::class, 'index']);

Route::get('/destinations', [DestinationAc::class, 'index']);
Route::get('/destination/{slug}', [DestinationAc::class, 'detail']);
Route::get('/destination-content/{page_id}', [DestinationAc::class, 'desContent']);
Route::get('/destination-gallery/{destination_id}', [DestinationAc::class, 'gallery']);
Route::get('/destination-faqs/{page_id}', [DestinationAc::class, 'faqs']);


Route::get('/universities', [UniversityAc::class, 'index']);
Route::get('/university/{slug}', [UniversityAc::class, 'detail']);
Route::get('/university-overviews/{university_id}', [UniversityAc::class, 'overviews']);
Route::get('/university-photos/{university_id}', [UniversityAc::class, 'photos']);
Route::get('/university-videos/{university_id}', [UniversityAc::class, 'videos']);

Route::get('/universities-by-destination/{destination_id}', [UniversityAc::class, 'universityBydestination']);

Route::get('/testimonials', [TestimonialAc::class, 'index']);

Route::get('/seo/{page_name}', [SeoAc::class, 'index']);

Route::post('inquiry/submit-inquiry', [EnquiryAc::class, 'index']);

/* STUDENT ROUTES BEFORE LOGIN */

Route::post('/sign-up', [StudentLoginAc::class, 'register']);
Route::post('/login', [StudentLoginAc::class, 'signin']);
Route::post('/submit-email-otp', [StudentLoginAc::class, 'submitOtp']);
Route::post('/forget-password', [StudentLoginAc::class, 'forgetPassword']);
Route::post('/reset-password', [StudentLoginAc::class, 'resetPassword']);

/* STUDENT ROUTES AFTER LOGIN */

Route::prefix('/student')->group(function () {
  Route::get('/delete-school/{id}', [StudentFc::class, 'deleteSchool']);
  Route::prefix('profile')->group(function () {
    Route::get('', [StudentFc::class, 'profile']);
    Route::post('/update', [StudentFc::class, 'updateProfile']);
  });
  Route::get('/change-password', [StudentFc::class, 'viewChangePassword']);
  Route::post('/change-password', [StudentFc::class, 'changePassword']);
  Route::get('/applied-college', [StudentFc::class, 'appliedCollege']);
  Route::get('/shortlist', [StudentFc::class, 'shortlist']);
  Route::get('/account-settings', [StudentFc::class, 'settings']);
  Route::post('/personal-information', [StudentFc::class, 'submitPersonalInfo']);
  Route::post('/education-summary', [StudentFc::class, 'submitEduSum']);
  Route::post('/add-school', [StudentFc::class, 'addSchool']);
  Route::post('/update-school', [StudentFc::class, 'updateSchool']);
  Route::post('/update-test-score', [StudentFc::class, 'updateTestScore']);
  Route::post('/update-gre-score', [StudentFc::class, 'updateGRE']);
  Route::post('/update-gmat-score', [StudentFc::class, 'updateGMAT']);
  Route::post('/update-sat-score', [StudentFc::class, 'updateSAT']);
  Route::post('/update-background-info', [StudentFc::class, 'updateBI']);
  Route::post('/upload-documents', [StudentFc::class, 'updateDocs']);
  Route::get('/apply-program', [ApplyProgramFc::class, 'applyProgram']);
  Route::get('/shortlist-program', [ApplyProgramFc::class, 'shortlistProgram']);
  Route::get('/delete-program/{id}', [StudentFc::class, 'deleteProgram']);
});
