<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleHelper
{
    /**
     * Get content based on current locale
     */
    public static function getLocalizedContent($content, $field)
    {
        $locale = Session::get('locale', 'hu');
        $englishField = $field . '_english';

        if ($locale == 'en' && !empty($content->$englishField)) {
            return $content->$englishField;
        }

        return $content->$field;
    }

    /**
     * Get the current locale
     */
    public static function getCurrentLocale()
    {
        return Session::get('locale', 'hu');
    }

    /**
     * Check if current locale is the specified one
     */
    public static function isLocale($locale)
    {
        return Session::get('locale', 'hu') === $locale;
    }
}
