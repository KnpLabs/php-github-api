<?php

namespace Github\Api;

@trigger_error('The '.__NAMESPACE__.'\Integrations class is deprecated. Use the '.__NAMESPACE__.'\Apps class instead.', E_USER_DEPRECATED);

/**
 * @deprecated Use the Apps class
 * @link   https://developer.github.com/v3/apps/
 * @author Nils Adermann <naderman@naderman.de>
 */
class Integrations extends Apps
{
}
