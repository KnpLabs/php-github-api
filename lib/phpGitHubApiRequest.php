<?php

require_once(dirname(__FILE__).'/phpGitHubApiRequestException.php');

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

  /**
   * Instanciates a new request
   *
   * @param  array   $options  Request options
   */
  public function __construct(array $options = array())
  {
    $this->configure($options);
  }

  /**
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

  /**
   * @see send
   */
  public function get($apiPath, array $parameters = array())
  {
    return $this->send($apiPath, $parameters, 'GET');
  }

  /**
   * @see send
   */
  public function post($apiPath, array $parameters = array())
  {
    return $this->send($apiPath, $parameters, 'POST');
  }

  /**
   * gets a JSON response and transform it to a PHP array
   *
   * @return  array   the response
   */
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
    
    $queryString = utf8_encode(http_build_query($parameters, '', '&'));

    $completeUrl = $url . ('GET' === $httpMethod ? '?' . $queryString : '');

    $this->debug('send request: '.$completeUrl);

    $curlOptions = array(
      CURLOPT_URL             => $completeUrl,
      CURLOPT_PORT            => $this->options['http_port'],
      CURLOPT_USERAGENT       => $this->options['user_agent'],
      CURLOPT_FOLLOWLOCATION  => true,
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_TIMEOUT         => $this->options['timeout']
    );

    if (!empty($parameters) && 'POST' === $httpMethod)
    {
      $curlOptions[CURLOPT_POST]        = true;
      $curlOptions[CURLOPT_POSTFIELDS]  = $queryString;
    }

    $curl = curl_init();

    curl_setopt_array($curl, $curlOptions);

    $response     = curl_exec($curl);
    $headers      = curl_getinfo($curl);
    $errorNumber  = curl_errno($curl);
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