<?php

namespace App;

class Translate{

    private $months = array(
        "january" => "januari",
        "february" => "februari",
        "march" => "maart",
        "april" => "april",
        "may" => "mei",
        "june" => "juni",
        "july" => "juli",
        "august" => "augustus",
        "september" => "september",
        "october" => "oktober",
        "november" => "november",
        "december" => "december",
    );

    public function TranslateMonthToDutch($month){
        return  ucfirst($this->months[strtolower($month)]);
    }

    public function TranslateMonthToEnglish($month){
        return  ucfirst(array_search(strtolower($month), $this->months));
    }

    public function DoesMonthExists($month){
        return array_key_exists(strtolower ($month), $this->months);
    }

}
