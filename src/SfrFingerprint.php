<?php

class SfrFingerprint
{
    private const HEXADECIMAL_ALPHABET = "0123456789abcdef";

    private static function generateBrand(): string {
        // TODO : Generate brand
        return "BRAND";
    }

    private static function generateModelNumber(): string {
        return "MODEL-NUMBER";
    }

    public static function generateFingerprint(): string
    {
        // Format : $brand | $modelNumber | $id

        $brand = self::generateBrand();
        $modelNumber = self::generateModelNumber();

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
}
