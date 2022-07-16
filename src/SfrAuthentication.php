<?php

namespace Sfr;

use Exception;
use GuzzleHttp\Client;

class SfrAuthentication
{
    private Client $client;

    /**
     * @param string|null $proxy The proxy to use or null
     */
    public function __construct(?string $proxy = null)
    {
        $this->client = new Client([
            'proxy' => $proxy
        ]);
    }

    /**
     * Create SFR token using the given username and password, otherwise throw an exception
     *
     * @param string $username The username
     * @param string $password The password
     * @return string The created access token
     * @throws Exception An exception if an error occurs, if the credentials are invalid for example.
     */
    public function authenticate(string $username, string $password): string
    {
        // TODO : Implement authenticate function
        throw new Exception("Function authenticate is not yet implemented");
    }
}
