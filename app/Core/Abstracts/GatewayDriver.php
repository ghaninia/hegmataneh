<?php

namespace App\Core\Abstracts;

abstract class GatewayDriver
{
    private $tracking_code, $transaction_id;

    /**
     * ارسال درخواست
     * @param string $url 
     * @param array $data
     */
    public function request(string $url, array $data)
    {

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_POSTFIELDS, 1);
        curl_setopt($request, CURLOPT_POST, 1);
        curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($request);
        curl_close($request);

        return $response;
    }

    public function setTrackingCode()
    {
        return $this->tracking_code;
    }

    public function getTrackingCode()
    {
        return $this->tracking_code;
    }

    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    public function setTransactionId()
    {
        return $this->transaction_id;
    }
}
