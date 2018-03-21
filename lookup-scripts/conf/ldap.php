<?php

$ldap_server = "MYLDAP" ;
$ldap_user   = "LDAP_USER";
$ldap_pass   = "LDAP_PASS" ;
$dn = "ou=People,dc=xxx,dc=fr";
$filter = "(uid=*)";

// Here you can specify all the attributes you want from LDAP
$attributes = array('uid','employeeType','edupersonprimaryaffiliation','supannentiteaffectationprincipale','supannentiteaffectation','supannetucursusannee','supannetusecteurdisciplinaire');

$ldap = ldap_connect($ldap_server) or die("Problème de connexion ldap");

if(ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3)){
if(ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0))
if(ldap_start_tls($ldap))
        $bound = ldap_bind($ldap, $ldap_user, $ldap_pass) or die("Problème d'identification ldap");
}

$pageSize = 1000;
$cookie = '';

?>
