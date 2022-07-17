<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use SfrAuthentication\SfrAuthentication;
use SfrAuthentication\SfrAuthenticationException;
use SfrAuthentication\SfrException;

final class SfrAuthenticationTest extends TestCase
{
    /**
     * @param string $username The username of the account
     * @param string $password The password of the account
     * @return void
     * @test
     * @dataProvider credentialsProvider
     */
    public function authenticationFailedTest(string $username, string $password): void
    {
        $mockHandler = new MockHandler([
            new Response(403, [], '{"createToken":{"code":"BAD_CREDENTIALS_EXCEPTION","message":"Bad credentials for login : ' . $username . '"}}'),
        ]);

        $service = new SfrAuthentication(null, HandlerStack::create($mockHandler));

        try {
            $token = $service->authenticate($username, $password);
            $this->fail("Authenticated with token : " . $token);
        } catch (SfrException $exception) {
            $this->assertInstanceOf(SfrAuthenticationException::class, $exception);
            $this->assertEquals(SfrAuthenticationException::INVALID_CREDENTIALS, $exception->authenticationResult);
            $this->assertEquals('Bad credentials for login : ' . $username, $exception->getMessage());
        }
    }

    /**
     * @param string $username The username of the account
     * @param string $password The password of the account
     * @return void
     * @test
     * @dataProvider credentialsProvider
     */
    public function authenticationLockedTest(string $username, string $password): void
    {
        // TODO : Update the account locked response with a real response

        $mockHandler = new MockHandler([
            new Response(403, [], '{"createToken":{"code":"ACCOUNT_LOCKED_EXCEPTION","message":"*TODO*"}}'),
        ]);

        $service = new SfrAuthentication(null, HandlerStack::create($mockHandler));

        try {
            $token = $service->authenticate($username, $password);
            $this->fail("Authenticated with token : " . $token);
        } catch (SfrException $exception) {
            $this->assertInstanceOf(SfrAuthenticationException::class, $exception);
            $this->assertEquals(SfrAuthenticationException::ACCOUNT_LOCKED, $exception->authenticationResult);
            // TODO : Compare exception message
        }
    }

    public function credentialsProvider(): array
    {
        return [
            ["06" . rand(10000000, 99999999), "SfrAuthenticationTestWithZero"],
            ["6" . rand(10000000, 99999999), "SfrAuthenticationTestWithoutZero"]
        ];
    }
}
