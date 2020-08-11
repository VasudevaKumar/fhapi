<?php

namespace App\Services\Helper;

trait TvpHelper
{
    public function prepareTvpString($data)
    {
        $totalItems = count($data);
        $tvpString = '';
        for ($index = 0; $index<$totalItems; $index++) {
            $tvpString .= "('" . $data[$index] . "'),";
        }

        return substr($tvpString, 0, strlen($tvpString) - 1);
    }

    public function prepareTvpStringMultipleValues($data)
    {
        $totalItems = count($data);
        $tvpString = '';
        $perRowValue = '';
        for ($index = 0; $index<$totalItems; $index++) {
            $perRowValue = ''; // reset value
            foreach($data[$index] as $key => $value ) {
                $perRowValue .="'". $value . "',";
            }
            $perRowValue = substr($perRowValue, 0, strlen($perRowValue) - 1);
            $tvpString .= '(' . $perRowValue . '),';
        }
        
        return substr($tvpString, 0, strlen($tvpString) - 1); 
    }
	
	/*
	*	Function to create tvp Insert columns and values
	*/
	public function prepareTvpColumnsAndValues($params, $data, $mandatoryColVals = array())
    {	
        $noParameters = 1;
		$return = [];
        $columnStr = '';
        $valueStr = '';
        $totalParameters = count($params);
		
        for ($index = 0; $index < $totalParameters; $index++) {	
            $paramName = $params[$index];
			
			if( (isset($paramName) && empty($data[$paramName])) && in_array($paramName, array_keys($mandatoryColVals)) )
			{	
				$data[$paramName] = $mandatoryColVals[$paramName];
			}
			
            if ( isset($data[$paramName]) || !empty($data[$paramName]) ) 
			{
				$noParameters = 0;
                $columnStr .= ", " . $paramName;
                $valueStr .= ", '" . $data[$paramName] . "'";
            }
        }

        $return = [
			'noParameters' => $noParameters,
            'columns' => substr($columnStr, 2),
            'values' => substr($valueStr, 2),
        ]; 

        return $return;
    }

}
