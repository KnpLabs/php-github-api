<?php

namespace Github\HttpClient\Adapter\Guzzle;

use Github\Client;
use Github\Exception\RuntimeException;
use Github\HttpClient\Adapter\Guzzle\Message\Response;
use Github\HttpClient\AbstractAdapter;
use Guzzle\Common\Event;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Common\Exception\GuzzleException;

class HttpClient extends AbstractAdapter
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $client = $client ? : new GuzzleClient();

        $client->setBaseUrl($this->options['base_url']);
        $client->setSslVerification(false);

        $opts = $client->getConfig(GuzzleClient::CURL_OPTIONS);
        $opts[CURLOPT_TIMEOUT] = $this->options['timeout'];

        $client->getConfig()->set(GuzzleClient::CURL_OPTIONS, $opts);

        $this->options = array_merge($this->options, $options);
        $this->client = $client;

//        $this->addListener(new ErrorListener($this->options));

        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $headers = array())
    {
        if (0 < count($parameters)) {
            $path .= (false === strpos($path, '?') ? '?' : '&') . http_build_query($parameters, '', '&');
        }

        return $this->request($path, array(), 'GET', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'POST', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PATCH', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $path = trim($path, '/');

        $request = $this->client->createRequest($httpMethod, $path, $headers, json_encode($parameters));

        try {
            $response = new Response($request->send());
        } catch (GuzzleException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->lastRequest = $request;
        $this->lastResponse = $response;

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($method, $tokenOrLogin, $password = null)
    {
        switch ($method) {
            case Client::AUTH_HTTP_PASSWORD:
                $handler = function (Event $event) use ($tokenOrLogin, $password) {
                    $event['request']->setHeader(
                        'Authorization',
                        sprintf('Basic ', base64_encode($tokenOrLogin . ':' . $password))
                    );
                };
                break;

            case Client::AUTH_HTTP_TOKEN:
                $handler = function (Event $event) use ($tokenOrLogin, $password) {
                    $event['request']->setHeader('Authorization', sprintf('token ', $tokenOrLogin));
                };
                break;

            case Client::AUTH_URL_CLIENT_ID:
                $handler = function (Event $event) use ($tokenOrLogin, $password) {
                    $url = $event['request']->getUrl();

                    $parameters = array(
                        'client_id'     => $tokenOrLogin,
                        'client_secret' => $password,
                    );

                    $url .= (false === strpos($url, '?') ? '?' : '&');
                    $url .= utf8_encode(http_build_query($parameters, '', '&'));

                    $event['request']->setUrl($url);
                };
                break;

            case Client::AUTH_URL_TOKEN:
                $handler = function (Event $event) use ($tokenOrLogin, $password) {
                    $url = $event['request']->getUrl();
                    $url .= (false === strpos($url, '?') ? '?' : '&');
                    $url .= utf8_encode(http_build_query(array('access_token' => $tokenOrLogin), '', '&'));

                    $event['request']->setUrl($url);
                };
                break;

            default:
                throw new RuntimeException(sprintf('%s not yet implemented', $method));
                break;
        }

        $this->client->getEventDispatcher()->addListener('request.create', $handler);
    }
}
