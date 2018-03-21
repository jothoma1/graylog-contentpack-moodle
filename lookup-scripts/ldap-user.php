<?php

define('APPROOT', dirname(__FILE__).'/');
$ldapfile = APPROOT.'data/ldapuserdata.json';
require_once(APPROOT.'users-functions.php');

if (file_exists($ldapfile)) {
#    echo "Le fichier $ldapfile existe.";
} else {
    userLDAP($ldapfile);
}

        if (PHP_SAPI === 'cli') {
        $key = $argv[1];
        }else{
        $key = $_GET['key'];
        }

        header("Content-Type: application/json");

        $tabUid = json_decode(file_get_contents($ldapfile), true);

        if(array_key_exists($key,$tabUid)){
                echo json_encode($tabUid[$key],JSON_PRETTY_PRINT);
        }else{
                echo json_encode(array('message' => "Pas trouve"),JSON_PRETTY_PRINT);
        }

?>
