<?php
//Fichier de paramatrage pour les infos de la BDD moodle

$moodle_host = "MyMOODLE_BDD_Host";
$moodle_port = "";
$moodle_dbname = "DB";
$moodle_user = "USER";
$moodle_password = "PASSWORD";

$moodle_conn = mysqli_connect($moodle_host, $moodle_user, $moodle_password, $moodle_dbname);
/* Vérification de la connexion */
if (!$moodle_conn) {
    printf("Connexion to Moodle failed : %s\n", mysqli_connect_error());
    exit();
}
mysqli_set_charset($moodle_conn, "utf8");
?>
