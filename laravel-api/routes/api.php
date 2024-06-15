<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController as CartControllerAlias;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseCheckoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\Instructor\InstructorCourseController;
use App\Http\Controllers\Instructor\InstructorCourseTargetController;
use App\Http\Controllers\Instructor\InstructorLectureContentController;
use App\Http\Controllers\Instructor\InstructorLectureController;
use App\Http\Controllers\Instructor\InstructorPricingController;
use App\Http\Controllers\Instructor\InstructorSectionController;
use App\Http\Controllers\VideoPlayerController;
use Illuminate\Support\Facades\Route;

/*----------------------------------------------------------------
- AUTHENTICATION ROUTES
----------------------------------------------------------------*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('token', [LoginController::class, 'store']);
    // Route::controller(PasswordResetController::class)->group(function () {
    //     Route::post('forgot-password', 'store');
    //     Route::post('reset-password', 'update');
    // });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [LoginController::class, 'destroy']);
        Route::get('me', [MeController::class, '__invoke']);
        Route::controller(EmailVerificationController::class)->group(function () {
            Route::post('email/verification-notification', 'sendVerificationEmail')->middleware(['throttle:6,1']);
            Route::get('verify-email/{user}/{hash}', 'verify')->name('verification.verify');
        });
    });
});



/*----------------------------------------------------------------
- INSTRUCTOR ROUTES
----------------------------------------------------------------*/
Route::scopeBindings()->group(function () {
    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'instructor'], function () {
        // Courses basic Information
        Route::controller(InstructorCourseController::class)->group(function () {
            Route::get('/courses', 'index');
            Route::post('/courses', 'store');
            Route::get('/c/{course}', 'show');
            Route::get('/c/{course}/basic', 'getBasicInfo');
            Route::put('/c/{course}/basic', 'updateBasicInfo');
            Route::put('/c/{course}/status', 'updateStatus');
            Route::post('/c/{course}/cover', 'cover');
            Route::get('/c/{course}/curriculum', 'curriculum');
        });

        // Course Targets
        Route::controller(InstructorCourseTargetController::class)->group(function () {
            Route::get('/c/{course}/targets', 'index');
            Route::post('/c/{course}/targets', 'store');
            Route::put('/c/{course}/targets','update');
            Route::delete('/c/{course}/targets/{target}', 'destroy');
        });

        // Course Sections
        Route::controller(InstructorSectionController::class)->group(function () {
            Route::post('/c/{course}/sections', 'store');
            Route::put('/c/{course}/sections/dragged', 'handleDragged');
            Route::put('/c/{course}/sections/{section}', 'update');
            Route::delete('/c/{course}/sections/{section}', 'destroy');
        });

        // Course Lectures
        Route::controller(InstructorLectureController::class)->group(function () {
            Route::post('/c/{course}/sections/{section}/lectures', 'store');
            Route::put('/c/{course}/lectures/dragged', 'handleDragged');
            Route::put('/c/{course}/lectures/{lecture}', 'update');
            Route::delete('/c/{course}/lectures/{lecture}', 'destroy');
        });

        // Lecture content
        Route::controller(InstructorLectureContentController::class)->group(function () {
            Route::put('/c/{course}/lectures/{lecture}/article', 'updateArticle');
            // remove rate limiting to enable chunk uploads
            Route::post('/files/{lecture}/chunk', 'uploadVideo')->withoutMiddleware('throttle:api');
        });

        // Course Pricing and Coupons
        Route::controller(InstructorPricingController::class)->group(function () {
            Route::get('/c/{course}/pricing-promotions', 'index');
            Route::put('/c/{course}/pricing', 'updatePrice');
            Route::post('/c/{course}/coupons', 'storeCoupon');
            Route::put('/c/{course}/coupons/{coupon}', 'updateCouponStatus');
        });
    });
});


/*----------------------------------------------------------------
- COURSES
----------------------------------------------------------------*/
// Get course categories
Route::get('categories', [CategoryController::class, '__invoke']);

// Get course(s)
Route::controller(CourseController::class)->group(function () {
    Route::get('courses', 'index');
    Route::get('/c/{course:slug}', 'show');
    Route::get('/c/{course:slug}/learn/{lecture}', 'learn')->middleware('auth:sanctum');
    Route::get('/c/{course:slug}/overview', 'overview')->middleware('auth:sanctum');
});

// Play Video
Route::controller(VideoPlayerController::class)->group(function () {
    Route::get('video/secret/{key}', 'secrets')
        ->withoutMiddleware('throttle:api')
        ->name('video.key');

    Route::get('video/{playlist?}', 'playlist')
        ->withoutMiddleware('throttle:api')
        ->name('video.playlist');
});

// Course Enrollment
Route::controller(CourseEnrollmentController::class)->group(function () {
    Route::get('c/{course:slug}/check-access', 'checkIfUserCanAccessCourse')
        ->middleware('auth:sanctum');
});



/*----------------------------------------------------------------
- COURSE PURCHASE: STRIPE
----------------------------------------------------------------*/
Route::controller(CourseCheckoutController::class)->group(function () {
    Route::get('c/{course:slug}/checkout', 'show')->middleware('auth:sanctum');
    Route::post('c/{course:slug}/checkout', 'store')->middleware('auth:sanctum');
});



/*----------------------------------------------------------------
- SHOPPING CART
----------------------------------------------------------------*/
//Route::get('/cart', function(){
//    return response()->json(app('cart')->addCourse("cou_16800622456423b72598175"));
////    return response()->json(app('cart')->isEmpty());
//});

// Route::controller(CartControllerAlias::class)->group(function () {
//     Route::get('cart', 'index');
// });


