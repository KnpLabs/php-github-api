<?php

/**
 * Abstract class for Github_Api classes
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
abstract class Github_Api_Abstract implements Github_Api_Interface
{
    /**
     * The client
     * @var Github_Client
     */
    protected $client;

    public function __construct(Github_Client $client)
    {
        $this->client = $client;
    }
}
