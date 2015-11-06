<?php

namespace Voximplant\Transport;

interface Transport
{
    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';

    public function send($url, $method, $arguments = array());
}