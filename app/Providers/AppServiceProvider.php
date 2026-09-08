<?php

namespace App\Providers;

use App\Models\MetaEventMapping;
use App\Models\Setting;
use App\Services\MetaEventCatalog;
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

        View::composer('partials.tracking', function ($view) {
            try {
                $tracking = $view->getData()['tracking'] ?? Setting::groupValues('tracking');
                $mappings = Schema::hasTable('meta_event_mappings')
                    ? MetaEventMapping::query()->where('is_active', true)->get()
                    : collect();
            } catch (Throwable) {
                $tracking = [];
                $mappings = collect();
            }

            $catalog = app(MetaEventCatalog::class);
            $view->with([
                'tracking' => $tracking,
                'metaEventMappings' => $mappings,
                'metaPageTarget' => $catalog->pageTarget(request()->route()?->getName()),
                'metaServerEventIds' => session('meta_event_ids', []),
            ]);
        });
    }
}
