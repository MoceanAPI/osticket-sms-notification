<?php
require_once("config.php");

if (isset($_GET["export_logs"])) {
    $logs = collectSMSLogs();
    print '<code><pre style="text-align:left; margin:10px;">'.implode("\n\n",$logs).'</pre></code>';
    exit;
}

global $status_settings_keys;
$body["type"] = "sms_settings";

if (isset($_POST["type"])) {
    $body = $_POST;
    if ($body["type"] == "admin_settings") {
        $body["admin_sms_enabled"] = !isset($body["admin_sms_enabled"]) ? '0' : '1';
    }
    else if ($_POST["type"] == 'customer_settings') {
        foreach ($status_settings_keys as $key) {
            $body["$key"] = !isset($body["$key"]) ? '0' : '1';
        }
    }
    updateConfigsWithColumns($body);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <title>Ticket Status Notification Plugin</title>
</head>
<body>

<div id="main">
    <?php require_once('html/header.php'); ?>
    <?php require_once('html/sms_settings.php'); ?>
    <?php require_once('html/admin_settings.php'); ?>
    <?php require_once('html/customer_settings.php'); ?>
</div>

</body>
</html>
