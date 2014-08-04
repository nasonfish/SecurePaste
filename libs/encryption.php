<?php

require('Crypt/Blowfish.php');

function encrypt($key, $text, $iv){
    $encrypt = new Crypt_Blowfish($key,$iv);
    return $encrypt->encrypt($text);
}

function decrypt($key, $text, $iv){
    $encrypt = new Crypt_Blowfish($key,$iv);
    return $encrypt->decrypt($text);
}
