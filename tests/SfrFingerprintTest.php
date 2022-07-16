<?php

namespace SfrAuthentication;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class SfrFingerprintTest extends TestCase
{
    private const FINGERPRINT_FORMAT_REGEX = "^([A-Za-z0-9 ]+) \| ([A-Za-z0-9- ]+) \| ([0-9a-f]+)$";

    public function checkFormat(): void
    {
        $fingerprint = SfrFingerprint::generateFingerprint();
        assertEquals(preg_match(self::FINGERPRINT_FORMAT_REGEX, $fingerprint), 1, "Fingerprint did not matched the regex");
    }
}
