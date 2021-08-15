<?php

namespace App\Helpers;

class ValidationRules {
    /*
     * @params $arr = ['title', 'description']
     * @return $validation_rules = ['title_' . app()->getLocale() => 'required_without_all:' . $title_rule,
      'description_' . app()->getLocale() => 'required_without_all:' . $description_rule]
     */
    public static function getValidation($arr) {
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        $validation_rules = [];
        foreach ($arr as $item) {
            $item_lang = [];
            foreach ($languages as $langu) {
                if ($langu->code != app()->getLocale()) {
                    $item_lang[] = $item . '_' . $langu->code;
                }
            }
            $validation_rules[$item . '_' . app()->getLocale()] = 'required_without_all:' . implode(',', $item_lang);
        }
        return $validation_rules;
    }
}
