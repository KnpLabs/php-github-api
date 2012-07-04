<?php

namespace Github\Exception;

/**
 * ApiLimitExceedException
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class ApiLimitExceedException extends \RuntimeException
{
    public function __construct($limit)
    {
        parent::__construct('You have reached GitHub hour limit! Actual limit is: '. $limit);
    }
}
