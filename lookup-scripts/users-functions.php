<?php
// JSON for using in Graylog lookup tables.
// J.THOMAS
// Update:
// 12/12/2017

function userMoodle($file) {
// Generate a JSON with moodle userid
        define('APPROOT', dirname(__FILE__).'/');
        require_once(APPROOT.'conf/db-moodle.php');

        // ****************************************************************
        //             Initialisation de la connexion a Moodle
        // ****************************************************************
        $hconn = $moodle_conn;

        // ****************************************************************
        //             Moodle SQL for courses
        // ****************************************************************
        $sth = mysqli_query($hconn,"SELECT u.id as moodle_userid , u.username as uid FROM mdl_user u");
        $rows = array();
        while($r = mysqli_fetch_assoc($sth)) {
            $rows[$r['uid']] = $r;
        }

        $json = json_encode($rows,JSON_PRETTY_PRINT);
        //print_r($rows);
        file_put_contents($file, $json);
}

function userLDAP($file) {
// Generate a JSON with LDAP users
        define('APPROOT', dirname(__FILE__).'/');
        require_once(APPROOT.'conf/ldap.php');

        $total = 0;
        $listeUid = array();

        do {

                ldap_control_paged_result($ldap, $pageSize, true, $cookie);
                $res  = ldap_search($ldap, $dn, $filter, $attributes);
                $donnee = ldap_get_entries($ldap, $res);

                 for ($i = 0;$i<$donnee["count"];$i++){
                                $uid = $donnee[$i]['uid'][0];
                                $employeeType = (array_key_exists('employeetype',$donnee[$i]))? $donnee[$i]['employeetype'][0]: "non renseigne";
                                $eduPersonPrimaryAffiliation = (array_key_exists('edupersonprimaryaffiliation',$donnee[$i]))? $donnee[$i]['edupersonprimaryaffiliation'][0]: "non renseigne";
                                $supannEntiteAffectationPrincipale = (array_key_exists('supannentiteaffectationprincipale',$donnee[$i]))? $donnee[$i]['supannentiteaffectationprincipale'][0]: "non renseigne";
                                $supannEntiteAffectation = (array_key_exists('supannentiteaffectation',$donnee[$i]))? $donnee[$i]['supannentiteaffectation'][0]: "non renseigne";
                                $supannEtuCursusAnnee = (array_key_exists('supannetucursusannee',$donnee[$i]))? $donnee[$i]['supannetucursusannee'][0]: "non renseigne";
                                $supannEtuSecteurDisciplinaire = (array_key_exists('supannetusecteurdisciplinaire',$donnee[$i]))? $donnee[$i]['supannetusecteurdisciplinaire'][0]: "non renseigne";
                                $listeUid[$uid]['uid'] = $uid;
                                $listeUid[$uid]['employeeType'] = $employeeType;
                                $listeUid[$uid]['edupersonprimaryaffiliation'] = $eduPersonPrimaryAffiliation;
                                $listeUid[$uid]['supannEntiteAffectationPrincipale'] = $supannEntiteAffectationPrincipale;
                                $listeUid[$uid]['supannEntiteAffectation'] = $supannEntiteAffectation;
                                $listeUid[$uid]['supannEtuCursusAnnee'] = $supannEtuCursusAnnee;
                                $listeUid[$uid]['supannEtuSecteurDisciplinaire'] = $supannEtuSecteurDisciplinaire;
        #                       print_r($donnee[$i]['employeetype']);
                         }
        #                print_r($donnee);
        #                $total += $donnee["count"];
                 ldap_control_paged_result_response($ldap, $res, $cookie);

             } while($cookie !== null && $cookie != '');

                ldap_close($ldap);
        #       echo "Il y a ".$total." groupe dans l'OU ".$dn."\n";
                $json = json_encode($listeUid,JSON_PRETTY_PRINT);
                file_put_contents($file, $json);
        #       print_r($listeUid);
}

function userGlobal($globalfile,$ldapfile,$moodlefile) {
// Generate a JSON with moodle userid and LDAP informations
    define('APPROOT', dirname(__FILE__).'/');

    $tabLDAP = json_decode(file_get_contents($ldapfile), true);
    $tabMoodle = json_decode(file_get_contents($moodlefile), true);
    $tabGlobal = array();

    foreach ($tabLDAP as $LDAP) {
            if(array_key_exists($LDAP['uid'],$tabMoodle)) {
                //$tabGlobal[$LDAP['uid']]['uid'] = $LDAP['uid'];
                //$tabGlobal[$LDAP['uid']]['employeetype'] = $LDAP['employeetype'];
                //$tabGlobal[$LDAP['uid']]['supannentiteeffectation'] = $LDAP['supannentiteeffectation'];
                //$tabGlobal[$LDAP['uid']]['moodle_userid'] = $tabMoodle[$LDAP['uid']]['moodle_userid'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['uid'] = $LDAP['uid'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['employeeType'] = $LDAP['employeeType'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['edupersonprimaryaffiliation'] = $LDAP['edupersonprimaryaffiliation'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['supannEntiteAffectationPrincipale'] = $LDAP['supannEntiteAffectationPrincipale'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['supannEntiteAffectation'] = $LDAP['supannEntiteAffectation'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['supannEtuCursusAnnee'] = $LDAP['supannEtuCursusAnnee'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['supannEtuSecteurDisciplinaire'] = $LDAP['supannEtuSecteurDisciplinaire'];
                $tabGlobal[$tabMoodle[$LDAP['uid']]['moodle_userid']]['moodle_userid'] = $tabMoodle[$LDAP['uid']]['moodle_userid'];
            }
    }

    $json = json_encode($tabGlobal,JSON_PRETTY_PRINT);
    //print_r($json);
    file_put_contents($globalfile, $json);
}

?>
