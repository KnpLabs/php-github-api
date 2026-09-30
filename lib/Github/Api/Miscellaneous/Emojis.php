<?php

namespace Github\Api\Miscellaneous;

use Github\Api\AbstractApi;

class Emojis extends AbstractApi
{
    /**
     * Lists all the emojis available to use on GitHub.
     *
     * @link https://docs.github.com/rest/emojis/emojis#get-emojis
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/emojis');
    }
}
