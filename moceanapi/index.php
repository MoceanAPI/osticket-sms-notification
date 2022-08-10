<?php
require_once("config.php");
require_once("../scp/admin.inc.php");

if (isset($_GET["export_logs"])) {
    $logs = collectSMSLogs();
    print '<code><pre style="text-align:left; margin:10px;">'.implode("\n\n",$logs).'</pre></code>';
    exit;
}

global $status_settings_keys;
$body["type"] = "sms_settings";

if(isset($_POST["type"]) && $_POST['type'] == 'send_sms') {
    $form_errors = [];
    $form_successes = [];

    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $sms_mobile_numbers = $_POST['send_sms_mobile_numbers'];

    $regex = "/^[0-9,]+$/";
    if(!preg_match($regex, $sms_mobile_numbers)) {
        $form_errors['send_sms'][] = 'Mobile number must be comma separated values. Eg: 60123456789,65123123123';
    }
    else {
        $sms_from = $_POST['send_sms_from'];
        $sms_message = $_POST['send_sms_message'];
        $sms_to_numbers = explode(',', $sms_mobile_numbers);
        $sms_notification = SMSNotification::getInstance();
        foreach($sms_to_numbers as $sms_to) {
            $sms_notification->send_sms($sms_to, $sms_message, $sms_from);
        }
        $form_successes['send_sms'][] = 'SMS Sent successfully';
    }
}

if (isset($_POST["type"])) {
    $body = $_POST;
    if ($body["type"] == "admin_settings") {
        $body["admin_sms_enabled"] = !isset($body["admin_sms_enabled"]) ? '0' : '1';
        updateConfigsWithColumns($body);
    }
    else if ($_POST["type"] == 'customer_settings') {
        foreach ($status_settings_keys as $key) {
            $body["$key"] = !isset($body["$key"]) ? '0' : '1';
        }
        updateConfigsWithColumns($body);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/cookieconsent.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/cookieconsent.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/yandex.js"></script>
    <title>Ticket Status Notification Plugin</title>
</head>
<body>

<div id="main">
    <?php require_once('html/header.php'); ?>
    <?php require_once('html/sms_settings.php'); ?>
    <?php require_once('html/admin_settings.php'); ?>
    <?php require_once('html/customer_settings.php'); ?>
    <?php require_once('html/send_sms.php'); ?>
</div>

</body>
</html>
