<?php

namespace Voximplant\Transport;

use Voximplant\Transport\TransportException;

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

        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200) {
            throw new TransportException('Voximplant server can\'t process request');
        }
        curl_close ($curl);

        return $body;
    }
}