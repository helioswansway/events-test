<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteConfiguration extends Model
{
    //

    private static $cached_config = NULL;

    public static function from_cache(): SiteConfiguration
    {
        if (is_null(self::$cached_config)) {
            self::$cached_config = SiteConfiguration::first();
        }
        return self::$cached_config;
    }
}
