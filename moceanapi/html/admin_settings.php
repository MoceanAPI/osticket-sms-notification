<?php
global $body,$default_values;
?>

<div style="display: <?php if ($body['type'] == 'admin_settings') { echo 'block';} else { echo 'none';} ?>" id="admin_settings" class="tabcontent section">
    <h3 class="section">Admin Settings</h3>
    <div class="main_admin">
        <div class="main">
            <form class="form" method="post">
                <input type="hidden" value="admin_settings" id="type" name="type"/>
                <?php csrf_token(); ?>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="admin_sms_enabled">Enable Admin SMS Notification</label>
                    </div>
                    <div class="form-check col-sm-5">
                        <input <?php if ($default_values['admin_sms_enabled'] == 1) { echo 'checked';}?> style="margin-left: 0;" type="checkbox" class="form-check-input" name="admin_sms_enabled" id="admin_sms_enabled"/>
                        <label class="form-check-label" for="admin_sms_enabled">Enabled</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="admin_mobiles">Mobile Number</label>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" value="<?php echo $default_values['admin_mobiles'];?>" class="form-control" name="admin_mobiles" id="admin_mobiles" aria-describedby="admin_mobiles_help" placeholder="Mobile Number"/>
                        <small id="admin_mobiles_help" class="form-text text-muted">Mobile number to receive new ticket SMS notification. To send to multiple receivers, separate each entry with comma and mobile number must include country code, e.g. 60123456789, 65987654321.</small>
                    </div>
                </div>
                <div class="form-group row formgrp">
                    <div class="col-sm-2">
                        <label for="admin_sms_message">Admin SMS Message</label>
                    </div>
                    <div class="col-sm-5">
                        <textarea name="admin_sms_message" id="admin_sms_message" rows="6" class="form-control" aria-describedby="admin_sms_message_help" placeholder="Admin SMS message"><?php echo $default_values['admin_sms_message'];?></textarea>
                        <small id="admin_sms_message_help" class="form-text text-muted">Customize your SMS with keywords
                            <button type="button" onclick="showKeywordsForInput('admin_sms_message')">
                                Keywords
                            </button>
                        </small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>