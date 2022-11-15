<?php

namespace App\Traits;

use App\Helpers\Helper;

trait getActiveSchoolYear
{
    public $ActiveSchoolYear;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        if(backpack_user()){
            $this->ActiveSchoolYear = Helper::getActiveSchoolYear();
        }
    }
}