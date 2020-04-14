<?php

namespace app\models;


class HttpService {

    public function curlDelete($url, $data = []) {
        $params = http_build_query($data);
        if ($params) {
            $url .= '?' . $params;
        }
        return $this->getHttpResponseDelete($url);
    }

    public function curlGet($url, $data = [], $token) {
        $params = http_build_query($data);
        if ($params) {
            $url .= '?' . $params;
        }
        return $this->getHttpResponseGet($url, $token);
    }

    public function curlPost($url, $data = []) {
        return $this->getHttpResponsePost($url, $data);
    }

    private function getHttpResponseDelete($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        $responseText = curl_exec($curl);
        curl_close($curl);
        return $responseText;
    }

    private function getHttpResponseGet($url, $token) {
        $headers = [
            "admin-token: $token",
        ];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        $responseText = curl_exec($curl);
        curl_close($curl);
        return $responseText;
    }

    private function getHttpResponsePost($url, $data) {
        $headers = [
            "Content-Type: application/json"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseText = curl_exec($ch);

        curl_close($ch);
        return $responseText;
    }
}