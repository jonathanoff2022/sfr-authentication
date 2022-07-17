<?php

namespace SfrAuthentication;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Utils;

class SfrAuthentication
{
    private const CREATE_TOKEN_URL = "https://www.sfr.fr/cas/services/rest/3.2/createToken.json";
    private const TOKEN_DURATION = 86400; // Same as the application

    private const USER_AGENT = 'SFRMonCompte/10.3.0 (com.sfr.android.moncompte; build:10303000; Android OS 12) okhttp/4.9.3';

    private Client $client;

    /**
     * @param string|null $proxy The proxy to use or null
     * @param HandlerStack|null $httpHandlerStack Stack of handlers for the HTTP client
     */
    public function __construct(?string $proxy = null, ?HandlerStack $httpHandlerStack = null)
    {
        $this->client = new Client([
            'proxy' => $proxy,
            'handler' => $httpHandlerStack
        ]);
    }

    /**
     * Create SFR token using the given username and password, otherwise throw an exception
     *
     * @param string $username The username
     * @param string $password The password
     * @return string The created access token
     * @throws SfrException An exception if an error occurs, if the credentials are invalid for example.
     */
    public function authenticate(string $username, string $password): string
    {
        try {
            $response = $this->client->get(self::CREATE_TOKEN_URL, [
                'auth' => [$username, $password],
                'headers' => [
                    'Secret' => 'Basic' . base64_encode('SFRETMoiAndroidV1:windows1980'),
                    'Fingerprint' => base64_encode(SfrFingerprint::generateFingerprint()),
                    'User-Agent' => self::USER_AGENT
                ],
                'query' => ['duration' => self::TOKEN_DURATION]
            ]);
        } catch (ClientException $exception) {
            $content = Utils::jsonDecode($exception->getResponse()->getBody(), true);
            $result = $content['createToken'];

            $code = $result['code'];
            $message = $result['message'];

            if (strcmp('BAD_CREDENTIALS_EXCEPTION', $code) == 0) {
                throw new SfrAuthenticationException(
                    SfrAuthenticationException::INVALID_CREDENTIALS, $message,
                    0, $exception
                );
            } else if (strcmp('ACCOUNT_LOCKED_EXCEPTION', $code) == 0) {
                // Here, the given account has got too many failed auth attempts, the account is locked
                throw new SfrAuthenticationException(
                    SfrAuthenticationException::ACCOUNT_LOCKED, $message,
                    0, $exception
                );
            }

            // Unknown authentication result code
            throw new SfrException("Unknown authentication result code", 0, $exception);
        } catch (GuzzleException $exception) {
            // TODO : Handle GuzzleException
            throw new SfrException("Handling GuzzleException is not yet implemented", 0, $exception);
        }

        // Here, the response status code is 2xx
        // TODO : Parse token of response
        return "TODO-parse-token";
    }
}
