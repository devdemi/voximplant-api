<?php

namespace Voximplant\Transport;

class Curl implements Transport
{
    public function send($url, $method, $arguments = array())
    {
        $query = http_build_query($arguments);
        if ($method == Transport::GET) {
            $url = $url . '?' . $query;
        }
        $curl = curl_init($url);
        curl_setopt ($curl, CURLOPT_USERAGENT, 'Voximplant-API.SDK/PHP');
        if ($method == Transport::POST) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        }
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . "/cacert.pem");
        $body = curl_exec ($curl);

        $result = new \StdClass();
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result->body = $body;
        curl_close ($curl);

        return $result;
    }
}