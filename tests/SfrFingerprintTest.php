<?php

namespace SfrAuthentication;

use PHPUnit\Framework\TestCase;

final class SfrFingerprintTest extends TestCase
{
    private const FINGERPRINT_FORMAT_REGEX = "^([A-Za-z0-9 ]+) \| ([A-Za-z0-9- ]+) \| ([0-9a-f]+)$";

    /**
     * @return void
     * @test
     */
    public function checkFormat(): void
    {
        $fingerprint = SfrFingerprint::generateFingerprint();
        $this->assertEquals(1, preg_match(self::FINGERPRINT_FORMAT_REGEX, $fingerprint), "Fingerprint did not matched the regex");
    }
}
