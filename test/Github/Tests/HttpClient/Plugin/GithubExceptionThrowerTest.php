<?php

namespace Github\Tests\HttpClient\Plugin;

use Github\Exception\ExceptionInterface;
use Github\HttpClient\Plugin\GithubExceptionThrower;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sergii Ivashchenko <serg.ivashchenko@gmail.com>
 */
class GithubExceptionThrowerTest extends TestCase
{
    /**
     * @param ResponseInterface                  $response
     * @param ExceptionInterface|\Exception|null $exception
     * @dataProvider responseProvider
     */
    public function testHandleRequest(ResponseInterface $response, ExceptionInterface $exception = null)
    {
        /** @var RequestInterface $request */
        $request = $this->getMockForAbstractClass(RequestInterface::class);

        $promise = $this->getMockBuilder(FulfilledPromise::class)->disableOriginalConstructor()->getMock();
        $promise->expects($this->once())
            ->method('then')
            ->willReturnCallback(function ($callback) use ($response) {
                return $callback($response);
            });

        $plugin = new GithubExceptionThrower();

        if ($exception) {
            $this->expectException(get_class($exception));
            $this->expectExceptionCode($exception->getCode());
            $this->expectExceptionMessage($exception->getMessage());
        }

        $plugin->handleRequest(
            $request,
            function (RequestInterface $request) use ($promise) {
                return $promise;
            },
            function (RequestInterface $request) use ($promise) {
                return $promise;
            }
        );
    }

    /**
     * @return array
     */
    public static function responseProvider()
    {
        return [
            '200 Response' => [
                'response' => new Response(),
                'exception' => null,
            ],
            'Rate Limit Exceeded' => [
                'response' => new Response(
                    429,
                    [
                        'Content-Type' => 'application/json',
                        'X-RateLimit-Remaining' => 0,
                        'X-RateLimit-Limit' => 5000,
                    ],
                    ''
                ),
                'exception' => new \Github\Exception\ApiLimitExceedException(5000),
            ],
            'Two Factor Authentication Required' => [
                'response' => new Response(
                    401,
                    [
                        'Content-Type' => 'application/json',
                        'X-GitHub-OTP' => 'required; :2fa-type',
                    ],
                    ''
                ),
                'exception' => new \Github\Exception\TwoFactorAuthenticationRequiredException('2fa-type'),
            ],
            '400 Bad Request' => [
                'response' => new Response(
                    400,
                    [
                        'Content-Type' => 'application/json',
                    ],
                    json_encode(
                        [
                            'message' => 'Bad Request',
                        ]
                    )
                ),
                'exception' => new \Github\Exception\ErrorException('Bad Request', 400),
            ],
            '422 Unprocessable Entity' => [
                'response' => new Response(
                    422,
                    [
                        'Content-Type' => 'application/json',
                    ],
                    json_encode(
                        [
                            'message' => 'Bad Request',
                            'errors' => [
                                [
                                    'code' => 'missing',
                                    'field' => 'field',
                                    'value' => 'value',
                                    'resource' => 'resource',
                                ],
                            ],
                        ]
                    )
                ),
                'exception' => new \Github\Exception\ErrorException('Validation Failed: The field value does not exist, for resource "resource"', 422),
            ],
            '502 Response' => [
                'response' => new Response(
                    502,
                    [
                        'Content-Type' => 'application/json',
                    ],
                    json_encode(
                        [
                            'errors' => [
                                ['message' => 'Something went wrong with executing your query'],
                            ],
                        ]
                    )
                ),
                'exception' => new \Github\Exception\RuntimeException('Something went wrong with executing your query', 502),
            ],
            'Default handling' => [
                'response' => new Response(
                    555,
                    [],
                    'Error message'
                ),
                'exception' => new \Github\Exception\RuntimeException('Error message', 555),
            ],
        ];
    }
}
