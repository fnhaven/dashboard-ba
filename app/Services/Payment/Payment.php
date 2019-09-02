<?php

namespace App\Services\Payment;

use App\Services\AbstractApi;

class Payment extends AbstractApi {

    /**
     * Make payment request
     *
     * @param $data
     * @return mixed|null
     */
    public function request($data = array())
    {
        $auth = base64_encode(config('midtrans.server_key') . ':');

        $response = $this->adapter->post(
            sprintf('%s', $this->endpoint),
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic $auth"
                ],
                'body' => json_encode($data)
            ]
        );

        if ($response->getStatusCode() == '201') {
            $response = json_decode($response->getBody()->getContents());

            return $response;
        }

        return null;
    }
}