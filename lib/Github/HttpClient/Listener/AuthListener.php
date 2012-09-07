<?php

namespace Github\HttpClient\Listener;

use Github\Client;
use Github\Exception\InvalidArgumentException;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Util\Url;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class AuthListener implements ListenerInterface
{
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $options;

    /**
     * @param string $method
     * @param array  $options
     */
    public function __construct($method, array $options)
    {
        $this->method  = $method;
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    public function preSend(RequestInterface $request)
    {
        // Skip by default
        if (null === $this->method) {
            return;
        }

        switch ($this->method) {
            case Client::AUTH_HTTP_PASSWORD:
                if (!isset($this->options['login'], $this->options['password'])) {
                    throw new InvalidArgumentException('You need to set username with password!');
                }
                $request->addHeader('Authorization: Basic '. base64_encode($this->options['login'] .':'. $this->options['password']));
                break;

            case Client::AUTH_HTTP_TOKEN:
                if (!isset($this->options['token'])) {
                    throw new InvalidArgumentException('You need to set OAuth token!');
                }
                $request->addHeader('Authorization: token '. $this->options['token']);
                break;

            case Client::AUTH_URL_CLIENT_ID:
                if (!isset($this->options['login'], $this->options['password'])) {
                    throw new InvalidArgumentException('You need to set client_id and client_secret!');
                }

                if ('GET' === $request->getMethod()) {
                    $url = $request->getUrl();

                    $parameters = array(
                        'client_id'     => $this->options['login'],
                        'client_secret' => $this->options['password'],
                    );

                    $url .= (false === strpos($url, '?') ? '?' : '&').utf8_encode(http_build_query($parameters, '', '&'));

                    $request->fromUrl(new Url($url));
                }
                break;

            case Client::AUTH_URL_TOKEN:
                if (!isset($this->options['token'])) {
                    throw new InvalidArgumentException('You need to set OAuth token!');
                }

                if ('GET' === $request->getMethod()) {
                    $url = $request->getUrl();

                    $parameters = array(
                        'access_token' => $this->options['token']
                    );

                    $url .= (false === strpos($url, '?') ? '?' : '&').utf8_encode(http_build_query($parameters, '', '&'));

                    $request->fromUrl(new Url($url));
                }
                break;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
    }
}
