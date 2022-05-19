<?php
global $body,$default_values,$status_settings_keys;
?>

<div style="display: <?php if ($body['type'] == 'customer_settings') { echo 'block';} else { echo 'none';} ?>" id="customer_settings" class="tabcontent section">
    <h3 class="section">Customer Settings</h3>
    <div class="main_customer">
        <div class="main">
            <form class="form" method="post">
                <div class="form-group row">
                    <input type="hidden" value="customer_settings" id="type" name="type"/>
                    <?php csrf_token(); ?>
                    <div class="col-sm-2">
                        <label>Send Notification On</label>
                    </div>
                    <div class="form-check col-sm-3">
                        <?php
                        foreach ($status_settings_keys as $key) {
                            echo '<div class="col"><input '. ($default_values["$key"] == 1 ? "checked" : 'unchecked') .' style="margin-left: 0;" type="checkbox" class="form-check-input" id="'. $key .'" name="'. $key .'"><label class="form-check-label" for="'. $key .'">'. $key .'</label></div>';
                        }
                        ?>
                    </div>
                </div>

                <?php
                foreach ($status_settings_keys as $key) {
                    echo '<div class="form-group row formgrp">
                    <div class="col-sm-2">
                        <label>'. $key .' SMS Message</label>
                    </div>
                    <div class="col-sm-5">
                        <textarea name="'. $key .'_message" id="'.$key.'_message" rows="6" class="form-control" aria-describedby="'.$key.'_message_help" placeholder="'.$key.' SMS message">'.$default_values["$key"."_message"].'</textarea>
                        <small id="'.$key.'_message_help" class="form-text text-muted">Customize your SMS with keywords
                            <button type="button" onclick="showKeywordsForInput(\''.$key.'_message\')">
                                Keywords
                            </button>
                        </small>

                    </div>
                </div>';
                }
                ?>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>