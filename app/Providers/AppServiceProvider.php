<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\DynamicPage;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = Setting::get();
        $categories = Category::with('subcategories')->where('status', 1)->get();
        $app_pages = DynamicPage::where('status', 1)->get(['id', 'page_name', 'slug']);
        app()->instance('app_settings', $settings);
        $website_name = $settings->where('key', 'website_name')->first()->value;
        $website_email = $settings->where('key', 'email')->first()->value;

        Config::set('mail.from.name', $website_name ?? 'ecommerce');
        Config::set('mail.from.address', $website_email != null ? $website_email : 'ecommerce@gmail.com');

        View::share(['app_categories' => $categories, 'app_pages' => $app_pages]);
    }
}
