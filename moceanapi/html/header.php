<?php
global $body;
?>

<div class="header">
    <h2 class="headerTitle">Ticket Status Notification Plugin</h2>
    <div class="tab">
        <button class="tablinks <?php if ($body['type'] == 'sms_settings') { echo 'active';} ?>" onclick="activeTab(event, 'sms_settings')">MoceanAPI Settings</button>
        <button class="tablinks <?php if ($body['type'] == 'admin_settings') { echo 'active';} ?>" onclick="activeTab(event, 'admin_settings')">Admin Settings</button>
        <button class="tablinks <?php if ($body['type'] == 'customer_settings') { echo 'active';} ?>" onclick="activeTab(event, 'customer_settings')">Customer Settings </button>
    </div>
</div>

<!-- Modal -->
<div id="keywordsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select a keyword</h4>
            </div>
            <div class="modal-body">

                <h4>CLIENT</h4>
                <table class="table table-striped">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a onclick="onKeywordClick('[user_full_name]')">[user_full_name]</a></td>
                        <td><a onclick="onKeywordClick('[user_phone]')">[user_phone]</a></td>
                    </tr>
                    </tbody>
                </table>

                <h4>TICKET</h4>
                <table class="table table-striped">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a onclick="onKeywordClick('[ticket_number]')">[ticket_number]</a></td>
                        <td><a onclick="onKeywordClick('[ticket_status]')">[ticket_status]</a></td>
                        <td><a onclick="onKeywordClick('[lastupdate]')">[lastupdate]</a></td>
                    </tr>
                    </tbody>
                </table>

                <h4>STAFF</h4>
                <table class="table table-striped">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a onclick="onKeywordClick('[last_staff_name]')">[last_staff_name]</a></td>
                    </tr>
                    </tbody>
                </table>

                <h4>DEPARTMENT</h4>
                <table class="table table-striped">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a onclick="onKeywordClick('[department]')">[department]</a></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <label>*Press on keyword to add to message template</label>
            </div>
        </div>
    </div>
</div>