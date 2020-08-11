<?php

namespace App\Services\Helper;

trait StateUpdateHelper
{

    public function isStateUpdate($data) 
    {
        return (
            isset($data['isStateUpdate']) &&
            ($data['isStateUpdate'])
        ) ? true : false;
    }

}
