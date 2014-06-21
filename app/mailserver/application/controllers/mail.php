<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Controller {

	/**
	 * Validates the JSON input given via POST and creates a Message entry in 
	 * the database. 
	 *
	 * Sends a verification Link E-Mail.
	 */
	public function index () {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$isValid = false; // is the posted content valid?
			$isSaved = false; // is the Message saved in the Database
			$message = ''; // construct the message

			/** Read JSON from Angular */
			/** http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
			/** Hack: http://ellislab.com/forums/viewthread/238080/ */
			$postdata = file_get_contents("php://input");
			/* Save JSON data in $_POST for CodeIgniter form_validation */
			$_POST = json_decode($postdata, true);
			
			/* VALIDATE FORM DATA */
			$this->load->library('form_validation');
			$this->config->load('mail');
			$this->form_validation->set_rules($this->config->item('mail_validation_rules'));
			$isValid = $this->form_validation->run();

			/* IF VALID CREATE MESSAGE */
			if ($isValid) {
				$this->load->model('Message');
				$isSaved = $this->Message->create(
					$this->input->post('mailaddress'), 
					$this->input->post('mailsubject'),
					$this->input->post('emailtext')
				);
			}

			$this->_output_header();

			if ($isValid && $isSaved) {
				/* SEND VERIFICATION MAIL */
				$this->Message->send_verification_mail();
				
				$this->output->set_status_header('200');
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => 'Message saved to Database')));
			} else {
				$this->output->set_status_header('400');
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => 'Formdata invalid')));
			}
		} 
	}

	/**
	 * Verifies the E-mail-Adress by searching for the $token in the database
	 * @param  [String] $token Verification token
	 */
	public function verify ($token) {
		
		$data = array();
		$this->load->config('mail');
		$this->load->model('Message');
		$success = $this->Message->verify($token);

		if ($success) {
			$data['message'] = $this->config->item('mail_verify_success');
		} else {
			$data['message'] = $this->config->item('mail_verify_fail');
		}

		$this->load->view('verify', $data);
	}

	/**
	 * Outputs HTTP Headers 
	 */
	private function _output_header () {
		
		/** set header */
		header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
		header('Access-Control-Allow-Headers: accept, origin, x-requested-with, content-type');
		header('Access-Control-Allow-Methods: POST, OPTIONS');
	}

}

/* End of file mail.php */
/* Location: ./application/controllers/mail.php */