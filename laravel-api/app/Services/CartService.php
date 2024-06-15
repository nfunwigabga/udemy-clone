<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartService
{
    public function __construct(private ?Cart $cart = null)
    {
        $this->current();
    }

    public function getCurrent()
    {
        return $this->cart;
    }

    public function current()
    {
        $user = Auth::user();
        if ($user) {
            $this->cart = Cart::where('user_id', $user->id)
                ->firstOrCreate([
                    'user_id' => $user->id,
                ]);
        } else {
            $token = $this->getCurrentCartToken();
            $this->cart = Cart::where('token', $token)
                ->firstOrCreate([
                    'token' => $token,
                ]);
        }
    }

    public function hasCourse(Course $course)
    {
        return $this->cart->items()
            ->where('course_id', $course->id)
            ->exists();
    }

    public function add(Course $course)
    {
        if (! $this->hasCourse($course)) {
            $this->cart->items()->create([
                'course_id' => $course->id,
                'price' => $course->price,
            ]);
        }
    }

    public function remove(Course $course)
    {
        return $this->cart->items()
            ->where(['course_id' => $course->id])
            ->delete();
    }

    public function isEmpty()
    {
        return ! $this->cart->items()->exists();
    }

    public function applyDiscountToCartItem(string $code)
    {
        // search for each item where this coupon is valid
    }

    public function clear()
    {
        $this->cart->items()->delete();
    }

    protected function getCurrentCartToken()
    {
        $token = request()->header('X-CART-TOKEN');

        if (! $token) {
            $token = (string)Str::ulid();
            request()->headers->set('X-CART-TOKEN', $token);
        }

        return $token;
    }
}
