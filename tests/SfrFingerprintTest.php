<?php

use PHPUnit\Framework\TestCase;
use SfrAuthentication\SfrFingerprint;

final class SfrFingerprintTest extends TestCase
{
    private const FINGERPRINT_FORMAT_REGEX = "/^([A-Za-z0-9 ]+) \| ([A-Za-z0-9- ]+) \| ([0-9a-f]{16})$/";

    /**
     * @param string $fingerprint The fingerprint to check
     * @return void
     * @test
     * @dataProvider fingerprintProvider
     */
    public function checkFormat(string $fingerprint): void
    {
        $this->assertEquals(1, preg_match(self::FINGERPRINT_FORMAT_REGEX, $fingerprint), "Fingerprint did not matched the regex");
    }

    public function fingerprintProvider(): array
    {
        return [
            [ SfrFingerprint::generateFingerprint() ]
        ];
    }
}
