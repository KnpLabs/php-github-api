<?php

namespace Github\HttpClient\Listener;

use Guzzle\Common\Event;
use Github\Client;
use Github\Exception\RuntimeException;

class AuthListener
{
    private $tokenOrLogin;
    private $password;
    private $method;

    public function __construct($tokenOrLogin, $password = null, $method)
    {
        $this->tokenOrLogin = $tokenOrLogin;
        $this->password = $password;
        $this->method = $method;
    }

    public function onRequestBeforeSend(Event $event)
    {
        // Skip by default
        if (null === $this->method) {
            return;
        }

        switch ($this->method) {
            case Client::AUTH_HTTP_PASSWORD:
                $event['request']->setHeader(
                    'Authorization',
                    sprintf('Basic %s', base64_encode($this->tokenOrLogin . ':' . $this->password))
                );
                break;

            case Client::AUTH_HTTP_TOKEN:
                $event['request']->setHeader('Authorization', sprintf('token %s', $this->tokenOrLogin));
                break;

            case Client::AUTH_URL_CLIENT_ID:
                $url = $event['request']->getUrl();

                $parameters = array(
                    'client_id'     => $this->tokenOrLogin,
                    'client_secret' => $this->password,
                );

                $url .= (false === strpos($url, '?') ? '?' : '&');
                $url .= utf8_encode(http_build_query($parameters, '', '&'));

                $event['request']->setUrl($url);
                break;

            case Client::AUTH_URL_TOKEN:
                $url = $event['request']->getUrl();
                $url .= (false === strpos($url, '?') ? '?' : '&');
                $url .= utf8_encode(http_build_query(array('access_token' => $this->tokenOrLogin), '', '&'));

                $event['request']->setUrl($url);
                break;

            default:
                throw new RuntimeException(sprintf('%s not yet implemented', $this->method));
                break;
        }
    }
}
