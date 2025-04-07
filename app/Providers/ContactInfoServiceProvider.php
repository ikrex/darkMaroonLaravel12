<?php

namespace App\Providers;

use App\Models\ContactInfo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class ContactInfoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $contactInfo = Cache::remember('contact_info', 3600, function () {
                return ContactInfo::first();
            });

            $view->with('contactInfo', $contactInfo);
        });
    }
}
