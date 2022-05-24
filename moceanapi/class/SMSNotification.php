<?php
require_once dirname(__FILE__)."/../config.php";
require_once dirname(__FILE__)."/../lib/MoceanSMS.php";

/*
All error responses will be as follows:
{
  "status": number,
  "err_msg": string
}
*/
class SMSNotification {

    private static $instance = null;
    private $currentState = '';

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new SMSNotification();
        }

        return self::$instance;
    }

    private function setState($state)
    {
        $this->currentState = $state;
    }

    function trigger_admin_notification($replacements=[]) {
        $admin_settings_keys = $GLOBALS["admin_settings_keys"];
        $configs = $this->loadValue($admin_settings_keys);
        if ($configs[$admin_settings_keys[0]] == 1) {
            $message = $this->replaceKeywordsWithValue($replacements,$configs[$admin_settings_keys[2]]);
            /* status:0 means sent otherwise take a look at: https://moceanapi.com/docs/#send-sms */
            return $this->send_sms($configs[$admin_settings_keys[1]],$message);
        }
        $response["status"] = 400;
        $response["err_msg"] = "ADMIN NOTIFICATION IS DISABLED";
        return json_encode($response);
    }

    function trigger_status_notification($phoneNo ,$onStatus, $replacements=[]) {
        if($this->currentState == 'reopened') {
            $this->setState('open');
            return;
        }
        $status_settings_keys = $GLOBALS["status_settings_keys"];
        $status_settings_message = $GLOBALS["status_settings_message"];

        $status = lcfirst($onStatus);
        if (!in_array($status, $status_settings_keys)) {
            $response["status"] = 403;
            $response["err_msg"] = "STATUS IS NOT DEFINED";
            return json_encode($response);
        }

        $configs = $this->loadValue([$status, $status_settings_message[$status]]);
        if ($configs[$status] == 1) {
            $message = $this->replaceKeywordsWithValue($replacements,$configs[$status_settings_message[$status]]);
            /* status:0 means sent otherwise take a look at: https://moceanapi.com/docs/#send-sms */
            $response = $this->send_sms($phoneNo, $message);
            $this->setState($onStatus); // reopened
            return $response;
        }
        $response["status"] = 400;
        $response["err_msg"] = "NOTIFICATION FOR THIS STATUS IS DISABLED";
        return json_encode($response);
    }

    private function replaceKeywordsWithValue($replacements, $message) {
        if (count($replacements) == 0) {
            return $message;
        }
        foreach ($replacements as $key=>$value) {
            $message = str_replace($key, $value, $message);
        }
        return  $message;
    }

    private function loadValue($forConfigs) {
        $db_table = $GLOBALS["db_sms_table"];
        $db = $GLOBALS["db"];

        $stmt = $db->prepare("SELECT ". implode(",",$forConfigs) ." FROM $db_table WHERE 1");
        $stmt->execute(array());
        $default_values = $stmt->fetch();
        $stmt->closeCursor();
        return $default_values;
    }

    /*
     A successful response for MT-SMS will be as follows:
    {
      "messages":[
        {
          "status": 0,
          "receiver": "60173788399",
          "msgid": "cust20013050311050614001"
        }
      ]
    }
    While unsuccessfully response will be as follows:
    {
      "status": 1,
      "err_msg": "Authorization failed"
    }
    */
    public function send_sms($phone_no, $message, $from='') {
        logSMS($phone_no, $message, '');
        return true;
        if ($message == '') {
            $response["status"] = 400;
            $response["err_msg"] = "Text message is empty!";
            logSMS($phone_no,$message,$response);
            return $response;
        }

        $sms_settings_keys = $GLOBALS["sms_settings_keys"];
        $configs = $this->loadValue($sms_settings_keys);
        $from = (!empty($from) ? $from : $configs[$sms_settings_keys[2]] );
        try {
            $moceansms_rest = new MoceanSMS( $configs[$sms_settings_keys[0]], $configs[$sms_settings_keys[1]] );
            $response = $moceansms_rest->sendSMS(
                    $from,
                    $phone_no,
                    $message,
                    'MoceanSMSPligin');
            logSMS($phone_no,$message,$response);
            return $response;

        } catch ( Exception $e ) {
            $response["status"] = 500;
            $response["err_msg"] = "Not able to connect SMS panel!";
            logSMS($phone_no,$message,$response);
            return json_encode($response);
        }
    }
}
?>