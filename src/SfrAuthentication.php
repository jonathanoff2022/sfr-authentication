<?php

namespace Sfr;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SfrFingerprint;

class SfrAuthentication
{
    private const CREATE_TOKEN_URL = "https://www.sfr.fr/cas/services/rest/3.2/createToken.json";
    private const TOKEN_DURATION = 86400; // Same as the application

    private const USER_AGENT = 'SFRMonCompte/10.3.0 (com.sfr.android.moncompte; build:10303000; Android OS 12) okhttp/4.9.3';

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
        try {
            $response = $this->client->get(self::CREATE_TOKEN_URL, [
                'auth' => [$username, $password],
                'headers' => [
                    'Secret' => base64_encode('SFRETMoiAndroidV1:windows1980'),
                    'Fingerprint' => base64_encode(SfrFingerprint::generateFingerprint()),
                    'User-Agent' => self::USER_AGENT
                ]
            ]);
        } catch (GuzzleException $exception) {
            // TODO : Handle GuzzleException
            throw new Exception("Handling GuzzleException is not yet implemented", $previous = $exception);
        }

        // TODO : Implement authenticate function
        throw new Exception("Function authenticate is not yet implemented");
    }
}
