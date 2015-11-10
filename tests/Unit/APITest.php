<?php
namespace VoximplantTest\Unit;

use Voximplant\API;

class APITest extends \PHPUnit_Framework_TestCase
{

    protected function _getApiInstance()
    {
        return new API(array('accountId' => $_ENV['account_id'], 'apiKey' => $_ENV['api_key']));
    }

    /**
     * Test creating new instance of  Voximplant\API
     */
    public function testConstructCorrectInstance()
    {
        $this->assertInstanceOf('Voximplant\\API', $this->_getApiInstance());
    }

    /**
     * Test creating new instance of  Voximplant\API when options don't include one of required param `apiKey` or `accountId`
     */
    public function testExceptionDuringInstance()
    {
        $this->setExpectedException('Voximplant\\Exception\\ValidationException');
        $api = new API(array('apiKey' => $_ENV['api_key']));
    }

    /**
     * Test calling Voximplant API method AddUser
     *
     * @link http://voximplant.com/docs/references/httpapi/#toc-adduser
     */
    public function testCallVoximplantApiMethod()
    {
        $uid = time();
        $params = array(
            'user_name' => 'test_user_' . $uid,
            'user_display_name' => 'Test User ' . $uid,
            'user_password' => 'test123'
        );

        $result = $this->_getApiInstance()->addUser($params);
        $this->assertEquals(1, $result->result);
    }


    /**
     * Test calling Voximplant API method AddUser with error
     *
     * @link http://voximplant.com/docs/references/httpapi/#toc-adduser
     */
    public function testCallVoximplantApiMethodWithError()
    {
        $uid = time();
        $params = array(
            'user_name' => 'test_user_' . $uid,
            'user_display_name' => 'Test User ' . $uid
        );

        $this->setExpectedException('Voximplant\\Exception\\ResponseException', 'The password must be at least 6 characters long.');
        $this->_getApiInstance()->addUser($params);
    }
}