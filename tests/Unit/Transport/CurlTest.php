<?php

namespace VoximplantTest\Unit\Transport;

use Voximplant\Transport\Curl;

class CurlTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testConstructCorrectInstance()
    {
        $client = new Curl();

        $this->assertInstanceOf('Voximplant\\Transport\\Transport', $client);
    }
}