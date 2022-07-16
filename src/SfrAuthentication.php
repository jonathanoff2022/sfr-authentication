<?php

namespace Sfr;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SfrAuthentication
{
    private const HEXADECIMAL_ALPHABET = "0123456789abcdef";

    private const CREATE_TOKEN_URL = "https://www.sfr.fr/cas/services/rest/3.2/createToken.json";
    private const TOKEN_DURATION = 86400; // Same as the application

    private const USER_AGENT = 'SFRMonCompte/10.3.0 (com.sfr.android.moncompte; build:10303000; Android OS 12) okhttp/4.9.3';

    private Client $client;

    private static function generateFingerprint(): string
    {
        // Format : $brand | $modelNumber | $id

        $brand = "BRAND";
        $modelNumber = "MODEL-NUMBER";

        try {
            $id = bin2hex(random_bytes(8));
        } catch (Exception $exception) {
            // "random_bytes" is not able to find a good source to generate random bytes.
            // But this generation does not need to be very secure.
            // Therefore, we will directly generate a hex string using "rand"
            $hexAlphabetLen = strlen(self::HEXADECIMAL_ALPHABET);
            $id = '';
            for ($index = 0; $index < 8; $index++) {
                $id .= self::HEXADECIMAL_ALPHABET[rand(0, $hexAlphabetLen)];
            }
        }

        return $brand . ' | ' . $modelNumber . ' | ' . $id;
    }

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
                    'Fingerprint' => base64_encode(self::generateFingerprint()),
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
