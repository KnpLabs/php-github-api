<?php

namespace Github\Tests\Mock;

use Buzz\Message\Response as BaseResponse;
use Github\Exception\ApiLimitExceedException;

class TestResponse extends BaseResponse
{
    /**
     * @var integer
     */
    public $remainingCalls;

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return null;
    }

    /**
     * @return array|null
     */
    public function getPagination()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getApiLimit()
    {
        return null;
    }
}
