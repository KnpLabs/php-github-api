<?php

namespace Github\Exception;

/**
 * RuntimeException.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
    public function getCode()
    {
        return isset($this->code) ? $this->code : null;
    }
}
