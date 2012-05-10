<?php

namespace Github\HttpClient\Listener;

use Github\Client;

use Buzz\Message;
use Buzz\Listener\ListenerInterface;
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
     * @throws \InvalidArgumentException
     */
    public function __construct($method, array $options)
    {
        if (!isset($options['token']) || (!isset($options['login'], $options['password']))) {
            throw new \InvalidArgumentException('You need to set OAuth token, or username + password!');
        }

        $this->method  = $method;
        $this->options = $options;
    }

    public function preSend(Message\Request $request)
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

                $parameters = array(
                    'access_token' => $this->options['token']
                );

                $queryString = utf8_encode(http_build_query($parameters, '', '&'));

                if ('GET' === $request->getMethod()) {
                    $url .= '?'.$queryString;
                }

                $request->fromUrl(new Url($url));
                break;
        }
    }

    public function postSend(Message\Request $request, Message\Response $response)
    {
    }
}
