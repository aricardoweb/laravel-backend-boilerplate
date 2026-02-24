<?php

namespace App\Helpers {
    use App\Models\Setting;
    use Illuminate\Support\Facades\Cache;

    class SettingHelper
    {
        /**
         * Get a setting value by its key.
         * Caches all settings indefinitely (until updated).
         *
         * @param string $key
         * @param mixed $default
         * @return mixed
         */
        public static function get($key, $default = null)
        {
            $settings = Cache::rememberForever('app_settings', function () {
                // Plucks all settings into a key => value array
                return Setting::pluck('value', 'key')->toArray();
            });

            return $settings[$key] ?? $default;
        }

        /**
         * Clear the cached settings.
         * Should be called whenever a setting is created, updated, or deleted.
         */
        public static function clearCache()
        {
            Cache::forget('app_settings');
        }
    }
}

namespace {
    // Global Help Function definition (so it can be used easily in blade files)
    if (!function_exists('app_setting')) {
        function app_setting($key, $default = null)
        {
            return \App\Helpers\SettingHelper::get($key, $default);
        }
    }
}
