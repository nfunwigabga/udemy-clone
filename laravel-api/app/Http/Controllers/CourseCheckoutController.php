<?php

namespace App\Http\Controllers;

use App\Actions\Course\EnrollUserToCourseAction;
use App\Actions\Payment\StorePaymentAction;
use App\Models\Course;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseCheckoutController extends Controller
{
    public function __construct()
    {
        $this->stripe = new StripeService();
    }

    public function show(Course $course)
    {
        $intent = $this->stripe->createPaymentIntent($course->price * 100);

        return response()->json([
            'course' => [
                'id' => $course->hashid,
                'title' => $course->title,
                'first_lecture' => $course->firstLecture?->hashid,
                'author' => [
                    'id' => $course->author->hashid,
                    'name' => $course->author->name,
                    'username' => $course->author->username,
                ],
                'price' => $course->price,
                'price_formatted' => $course->price_formatted,
            ],
            'intent' => $intent,
        ]);
    }

    public function store(Request $request, Course $course)
    {
        // store payment information
        StorePaymentAction::run(Auth::user(), $course, $request->payment_id);
        // enroll user to course
        EnrollUserToCourseAction::run(Auth::user(), $course);

        return response()->json(null, 201);
    }
}
