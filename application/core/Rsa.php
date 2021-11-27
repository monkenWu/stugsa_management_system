<?php
date_default_timezone_set("Asia/Taipei");

class Rsa extends  {

	
    
    public function __construct(){
    	
    	
    }

    private function _base64PrivateKey(){
        $key = '';
        $word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($word);
        for ($i = 0; $i < 10; $i++) {
            $key .= $word[rand() % $len];
        }
        return base64_encode($key);
    }

    public function getNewToken(){
        $key = '';
        $word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($word);
        for ($i = 0; $i < 50; $i++) {
            $key .= $word[rand() % $len];
        }
        return base64_encode($key);
    }

    public function getDeBase64($data){
        return base64_decode($data);
    }

    public function publicEncrypt($data, $publicKey){
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return $encrypted;
    }

    public function publicDecrypt($data, $publicKey){
        openssl_public_decrypt($data, $decrypted, $publicKey);
        return $decrypted;
    }

    public function privateEncrypt($data, $privateKey){
        openssl_private_encrypt($data, $encrypted, $privateKey);
        return $encrypted;
    }

    public function privateDecrypt($data, $privateKey){
        openssl_private_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }

    public function getPrivateKey(){
        return $this->_privateKey;
    }

    public function getPublicKey(){
        return $this->_publicKey;
    }
}


?>