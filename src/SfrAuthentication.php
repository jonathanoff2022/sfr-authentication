<?php

namespace Sfr;

use Exception;

class SfrAuthentication
{
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
