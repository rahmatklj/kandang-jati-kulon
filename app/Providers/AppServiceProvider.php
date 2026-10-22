<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        if ($key === null) {
            return Setting::pluck('value', 'key')->all();
        }
        $val = Setting::where('key', $key)->value('value');
        return ($val !== null && $val !== '') ? $val : $default;
    }
}

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
        View::composer('*', function ($view) {
            $defaultLogo = 'https://upload.wikimedia.org/wikipedia/commons/e/e6/Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg';

            try {
                $logoSetting = Setting::where('key', 'logo_kelurahan')->value('value');

                if (!empty($logoSetting)) {
                    $app_logo = Str::startsWith($logoSetting, ['http://', 'https://'])
                        ? $logoSetting
                        : Storage::url($logoSetting);
                } else {
                    $app_logo = $defaultLogo;
                }
            } catch (\Exception $e) {
                $app_logo = $defaultLogo;
            }

            $view->with('app_logo', $app_logo);
            $view->with('logoUrl', $app_logo);
        });
    }
}

