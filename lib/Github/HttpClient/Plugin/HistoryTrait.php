<?php

namespace Github\HttpClient\Plugin;

use Http\Client\Exception;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

/*
 * Below is a some code to make the History plugin compatible with both 1.x and 2.x of php-client/client-common
 */
if (\interface_exists(\Http\Client\Common\HttpMethodsClientInterface::class)) {
    /**
     * @internal code for php-http/client-common:2.x
     */
    trait HistoryTrait
    {
        public function addFailure(RequestInterface $request, ClientExceptionInterface $exception)
        {
        }
    }
} else {
    /**
     * @internal code for php-http/client-common:1.x
     */
    trait HistoryTrait
    {
        public function addFailure(RequestInterface $request, Exception $exception)
        {
        }
    }
}
