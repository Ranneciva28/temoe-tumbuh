<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            $branding = Schema::hasTable('settings')
                ? Setting::groupValues('branding')
                : [];
        } catch (Throwable) {
            $branding = [];
        }

        View::share('branding', $branding);
    }
}
