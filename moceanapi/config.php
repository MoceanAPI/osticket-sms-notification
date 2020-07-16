<?php
// ToDo: xxx -> check the path
require_once(dirname(__FILE__).'/../main.inc.php');
if(!defined('INCLUDE_DIR')) die('Fatal Error. Kwaheri!');

$GLOBALS["db_sms_table"] = $db_sms_table = "ost_sms_configs";
$GLOBALS["db_sms_logs_table"] = $db_sms_logs_table = "ost_sms_logs";
$db_host = constant('DBHOST');
$db_name = constant('DBNAME');
$db_user = constant('DBUSER');
$db_pass = constant('DBPASS');

$GLOBALS["sms_settings_keys"] = $sms_settings_keys = ["mocean_api_key","mocean_api_secret","mocean_msg_from"];
$GLOBALS["admin_settings_keys"] = $admin_settings_keys = ["admin_sms_enabled","admin_mobiles","admin_sms_message"];
$GLOBALS["status_settings_keys"] = $status_settings_keys = ["open","closed","locked","archived","reopened","answered","unanswered",
    "notdue","deleted","assigned","unassined","overdue"];
$GLOBALS["status_settings_message"] = $status_settings_message = ["open"=>"open_message","closed"=>"closed_message",
    "locked"=>"locked_message","archived"=>"archived_message",
    "reopened"=>"reopened_message","answered"=>"answered_message","unanswered"=>"unanswered_message",
    "notdue"=>"notdue_message", "deleted"=>"deleted_message","assigned"=>"assigned_message",
    "unassined"=>"unassined_message","overdue"=>"overdue_message"];

$default_values = [];

try {
    //create PDO connection
    $GLOBALS["db"] = $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    checkDatasource();
    checkLogSource();
    loadDefaults();

} catch(PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}

function checkLogSource() {
    $db = $GLOBALS["db"];
    $db_sms_logs_table = $GLOBALS["db_sms_logs_table"];

    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $sql ="CREATE TABLE  IF NOT EXISTS $db_sms_logs_table (
     ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
     message text, 
     receivers text,
     response text, 
     logged_at DATETIME DEFAULT NOW());";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $stmt->closeCursor();
}

function checkDatasource() {
    $db = $GLOBALS["db"];
    $db_sms_table = $GLOBALS["db_sms_table"];
    $sms_settings_keys = $GLOBALS["sms_settings_keys"];
    $admin_settings_keys = $GLOBALS["admin_settings_keys"];
    $status_settings_keys = $GLOBALS["status_settings_keys"];
    $status_settings_message = $GLOBALS["status_settings_message"];

    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $sql ="CREATE TABLE  IF NOT EXISTS $db_sms_table (
     ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
     ".$sms_settings_keys[0]." text, 
     ".$sms_settings_keys[1]." text,
     ".$sms_settings_keys[2]." text, 
    
     ".$admin_settings_keys[0]." TINYINT( 1 ), 
     ".$admin_settings_keys[1]." text, 
     ".$admin_settings_keys[2]." text,";

    for ($i=0 ; $i < count($status_settings_keys) ; $i++) {
        $sql .= $status_settings_keys[$i]." TINYINT( 1 ) ,";
    }
    for ($i=0 ; $i < count($status_settings_message) ; $i++) {
        $sql .= $status_settings_message[$status_settings_keys[$i]]." VARCHAR( 1000 ),";
    }
    $sql .= ");";
    $sql = str_replace(",);" , ");", $sql);
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $stmt->closeCursor();
}

function loadDefaults() {
    global $default_values;
    $table = $GLOBALS["db_sms_table"];
    $stmt = $GLOBALS["db"]->prepare("SELECT *FROM $table limit 1");
    $stmt->execute(array());
    $default_values = $stmt->fetch();
    $stmt->closeCursor();
    $GLOBALS["default_values"] = $default_values;
}

function collectSMSLogs() {
    $db = $GLOBALS["db"];
    $db_sms_logs_table = $GLOBALS["db_sms_logs_table"];

    $stmt = $db->prepare("SELECT message,receivers,response FROM $db_sms_logs_table where 1");
    $stmt->execute();
    $logs = $stmt->fetchAll();

    $list = [];
    foreach ($logs as $log) {
        $item = '';
        $item .= "Message => $log[0]"."\n";
        $item .= "Receiver(s) => $log[1]"."\n";
        $item .= "Response => $log[2]"."\n";
        $list[] = $item;
    }
    $stmt->closeCursor();
    return $list;
}

function logSMS($receivers,$message,$response) {
    $db = $GLOBALS["db"];
    $db_sms_logs_table = $GLOBALS["db_sms_logs_table"];

    $query = "INSERT INTO $db_sms_logs_table (message,receivers,response) values ('{$message}','{$receivers}','{$response}')";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->closeCursor();
}

function updateConfigsWithColumns($values) {
    global $db,$default_values,$db_sms_table;
    if ($default_values == '') {
        $query = "INSERT INTO $db_sms_table values (1,'','','',0,'','',0,0,0,0,0,0
                                               ,0,0,0,0,0,0,'','','','','','','','','','','','')";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->closeCursor();
    }

    $query = "UPDATE $db_sms_table SET ";
    foreach ($values as $key => $value) {
        if ($key !== "type") {
            $query .= "$key = '$value' ,";
        }
    }

    $query .= " WHERE 1";
    $query = str_replace(", WHERE 1", " WHERE 1",$query);
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->closeCursor();
    loadDefaults();
}