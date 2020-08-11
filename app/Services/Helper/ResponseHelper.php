<?php

namespace App\Services\Helper;

use Illuminate\Http\Response;

trait ResponseHelper
{

    protected $response = [
        'status' => true,
        'status_code' => '',
        'data' => [],
        'message' => '',
    ];

    public function setResponseToDefault()
    {
        $this->response = [
            'status' => true,
            'status_code' => '',
            'data' => [],
            'message' => '',
        ];
    }

    public function setResponseData(Array $response_data)
    {
        if (count($response_data) > 0) {
            foreach ($response_data as $key => $value) {
                $this->response['data'][$key] = $value;
            }

            $this->setStatus(true);
            $this->setStatusCode('');
            $this->setResponseMessage('');
        }
    }

    public function setStatus($is_valid)
    {
        $this->response['status'] = $is_valid;
    }

    public function setStatusCode($status_code)
    {
        $this->response['status_code'] = $status_code;
    }

    public function setResponseMessage($response_message)
    {
        $this->response['message'] = $response_message;
    }

    public function getResponse($type = 'JSON')
    {
        $type = strtoupper($type);

        switch($type)
        {
            case 'ARRAY':
                return $this->response;
                break;
            case 'JSON':
                return response()
                    ->json($this->response);
                break;
        }

        return response()
            ->json($this->response);
    }

    public function setResponseItem($item_name, $item_value)
    {
        $this->response[$item_name] = $item_value;
    }

}
