<?php

namespace App\Services\Helper;

trait FilterQueryHelper
{
    public $filterKeys = array(),
            $filters = array();

    public function getFilters($data) 
    {
        $filterRows = explode(",", $data["fq"]);
        $filterSize = count($filterRows);
        for ($filterIndex = 0; $filterIndex<$filterSize; $filterIndex++) {
            $filterData = explode(":", $filterRows[$filterIndex]);
            $key = $filterData[0];
            $value = $filterData[1];
            array_push($this->filterKeys, $key);
            $this->filters[$key] = $value;
        }
    }

}
