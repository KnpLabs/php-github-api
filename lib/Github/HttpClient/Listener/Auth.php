<?php

namespace Github\HttpClient\Listener;

use Github\Client;
use Github\Exception\InvalidArgumentException;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Util\Url;

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
     *
     * @throws InvalidArgumentException
     */
    public function __construct($method, array $options)
    {
        if (!isset($options['token']) || (!isset($options['login'], $options['password']))) {
            throw new InvalidArgumentException('You need to set OAuth token, or username with password!');
        }

        $this->method  = $method;
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function preSend(RequestInterface $request)
    {
        switch ($this->method) {
            case Client::AUTH_HTTP_PASSWORD:
                $request->addHeader('Authorization: Basic '. base64_encode($this->options['login'] .':'. $this->options['password']));
                break;
            case Client::AUTH_HTTP_TOKEN:
                $request->addHeader('Authorization: token '. $this->options['token']);
                break;
            case Client::AUTH_URL_TOKEN:
            default:
                $url = $request->getUrl();

                if ('GET' === $request->getMethod()) {
                    $parameters = array(
                        'access_token' => $this->options['token']
                    );

                    $url .= '?'.utf8_encode(http_build_query($parameters, '', '&'));
                }

                $request->fromUrl(new Url($url));
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
