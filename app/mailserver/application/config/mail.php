<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 |--------------------------------------------------------------------------
 | Recipient
 |--------------------------------------------------------------------------
 |
 | Which email address will receive the mail after verification
 |
 */ 
 $config['mail_recipient'] =  'zentrale@bundesnachrichtendienst.de';
 

/*
 |--------------------------------------------------------------------------
 | Admin E-Mail
 |--------------------------------------------------------------------------
 |
 | Set the field name for the subject
 |
 */ 
 $config['mail_admin'] = 'admin@ueberwacht-mich-nicht.de';


/*
 |--------------------------------------------------------------------------
 | Required Fields
 |--------------------------------------------------------------------------
 |
 | Set the fields, that are required and need to have a value
 |
 */
$config['mail_validation_rules'] = array(
  array(
    'field'   => 'name', 
    'label'   => 'Name', 
    'rules'   => 'required'
  ),
  array(
    'field'   => 'mailaddress', 
    'label'   => 'Email', 
    'rules'   => 'required|valid_email'
  ),
  array(
    'field'   => 'domain',
    'label'   => 'Domain',
    'rules'   => 'required'
  ),
  array(
    'field'   => 'mailsubject',
    'label'   => 'Subject',
    'rules'   => 'required'
  ),
  array(
    'field'   => 'emailtext',
    'label'   => 'Message',
    'rules'   => 'required'
  ),
  array(
    'field'   => 'privacy',
    'label'   => 'Privacy Statement',
    'rules'   => 'required'
  )
);


/*
 |--------------------------------------------------------------------------
 | Message Body Fields
 |--------------------------------------------------------------------------
 |
 | Configure the form fields that should be part of the message
 | The key is the name of the POST parameter and the value the Field 
 | description that the message body will contain.
 | 
 | Example: 
 | 
 | array(
 |    'subject' => 'Subject: ',
 |    'body' => 'Message: '
 | );
 |
 | will result in a message:
 |
 | Subject: content of $_POST['subject']
 | Message: content of $_POST['body']
 |
 */ 
$config['mail_message_fields'] = array(
  'email_text' => ''
);


/*
 |--------------------------------------------------------------------------
 | Verify Address
 |--------------------------------------------------------------------------
 |
 | Send mails only after verification of the senders mail address.
 | If set to true, the message is saved in a database, a verification code 
 | is generated and a verification mail with verification link is sent to 
 | the sender.
 | The mail is being dispatched, after the verification link is called.
 |
 */
$config['mail_verify_address'] = true;




/*
 |--------------------------------------------------------------------------
 | Verification Messages
 |--------------------------------------------------------------------------
 |
 | The messages, that are displayed, if the verification is successful or 
 | failed.
 |
 */
$config['mail_verify_success'] = 'Ihre E-Mail wurde erfolgreich verschickt.';
$config['mail_verify_fail'] = 'Ihre E-Mail konnte nicht gesendet werden. Ist der Link gültig?';
$config['mail_verify_mailtext'] = 'Bitte verifizieren Sie Ihre E-Mail-Adresse, indem Sie auf den unten stehenden Link klicken. Wenn nicht, wird Ihre Nachricht an den Bundesnachrichtendienst nicht versendet.';




 