<?php

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
abstract class Github_HttpClient_Abstract
{
    /**
     * The request options
     * @var array
     */
    protected $options = array(
        'protocol'   => 'http',
        'url'        => ':protocol://github.com/api/v2/:format/:path',
        'format'     => 'json',
        'user_agent' => 'php-github-api (http://github.com/ornicar/php-github-api)',
        'http_port'  => 80,
        'timeout'    => 10,
        'login'      => null,
        'token'      => null,
        'debug'      => false
    );

    protected static $history = array();

    /**
     * Instanciate a new request
     *
     * @param  array   $options  Request options
     */
    public function __construct(array $options = array())
    {
        $this->configure($options);
    }

    /**
     * Send a request to the server, receive a response
     *
     * @param  string   $url           Request API url
     * @param  array    $parameters    Parameters
     * @param  string   $httpMethod    HTTP method to use
     * @param  array    $options        Request options
     *
     * @return string   HTTP response
     */
    abstract protected function doSend($url, array $parameters = array(), $httpMethod = 'GET', array $options);

    /**
     * Send a GET request
     *
     * @param  string   $url            Request URL
     * @param  array    $parameters     GET Parameters
     * @param  string   $httpMethod     HTTP method to use
     * @param  array    $options        Request options
     *
     * @return array                    Data
     */
    public function get($apiPath, array $parameters = array(), array $options = array())
    {
        return $this->send($apiPath, $parameters, 'GET', $options);
    }

    /**
     * Send a POST request
     *
     * @param  string   $url            Request URL
     * @param  array    $parameters     POST Parameters
     * @param  string   $httpMethod     HTTP method to use
     * @param  array    $options        reconfigure the request for this call only
     *
     * @return array                    Data
     */
    public function post($apiPath, array $parameters = array(), array $options = array())
    {
        return $this->send($apiPath, $parameters, 'POST', $options);
    }

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array
     *
     * @param  string   $url            Request API url
     * @param  array    $parameters     Parameters
     * @param  string   $httpMethod     HTTP method to use
     * @param  array    $options        Request options
     *
     * @return array                    Data
     */
    protected function send($url, array $parameters = array(), $httpMethod = 'GET', array $options = array())
    {
        $this->updateHistory();

        $requestOptions = array_merge($this->options, $options);

        // get encoded response
        $response = $this->doSend($apiPath, $parameters, $httpMethod, $options);

        // decode response
        $response = $this->decodeResponse($response);

        return $response;
    }

    /**
     * Get a JSON response and transform it to a PHP array
     *
     * @return  array   the response
     */
    protected function decodeResponse($response)
    {
        if ('text' === $this->options['format']) {
            return $response;
        } elseif ('json' === $this->options['format']) {
            return json_decode($response, true);
        }

        throw new Exception(__CLASS__.' only supports json format, '.$this->options['format'].' given.');
    }

    /**
     * Configure the request
     *
     * @param   array               $options  Request options
     * @return  Github_HttpClientInterface $this     Fluent interface
     */
    public function configure(array $options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * Change an option value.
     *
     * @param string $name   The option name
     * @param mixed  $value  The value
     *
     * @return Github_HttpClientInterface The current object instance
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * Get an option value.
     *
     * @param  string $name The option name
     *
     * @return mixed  The option value
     */
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    /**
     * Records the requests times
     * When 30 request have been sent in less than a minute,
     * sleeps for two second to prevent reaching GitHub API limitation.
     *
     * @access protected
     * @return void
     */
    protected function updateHistory()
    {
        self::$history[] = time();
        if (30 === count(self::$history)) {
            if (reset(self::$history) >= (time() - 35)) {
                sleep(2);
            }
            array_shift(self::$history);
        }
    }

    protected function debug($message)
    {
        if ($this->options['debug']) {
            print $message."\n";
        }
    }
}
