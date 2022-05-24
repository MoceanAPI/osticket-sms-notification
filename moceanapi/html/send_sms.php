<?php
global $body,$default_values;
?>
<!-- added sms->alertUser('reopened') in reopen() class.ticket.php -->
<div style="display: <?php if ($body['type'] == 'send_sms') { echo 'block';} else { echo 'none';} ?>" id="send_sms" class="tabcontent section">
    <h3 class="section">Send SMS</h3>
    <div class="main_admin">
        <div class="main">
            <?php
                if(!empty($form_errors['send_sms'])) {
                    foreach ($form_errors['send_sms'] as $error) {
            ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php
                    }
                }
            ?>
            <?php
                if(!empty($form_successes['send_sms'])) {
                    foreach ($form_successes['send_sms'] as $msg) {
            ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($msg); ?>
                </div>
            <?php
                    }
                }
            ?>
            <form class="form" method="post">
                <input type="hidden" value="send_sms" id="type" name="type"/>
                <?php csrf_token(); ?>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="send_sms_from">From</label>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="send_sms_from" id="send_sms_from" rows="6" class="form-control" aria-describedby="send_sms_from_help" placeholder="Your business name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="send_sms_mobile_numbers">Mobile Numbers</label>
                    </div>
                    <div class="col-sm-5">
                        <textarea name="send_sms_mobile_numbers" id="send_sms_mobile_numbers" rows="6" class="form-control" aria-describedby="send_sms_mobile_numbers_help" placeholder="60123456789,65987654321" required></textarea>
                        <small id="send_sms_mobile_numbers_help" class="form-text text-muted">Mobile numbers to send SMS. To send to multiple receivers, separate each entry with comma and mobile number must include country code, e.g. 60123456789, 65987654321.</small>
                    </div>
                </div>
                <div class="form-group row formgrp">
                    <div class="col-sm-2">
                        <label for="send_sms_message">Admin SMS Message</label>
                    </div>
                    <div class="col-sm-5">
                        <textarea name="send_sms_message" id="send_sms_message" rows="6" class="form-control" aria-describedby="send_sms_message_help" placeholder="SMS message" required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>