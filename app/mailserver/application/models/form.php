<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->config->load('mail');
    }
    
    /**
     * Concatenates given fields in a String, based on the config
     * @param  [Array] $post_fields Fields given by a $_POST variable
     * @return [String]             Returns message String
     */
    public function create_message_body ($post_fields)
    {
        /** message */
        $message = '';
        $message_fields = $this->config->item('mail_message_fields');
        

        /** add each field from request to the message */
        foreach ($message_fields as $post_key => $message_field_name) {
            $message .= $message_field_name . $post_fields[$post_key] . "\r\n";
        }

        return $message;
    }

}

/* End of file form.php */
/* Location: ./application/models/form.php */