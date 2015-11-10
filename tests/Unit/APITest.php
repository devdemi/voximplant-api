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
        $params = array(
            'user_name' => 'test_user_1447160871'
        );

        $result = $this->_getApiInstance()->getUsers($params);
        $this->assertEquals(1, $result->count);
    }


    /**
     * Test calling Voximplant API method AddUser with error
     *
     * @link http://voximplant.com/docs/references/httpapi/#toc-adduser
     */
    public function testCallVoximplantApiMethodWithError()
    {
        $uid =  mt_rand();
        $params = array(
            'user_name' => 'test_user_' . $uid,
            'user_display_name' => 'Test User ' . $uid
        );

        $this->setExpectedException('Voximplant\\Exception\\ResponseException', 'The password must be at least 6 characters long.');
        $this->_getApiInstance()->addUser($params);
    }
}