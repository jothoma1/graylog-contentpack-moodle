<?php

define('APPROOT', dirname(__FILE__).'/');
$moodlefile = APPROOT.'data/moodleuserdata.json';
$ldapfile = APPROOT.'data/ldapuserdata.json';
$globalfile = APPROOT.'data/globaluserdata.json';
require_once(APPROOT.'users-functions.php');

# TODO: Gerer le raffraichissement des fichiers
if (file_exists($moodlefile)) {
    echo "Le fichier $moodlefile existe.";
} else {
    userMoodle($moodlefile);
}
if (file_exists($ldapfile)) {
    echo "Le fichier $ldapfile existe.";
} else {
    userLDAP($ldapfile);
}
if (file_exists($globalfile)) {
    echo "Le fichier $globalfile existe.";
} else {
    userGlobal($globalfile,$ldapfile,$moodlefile);
}


        if (PHP_SAPI === 'cli') {
        $key = $argv[1];
        }else{
        $key = $_GET['key'];
        }

        header("Content-Type: application/json");

        $tabUid = json_decode(file_get_contents($globalfile), true);

        if(array_key_exists($key,$tabUid)){
                echo json_encode($tabUid[$key],JSON_PRETTY_PRINT);
        }else{
                echo json_encode(array('message' => "Pas trouve"),JSON_PRETTY_PRINT);
        }

?>
