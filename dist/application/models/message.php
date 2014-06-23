<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Model {
  var $recipient  = '';
  var $sender     = '';
  var $subject    = '';
  var $text       = '';
  var $time_created = null; // timestamp in seconds
  var $time_sent  = null; // timestamp in seconds
  var $verify_token = '';
  var $is_sent = false;
  var $is_encrypted = false;

  function __construct() {
    parent::__construct();
    $this->load->config('mail');
    $this->load->config('encryption');
    $this->load->library('encrypt');
    $this->load->database();
  }

  /** 
   * Creates a Message in the database
   * @param  [String] $sender    Email address from
   * @param  [String] $subject   Subject of the message
   * @param  [String] $text      Body text
   * @param  [String] $recipient Email address to 
   * @return [Boolean]           True, if database insertion was successful
   */
  public function create ($sender, $subject, $text, $recipient = null) {
    
    /* recipient is optional */
    if ($recipient === null) {
      $recipient = $this->config->item('mail_recipient');
    } 

    /* encrypt message and metadata */
    $this->is_encrypted = true;
    $this->recipient =  $this->encrypt->encode($recipient);
    $this->sender =     $this->encrypt->encode($sender);
    $this->subject =    $this->encrypt->encode($subject);
    $this->text =       $this->encrypt->encode($text);   
    
    $this->time_created = time();
    $this->verify_token = strtr(base64_encode(openssl_random_pseudo_bytes(16)), "+/=", "XXX");

    return $this->db->insert('messages', $this);

  }

  /**
   * Sends a verification link to the senders email
   * @return [Boolean] True, if mail was dispatched
   */
  public function send_verification_mail () {

    $this->load->helper('url');
    $this->load->library('email');
    
    $mail_admin = $this->config->item('mail_admin');
    $url = site_url('mail/verify/' . $this->verify_token);
    $message = $this->config->item('mail_verify_mailtext');

    $this->email->from($mail_admin);
    $this->email->to($this->sender);
    $this->email->subject('Verifizieren Sie Ihre E-Mail-Adresse');
    $this->email->message($message . "\r\n\r\n" . $url . "\r\n\r\n" . $this->text);
    
    return $this->email->send();

  }

  /**
   * Verifies the given $token as a valid token in the database and sends the associated mail, if successful
   * @param  [String] $token Token to be validated from the verification mail
   * @return [Bolean] True, if token could be verified and message was sent
   */
  public function verify ($token) {

    $query = $this->db->get_where('messages', array('verify_token' => $token, 'is_sent' => false));

    foreach ($query->result() as $row) {
      $this->recipient = $row->recipient;
      $this->sender = $row->sender;
      $this->subject = $row->subject;
      $this->text = $row->text;
      $this->is_encrypted = $row->is_encrypted;
      $this->verify_token = $row->verify_token;
      if ($this->_send()) {
        return true;
      }
    }
    return false;
  }

  /**
   * Sends the Message
   * @return [Boolean] True, if the Message was sent.
   */
  private function _send () {

    $this->load->library('email');
    
    /* decode, if message was encrypted */
    if ($this->is_encrypted) {
      $from     = $this->encrypt->decode($this->sender);
      $to       = $this->encrypt->decode($this->recipient);
      $subject  = $this->encrypt->decode($this->subject);
      $message  = $this->encrypt->decode($this->text);
    } else {
      $from =     $this->sender;
      $to =       $this->recipient;
      $subject =  $this->subject;
      $message =  $this->message;
    }

    /* prepare mail */
    $this->email->from($from);
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($message);

    if ($this->email->send()) {
      $this->db->where('verify_token', $this->verify_token);
      // update time and delete subject + message
      $this->db->update('messages', array('time_sent' => time(), 'is_sent' => true, 'text' => '', 'subject' => ''));
      return true;
    } else {
      return false;
    }

  }

}

/* End of file message.php */
/* Location: ./application/controllers/message.php */