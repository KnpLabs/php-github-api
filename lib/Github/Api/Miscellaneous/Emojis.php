<?php declare(strict_types=1);

namespace Github\Api\Miscellaneous;

use Github\Api\AbstractApi;

class Emojis extends AbstractApi
{
    /**
     * Lists all the emojis available to use on GitHub.
     *
     * @link https://developer.github.com/v3/emojis/
     *
     * @return array
     */
    public function all(): array
    {
        return $this->get('/emojis');
    }
}
