<?php

namespace Github\HttpClient\Listener;

use Github\Exception\TwoFactorAuthenticationRequiredException;
use Github\HttpClient\Message\ResponseMediator;
use Guzzle\Common\Event;
use Github\Exception\ApiLimitExceedException;
use Github\Exception\ErrorException;
use Github\Exception\RuntimeException;
use Github\Exception\ValidationFailedException;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class ErrorListener
{
    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function onRequestError(Event $event)
    {
        /** @var $request \Guzzle\Http\Message\Request */
        $request = $event['request'];
        $response = $request->getResponse();

        if ($response->isClientError() || $response->isServerError()) {
            $remaining = (string) $response->getHeader('X-RateLimit-Remaining');
            $limit = $response->getHeader('X-RateLimit-Limit');

            if (null != $remaining && 1 > $remaining && 'rate_limit' !== substr($request->getResource(), 1, 10)) {
                throw new ApiLimitExceedException($limit);
            }

            if (401 === $response->getStatusCode()) {
                if ($response->hasHeader('X-GitHub-OTP') && 0 === strpos((string) $response->getHeader('X-GitHub-OTP'), 'required;')) {
                    $type = substr((string) $response->getHeader('X-GitHub-OTP'), 9);

                    throw new TwoFactorAuthenticationRequiredException($type);
                }
            }

            $content = ResponseMediator::getContent($response);
            if (is_array($content) && isset($content['message'])) {
                if (400 == $response->getStatusCode()) {
                    throw new ErrorException($content['message'], 400);
                } elseif (422 == $response->getStatusCode() && isset($content['errors'])) {
                    $errors = array();
                    foreach ($content['errors'] as $error) {
                        switch ($error['code']) {
                            case 'missing':
                                $errors[] = sprintf('The %s %s does not exist, for resource "%s"', $error['field'], $error['value'], $error['resource']);
                                break;

                            case 'missing_field':
                                $errors[] = sprintf('Field "%s" is missing, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            case 'invalid':
                                if (isset($error['message'])) {
                                    $errors[] = sprintf('Field "%s" is invalid, for resource "%s": "%s"', $error['field'], $error['resource'], $error['message']);
                                } else {
                                    $errors[] = sprintf('Field "%s" is invalid, for resource "%s"', $error['field'], $error['resource']);
                                }
                                break;

                            case 'already_exists':
                                $errors[] = sprintf('Field "%s" already exists, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            default:
                                $errors[] = $error['message'];
                                break;

                        }
                    }

                    throw new ValidationFailedException('Validation Failed: ' . implode(', ', $errors), 422);
                }
            }

            throw new RuntimeException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        };
    }
}
