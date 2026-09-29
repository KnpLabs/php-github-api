<?php

namespace Github\Api\Miscellaneous;

use Github\Api\AbstractApi;

class Licenses extends AbstractApi
{
    /**
     * Lists all the licenses available on GitHub.
     *
     * @link https://docs.github.com/rest/licenses/licenses#get-all-commonly-used-licenses
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/licenses');
    }

    /**
     * Get an individual license by its license key.
     *
     * @link https://docs.github.com/rest/licenses/licenses#get-a-license
     *
     * @param string $license
     *
     * @return array
     */
    public function show($license)
    {
        return $this->get('/licenses/'.rawurlencode($license));
    }
}
