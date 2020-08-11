<?php

namespace App\Services\Helper;

trait ActivationUpdateHelper
{

    public function isActivationUpdate($data) 
    {
        return (
            isset($data['isActivationUpdate']) &&
            ($data['isActivationUpdate'])
        ) ? true : false;
    }

}
