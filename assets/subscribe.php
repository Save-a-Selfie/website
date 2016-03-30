<?php
 
require_once 'MailChimp.php';
use \DrewM\MailChimp\MailChimp;
 
// Email address verification
function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
  
if($_POST) {
  
    $mailchimp_api_key = 'f4f72f1fc3ed80d9007f63428927720a-us13'; // enter your MailChimp API Key
    // ****
    $mailchimp_list_id = 'd4b7f040cd'; // enter your MailChimp List ID
    // ****
  
    $subscriber_email = addslashes( trim( $_POST['email'] ) );
  
    if( !isEmail($subscriber_email) ) {
        $array = array();
        $array['valid'] = 0;
        $array['message'] = 'Sorry email is not valid!';
        echo json_encode($array);
    }
    else {
        $array = array();
          
        $MailChimp = new MailChimp($mailchimp_api_key);
         
        $result = $MailChimp->post("lists/$mailchimp_list_id/members", [
                'email_address' => $subscriber_email,
                'status'        => 'pending',
        ]);
          
        if($result == false) {
            $array['valid'] = 0;
            $array['message'] = 'An error occurred! Please try again later.';
        }
        else {
            $array['valid'] = 1;
            $array['message'] = 'Thanks for your subscription! We will sent you a confirmation email.';
        }
  
            echo json_encode($array);
  
    }
  
}
  
?>