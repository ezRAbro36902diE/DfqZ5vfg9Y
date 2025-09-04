<?php
// 代码生成时间: 2025-09-04 14:18:10
// Use Phalcon\Crypt
use Phalcon\Crypt;

class PasswordEncryption {

    private $crypt;
    private $key = 'your-encryption-key'; // Change this to a secure key

    /**
     * Constructor to initialize the Crypt component
     */
    public function __construct() {
        try {
            $this->crypt = new Crypt();
            $this->crypt->setKey($this->key);
        } catch (Exception $e) {
            // Handle the exception
            die('Error: ' . $e->getMessage());
        }
    }

    /**
     * Encrypt a password
     *
     * @param string $password The password to encrypt
     * @return string The encrypted password
     */
    public function encryptPassword($password) {
        try {
            $encrypted = $this->crypt->encryptBase64($password);
            return $encrypted;
        } catch (Exception $e) {
            // Handle the exception
            die('Error: ' . $e->getMessage());
        }
    }

    /**
     * Decrypt a password
     *
     * @param string $encryptedPassword The encrypted password to decrypt
     * @return string The decrypted password
     */
    public function decryptPassword($encryptedPassword) {
        try {
            $decrypted = $this->crypt->decryptBase64($encryptedPassword);
            return $decrypted;
        } catch (Exception $e) {
            // Handle the exception
            die('Error: ' . $e->getMessage());
        }
    }

}
