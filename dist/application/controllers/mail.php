<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Controller {

	/**
	 * Validates the JSON input given via POST and creates a Message entry in 
	 * the database. 
	 *
	 * Sends a verification Link E-Mail.
	 */
	public function create ($respondType = 'html') {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$isValid = false; // is the posted content valid?
			$isSaved = false; // is the Message saved in the Database
			$data['respond'] = 'Formulardaten unvollständig, ungültig oder ein Duplikat.'; // construct the message
			$data['success'] = false;
			$data['status'] = 400;
			
			/* VALIDATE FORM DATA */
			$this->load->database(); // Database needed for checking unique email
			$this->load->library('form_validation');
			$this->config->load('mail');
			$this->form_validation->set_rules($this->config->item('mail_validation_rules'));
			$isValid = $this->form_validation->run();

			/* IF VALID CREATE MESSAGE */
			if ($isValid) {
				$data['respond'] = 'Formulardaten gültig, aber die Nachricht wurde nicht gespeichert und keine E-Mail gesendet.';
				$data['status'] = 500;
				
				// format message
				$this->load->model('Message');
				$this->load->model('Form');
				$fields = array(
					'text' => $this->input->post('text'),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'), 
					'domain' => $this->input->post('domain')
				);
				$message = $this->Form->create_message_body($fields);
				
				// Save message to database
				$isSaved = $this->Message->create(
					$this->input->post('email'), 
					$this->input->post('subject'),
					$message
				);
			}


			/* SEND VERIFICATION MAIL */
			if ($isValid && $isSaved) {
				$data['respond'] = 'Nachricht gespeichert, aber es wurde keine E-Mail zur Verfikation gesendet. Bitte wenden Sie sich an admin@ueberwacht-mich-nicht.de';
				
				if ($this->Message->send_verification_mail()) {
					$data['respond'] = 'Nachricht gespeichert. Sie wird erst versendet, wenn Sie Ihre E-Mail-Adresse verifizieren. Bitte klicken Sie auf den Link in der E-Mail, die wir Ihnen gesendet haben.';
					$data['success'] = true;
					$data['status'] = 200;
				}
			}

			switch ($respondType) {
				case 'json':
					$this->_output_header();
					$this->output->set_status_header($data['status']);
					$this->output->set_content_type('application/json')->set_output(
						json_encode(array('success' => $data['success'], 'message' => $data['respond']))
					);
					break;
				default: 
					$this->load->view('respond', $data);
			}

		} else { // if not POST -> send 403 (forbidden)
			$this->output->set_status_header(403);
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
		$data['success'] = $this->Message->verify($token);

		if ($data['success']) {
			$data['respond'] = $this->config->item('mail_verify_success');
		} else {
			$data['respond'] = $this->config->item('mail_verify_fail');
		}

		$this->load->view('respond', $data);
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

	public function email_check ($email) {
		$this->load->model('Message');
		return $this->Message->check_unique_email($email);
	}

}

/* End of file mail.php */
/* Location: ./application/controllers/mail.php */