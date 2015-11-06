<?php
namespace Voximplant;

use Voximplant\Transport\Curl;

class API {

    protected $_apiKey;
    protected $_accountId;
    protected $_options = array('transport' => 'curl');

    /**
     * @var Transport\Curl $_transport
     */
    protected $_transport;

    /**
     * Create instance of \Voximplant\API
     *
     * @param array $options
     * @throws \ValidateException
     */
    function __construct($options)
    {
        if (!isset($options['apiKey']) || !isset($options['accountId'])) {
            throw new \ValidateException('You need to provide apiKey and accountId in `options`');
        }
        $this->_apiKey = $options['apiKey'];
        $this->_accountId = $options['accountId'];

        if (isset($options['transport']) && $options['transport'] instanceof Transport) {
            $this->_transport = $options['transport'];
        }

        $this->_options = array_merge($this->_options, $options);
    }

    /**
     * Call method by name from Voximplant API
     *
     * @param string $name
     * @param array $args
     * @return \StdClass
     */
    function __call($name, $args)
    {
        $method = Transport\Transport::GET;
        if (isset($args['1'])) {
            $method = $args['1'];
            unset($args['1']);
        }
        $params = array(
            'account_id' => $this->_accountId,
            'api_key' => $this->_apiKey
        );

        if (isset($args[0]) && is_array($args[0])) {
            $params = array_merge($params, $args[0]);
        }

        return $this->_getTransport()->send($this->_getApiUrl() . $name, $method, $params);
    }

    /**
     * Get option by name
     *
     * @param string $name
     * @return mixed|null
     */
    function getOption($name)
    {
        return isset($this->_options[$name]) ? $this->_options[$name] : null;
    }

    /**
     * Get transport, default transport is curl
     *
     * @return Transport\Transport|Transport\Curl
     */
    protected function _getTransport()
    {
        if (!($this->_transport instanceof Transport\Transport)) {
            $className = __NAMESPACE__ . '\\Transport\\' . ucfirst($this->getOption('transport'));
            $this->_transport = new $className();
        }
        return $this->_transport;
    }

    /**
     * Get Voximplant API URL
     *
     * @return string
     */
    protected function _getApiUrl()
    {
        return 'https://api.voximplant.com/platform_api/';
    }

}