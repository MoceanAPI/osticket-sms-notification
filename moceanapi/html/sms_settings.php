<?php
global $body,$default_values;
?>

<div style="display: <?php if ($body['type'] == 'sms_settings') { echo 'block';} else { echo 'none';} ?>" id="sms_settings" class="tabcontent section">
    <h3 class="section">MoceanAPI Settings</h3>
    <div class="main_sms">
        <form class="form" method="post">
            <input type="hidden" value="sms_settings" id="type" name="type"/>
            <?php csrf_token(); ?>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="mocean_api_key">API Key</label>
                </div>
                <div class="col-sm-5">
                    <input type="text" value="<?php echo $default_values['mocean_api_key'];?>" class="form-control" name="mocean_api_key" id="mocean_api_key" aria-describedby="api_key_help" placeholder="API Key" required/>
                    <small id="api_key_help" class="form-text text-muted">Your MoceanSMS account API key. Account can be registered <a target="_blank" href="https://dashboard.moceanapi.com">here</a></small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="mocean_api_secret">API Secret</label>
                </div>
                <div class="col-sm-5">
                    <input type="text" value="<?php echo $default_values['mocean_api_secret'];?>" class="form-control" name="mocean_api_secret" id="mocean_api_secret" aria-describedby="secret_key_help" placeholder="API Secret" required/>
                    <small id="secret_key_help" class="form-text text-muted">Your MoceanSMS account API secret.</small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="mocean_msg_from">Message From</label>
                </div>
                <div class="col-sm-5">
                    <input type="text" value="<?php echo $default_values['mocean_msg_from'];?>"  class="form-control" name="mocean_msg_from" id="mocean_msg_from" aria-describedby="mocean_msg_from_help" placeholder="Message From" required/>
                    <small id="mocean_msg_from_help" class="form-text text-muted">Sender of the SMS when a message is received at a mobile phone.</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <form class="form" method="get">
            <input type="hidden" value="true" name="export_logs"/>
            <button type="submit" class="btn">Export SMS Logs</button>
        </form>
    </div>
</div>