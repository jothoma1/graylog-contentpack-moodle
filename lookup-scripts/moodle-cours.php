<?php
// Moodle SQL to JSON for using in Graylog lookup tables.
// J.THOMAS
// Update:
// 12/12/2017

define('APPROOT', dirname(__FILE__).'/');
require_once(APPROOT.'conf/db-moodle.php');


if (PHP_SAPI === 'cli') {
        $key = $argv[1];
}
else {
    $key = $_GET['key'];
}

// ****************************************************************
//             Initialisation de la connexion a Moodle
// ****************************************************************
$hconn = $moodle_conn;


// ****************************************************************
//             Moodle SQL for courses
// ****************************************************************
$sth = mysqli_query($hconn,"SELECT c.id as moodle_courseid , c.category as moodle_categoryid , cc.name as moodle_category , c.fullname as moodle_course_name , c.shortname as moodle_course_shortname FROM mdl_course c JOIN mdl_course_categories cc ON cc.id = c.category Where c.id = $key");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[$r['moodle_courseid']] = $r;
}



        if(array_key_exists($key,$rows)){
                 header("Content-Type: application/json");
                 echo json_encode($rows[$key],JSON_PRETTY_PRINT);
        }
?>
