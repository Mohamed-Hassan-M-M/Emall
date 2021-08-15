<?php

namespace App\Helpers;

class GettingMultiLanguagesFields {

    public static function getmultilanguage($arr, $values) {
        $storedarray = [];
        $fall_back_lang = \Config::get('app.fallback_locale');
        $locale_lang = app()->getLocale();
        foreach ($arr as $item) {
            $languages = \App\Models\Language::select('code')->pluck('code')->toArray();
            $last_none_empty_value = '';
            $field_langs = [];
            $i = 0;
            while (count($languages) > $i) {
                $langu = $languages[$i];
                $i++;
                $field_langs[$langu] = $values[$item . '_' . $langu];
                /*
                 * if any translatable input is null
                 * we should auto fill it
                 * using:
                 * 1. fallback lang
                 * 2. current locale b
                 * 3. last none empty value in iteration
                 */
                if (empty($field_langs[$langu])) {
                    if (!empty($field_langs[$fall_back_lang])) {
                        $field_langs[$langu] = $field_langs[$fall_back_lang];
                    } elseif (!empty($field_langs[$locale_lang])) {
                        $field_langs[$langu] = $field_langs[$locale_lang];
                    } elseif ($last_none_empty_value != '') {
                        $field_langs[$langu] = $last_none_empty_value;
                    } else {
                        array_push($languages, $langu);
                    }
                }
                if ($field_langs[$langu]) {
                    $last_none_empty_value = $field_langs[$langu];
                }
            }
            $storedarray[$item] = $field_langs;
        }
        return $storedarray;
    }

}
