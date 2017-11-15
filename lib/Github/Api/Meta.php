<?php declare(strict_types=1);

namespace Github\Api;

/**
 * Getting GitHub service information.
 *
 * @link   https://developer.github.com/v3/meta/
 * @author Claude Dioudonnat <claude.dioudonnat@gmail.com>
 */
class Meta extends AbstractApi
{
    /**
     * Get the ip address of the hook and git servers for the GitHub.com service.
     *
     * @return array Information about the service of GitHub.com
     */
    public function service(): array
    {
        return $this->get('/meta');
    }
}
