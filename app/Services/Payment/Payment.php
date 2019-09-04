<?php

namespace App\Services\Payment;

use App\Services\AbstractApi;

class Payment extends AbstractApi {

    # get midtrans key encode
    private function get_key(){
        return base64_encode(config('midtrans.server_key') . ':');
    }

    /**
     * Make payment request
     *
     * @param $data
     * @return mixed|null
     */
    public function request($data = array())
    {
        $auth = $this->get_key();

        $response = $this->adapter->post(
            sprintf('%s/%s', $this->endpoint, 'snap/v1/transactions'),
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

    /**
     * Get payment status
     *
     * @param $data
     * @return mixed|null
     */
    public function status($transactaction_id)
    {
        $auth = $this->get_key();

        $response = $this->adapter->get(
            sprintf('%s/%s', $this->endpoint, "v2/$transactaction_id/status"),
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic $auth"
                ]
            ]
        );

        if (! ($response->getStatusCode() == '500' || 
                $response->getStatusCode() == '501' || 
                $response->getStatusCode() == '502' ||
                $response->getStatusCode() == '503' ||
                $response->getStatusCode() == '504' ||
                $response->getStatusCode() == '505') 
            ) {
            $response = json_decode($response->getBody()->getContents());

            return $response;
        }

        return null;
    }

    /**
     * Cancel Payment
     *
     * @param $data
     * @return mixed|null
     */
    public function cancel($transactaction_id)
    {
        $auth = $this->get_key();

        $response = $this->adapter->post(
            sprintf('%s/%s', $this->endpoint, "v2/$transactaction_id/cancel"),
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic $auth"
                ]
            ]
        );

        if ($response->getStatusCode() == '201') {
            $response = json_decode($response->getBody()->getContents());

            return $response;
        }

        return null;
    }
}