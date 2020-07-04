<?php

namespace Github\Exception;

class TwoFactorAuthenticationRequiredException extends RuntimeException
{
    /** @var string */
    private $type;

    /**
     * @param string          $type
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($type, $code = 0, $previous = null)
    {
        $this->type = $type;
        parent::__construct('Two factor authentication is enabled on this account', $code, $previous);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
