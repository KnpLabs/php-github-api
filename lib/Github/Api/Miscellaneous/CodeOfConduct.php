<?php

namespace Github\Api\Miscellaneous;

use Github\Api\AbstractApi;

class CodeOfConduct extends AbstractApi
{
    /**
     * Configure the accept header for the codes of conduct preview API.
     *
     * @deprecated since 3.17, GitHub no longer requires a custom accept header; this method will be removed in 4.0.
     *
     * @return $this
     */
    public function configure()
    {
        trigger_deprecation('KnpLabs/php-github-api', '3.17', 'The "%s" is deprecated and will be removed.', __METHOD__);

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
