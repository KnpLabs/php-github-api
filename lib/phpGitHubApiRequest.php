<?php

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author	Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license	MIT License
 */

class phpGitHubApiRequest
{
  protected
  $options = array(
    'url'         => 'http://github.com/api/v2/:format/:path',
    'format'      => 'json',
    'user_agent'  => 'php-github-api (http://github.com/ornicar/php-github-api)',
    'http_port'   => 80,
    'timeout'     => 20,
    'login'       => null,
    'token'       => null,
    'debug'       => false
  );

  /*
   * Instanciates a new request
   *
   * @param  array   $options  Request options
   */
  public function __construct(array $options = array())
  {
    $this->configure($options);
  }

  /*
   * Configures the request
   *
   * @param   array               $options  Request options
   * @return  phpGitHubApiRequest $this     Fluent interface
   */
  public function configure(array $options)
  {
    $this->options = array_merge($this->options, $options);

    return $this;
  }

  /**
   * Sends a request to the server, receive a response,
   * decode the response and returns an associative array
   *
   * @param  string   $apiPath       Request API path
   * @param  array    $parameters    Parameters
   * @param  string   $httpMethod    HTTP method to use
   *
   * @return array    Data
   */
  public function send($apiPath, array $parameters = array(), $httpMethod = 'GET')
  {
    return $this->decodeResponse($this->doSend($apiPath, $parameters, $httpMethod));
  }

  /*
   * @see send
   */
  public function get($apiPath, array $parameters = array())
  {
    return $this->send($apiPath, $parameters, 'GET');
  }

  /*
   * @see send
   */
  public function post($apiPath, array $parameters = array())
  {
    return $this->send($apiPath, $parameters, 'POST');
  }

  protected function decodeResponse($response)
  {
    if('json' === $this->options['format'])
    {
      return json_decode($response, true);
    }

    throw new Exception(__CLASS__.' only supports json format, '.$this->options['format'].' given.');
  }

  /**
   * Sends a request to the server, receives a response
   *
   * @param  string   $apiPath       Request API path
   * @param  array    $parameters    Parameters
   * @param  string   $httpMethod    HTTP method to use
   *
   * @return string   HTTP response
   */
  public function doSend($apiPath, array $parameters = array(), $httpMethod = 'GET')
  {
    $url = strtr($this->options['url'], array(
      ':format' => $this->options['format'],
      ':path'   => trim($apiPath, '/')
    ));

    if($this->options['login'])
    {
      $parameters = array_merge(array(
        'login' => $this->options['login'],
        'token' => $this->options['token']
      ), $parameters);
    }
    
    $queryString = utf8_encode(http_build_query($parameters));

    $completeUrl = $url . ('GET' === $httpMethod ? '?' . $queryString : '');

    $this->debug('send request: '.$completeUrl);

    $options[CURLOPT_URL] = $completeUrl;
    $options[CURLOPT_PORT] = $this->options['http_port'];
    $options[CURLOPT_USERAGENT] = $this->options['user_agent'];
    $options[CURLOPT_FOLLOWLOCATION] = true;
    $options[CURLOPT_RETURNTRANSFER] = true;
    $options[CURLOPT_TIMEOUT] = $this->options['timeout'];

    if (!empty($parameters) && 'POST' === $httpMethod)
    {
      $options[CURLOPT_POST] = true;
      $options[CURLOPT_POSTFIELDS] = $queryString;
    }

    $curl = curl_init();

    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);
    $headers = curl_getinfo($curl);

    $errorNumber = curl_errno($curl);
    $errorMessage = curl_error($curl);

    curl_close($curl);

    if (!in_array($headers['http_code'], array(0, 200)))
    {
      throw new phpGitHubApiRequestException(null, (int) $headers['http_code']);
    }

    if ($errorNumber != '')
    {
      throw new phpGitHubApiRequestException($errorMessage, $errorNumber);
    }

    return $response;
  }

  protected function debug($message)
  {
    if($this->options['debug'])
    {
      print $message."\n";
    }
  }
}

/**
 * Request communication error
 *
 */
class phpGitHubApiRequestException extends Exception
{
  /**
   * Http header-codes
   * @var  array
   */
  static protected $statusCodes = array(
      0 => 'OK',
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    306 => '(Unused)',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported'
  );

  /**
   * Default constructor
   *
   * @param  string $message
   * @param  int $code
   */
  public function __construct($message = null, $code = null)
  {
    if (is_null($message) && !is_null($code) && array_key_exists((int) $code, self::$statusCodes))
    {
      $message = sprintf('HTTP %d: %s', $code, self::$statusCodes[(int) $code]);
    }

    parent::__construct($message, $code);
  }
}