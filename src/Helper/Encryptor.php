<?php

namespace Dotencrypt\Helper;

use Exception;

class Encryptor
{
    private const CIPHER = 'aes-256-cbc';
    private const HASH_ALGO = 'sha256';
    
    public static function encrypt(string $data, string $key): string{
        $ivLength = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $hashedKey = hash(self::HASH_ALGO, $key, true);
        
        $encrypted = openssl_encrypt($data, self::CIPHER, $hashedKey, OPENSSL_RAW_DATA, $iv);
        
        if ($encrypted === false) {
            throw new Exception("Encryption failed");
        }
        
        // Combine IV and encrypted data
        return base64_encode($iv . $encrypted);
    }
    
    public static function decrypt(string $data, string $key): ?string{
        $data = base64_decode($data);
        
        $ivLength = openssl_cipher_iv_length(self::CIPHER);
        $iv = mb_substr($data, 0, $ivLength, '8bit');
        $encrypted = mb_substr($data, $ivLength, null, '8bit');
        
        $hashedKey = hash(self::HASH_ALGO, $key, true);
        
        $decrypted = openssl_decrypt($encrypted, self::CIPHER, $hashedKey, OPENSSL_RAW_DATA, $iv);
        
        if ($decrypted === false) {
            return null;
        }
        
        return $decrypted;
    }
}