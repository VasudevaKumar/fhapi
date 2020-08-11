<?php

namespace App\Services\Helper;

trait ParamHelper
{
	/**
     * check the missing fields provided the list of required indexes ($requiredIndexArray) 
	 * and actual data submitted to the api ($dataFields)
     *
     * @return Array ($missingFieldsArray)
     */
    public function checkRequiredFields($requiredIndexArray, $dataFields)
	{
        $missingFieldsArray = array();
		$parameterSize = count($requiredIndexArray);
		for($i=0; $i<$parameterSize; $i++) {
			if (!isset($dataFields[$requiredIndexArray[$i]])) {
                array_push($missingFieldsArray, $requiredIndexArray[$i]);
            }
		}

		return $missingFieldsArray;
	}

	/**
     * prepare the parameter to be used on the sql provided the data set ($data)
	 * and the parameter index/name ($paramName),
	 * handle null values for the parameter
     *
     * @return string
     */
	public function handleNullValues($data, $paramName)
	{
		return (
            isset($data[$paramName]) && !empty($data[$paramName]) && (strtolower($data[$paramName]) != 'null')
        ) ? "'" . $data[$paramName] . "'" : 'NULL';

	}

	/**
     * prepare the parameter to be used on the sql provided the data set ($data)
	 * and the parameter index/name ($paramName),
	 * handle null values for the parameter
     *
     * @return string
     */
	public function handleNullValuesForEndDate($data, $paramName)
	{
		return (
            isset($data[$paramName]) && !empty($data[$paramName]) && (strtolower($data[$paramName]) != 'null')
        ) ? "'" . $data[$paramName] . ' 23:59:59'  . "'"  : 'NULL';

	}

}
