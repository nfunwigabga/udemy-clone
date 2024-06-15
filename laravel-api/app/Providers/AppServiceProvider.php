<?php

namespace App\Providers;

use App\Macros\BlueprintMacros;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use ReflectionException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * @throws ReflectionException
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        require app_path('Support/helpers.php');

        /* We use a mixin here because we are mixing methods from another class*/
        // Blueprint::mixin(new BlueprintMacros());

        Password::defaults(
            fn () => Password::min(8)
                ->mixedCase()
                ->uncompromised()
        );
    }
}
