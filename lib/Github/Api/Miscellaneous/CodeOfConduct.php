<?php

namespace Github\Api\Miscellaneous;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

class CodeOfConduct extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the accept header for the codes of conduct preview API.
     *
     * @return $this
     */
    public function configure()
    {
        $this->acceptHeaderValue = 'application/vnd.github.scarlet-witch-preview+json';

        return $this;
    }

    /**
     * List all codes of conduct.
     *
     * @link https://docs.github.com/rest/codes-of-conduct/codes-of-conduct#get-all-codes-of-conduct
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/codes_of_conduct');
    }

    /**
     * Get an individual code of conduct.
     *
     * @link https://docs.github.com/rest/codes-of-conduct/codes-of-conduct#get-a-code-of-conduct
     *
     * @param string $key
     *
     * @return array
     */
    public function show($key)
    {
        return $this->get('/codes_of_conduct/'.rawurlencode($key));
    }
}
