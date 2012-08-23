<?php

namespace Github\Exception;

/**
 * MissingArgumentException
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class MissingArgumentException extends \ErrorException
{
    /**
     * @param string|array $required
     */
    public function __construct($required)
    {
        if (is_string($required)) {
            $required = array($required);
        }

        parent::__construct(sprintf('One or more of required ("%s") parameters is missing!', implode('", "', $required)));
    }
}
