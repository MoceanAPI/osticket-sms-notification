# Installation steps

This module is to be added to OSTicket system. Kindly follow the next steps to add it:
1. Download and extract module source code
2. Drop module directory into OSTicket source code root directory
3. Make the following changes in the OSTicket source code:

    a. Add this line to the beginning of class.ticket.php file (/osticket/include/class.ticket.php) :
        ```include_once(dirname(__FILE__).'/../moceanapi/class/SMSNotification.php');```

    b. Add the following functions to the Ticket class in class.ticket.php file:
    ```
    function alertUser($status = '') {
        $sms_notification = SMSNotification::getInstance();
        $phone = $this->getPhoneNumber();

        if(empty($status)) {
            $status = $this->getStatus()->getState();
        }

        $replacements = [
            "[ticket_status]"=>$status,
            "[ticket_number]"=>$this->ht["number"],
            "[lastupdate]"=>$this->ht["updated"],
            "[user_full_name]"=>$this->ht["user"]->ht["name"],
            "[user_phone]"=>$phone,
            "[last_staff_name]"=>$this->getStaff()->ht["firstname"]." ".$this->getStaff()->ht["lastname"],
            "[department]"=>$this->ht["dept"]->ht["name"]
        ];

        $sms_notification->trigger_status_notification($phone, $status, $replacements);
    }
    function onNewTicketSMSAlert() {
       $sms_notification = SMSNotification::getInstance();
       $status = $this->getStatus();
       $replacements = [
           "[ticket_status]"=>$status->getState(),
           "[ticket_number]"=>$this->ht["number"],
           "[lastupdate]"=>$this->ht["updated"],
           "[user_full_name]"=>$this->ht["user"]->ht["name"],
           "[last_staff_name]"=>$this->getStaff()->ht["firstname"]." ".$this->getStaff()->ht["lastname"],
           "[department]"=>$this->ht["dept"]->ht["name"]
       ];
       $sms_notification->trigger_admin_notification($replacements);
    }
    ```
4. Add ```$this->alertUser();``` to the end of ```function setStatus``` before it’s return.
5. Add below code snippet to the end of ```function onNewTicket``` before it’s return.
```php
$this->alertUser("open");
$this->onNewTicketSMSAlert();
```
7. Add ```$this->alertUser($isanswered === 1 ? 'answered' : 'unanswered');``` to the beginning of ```function setAnsweredState```.
8. Add ```$this->alertUser('overdue');``` to the end of ```function markOverdue``` before it's return.
9. Add ```$this->alertUser('notdue');``` to the end of ```function clearOverdue``` before it's return.
10. Add ```$this->alertUser('assigned');``` to the end of ```function assign``` before it's return
11. Add ```$this->alertUser('unassined');``` to the beginning of ```function release```
12. Add ```$this->alertUser('deleted');``` to the end of ```function delete``` before it's return
13. Add ```$this->alertUser('locked');``` to the end of ```function acquireLock``` before it's return
13. Add ```$this->alertUser("reopened");``` to the end of ```function reopen``` before it's return
- In the above steps it was suppose that moceanapi it the name of module directory
dropped in the osticket source code.
- This module uses exactly osticket database and tables, also the database username & password. No need to change anything in the module until and unless you want to customize it
# How To Use
Now, if your domain is example.com, you can access module settings in the following link:
- example.com/moceanapi
* Please note that it is necessary to have osticket run to be able to access this module.
the complete process and module developed based on the PDF you provided and applied to OSticket
Try for FREE now. 20 trial SMS credits will be given upon [registration](https://dashboard.moceanapi.com/register?fr=osticket). Additional SMS credits can be requested and is subject to approval by MoceanAPI
