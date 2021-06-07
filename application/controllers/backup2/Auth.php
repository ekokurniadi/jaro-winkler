<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class Auth extends MY_Controller {	

	public function logged_in_check()
	{	
		if ($this->session->userdata("logged_in")) {
			redirect("dashboard");
		}
	}

	public function index()
	{	
		$kode = $this->input->post('captcha');
		$mycaptcha 	= $this->session->userdata('mycaptcha');
		$config_captcha = array(
			'img_path'  => './captcha/',
			'img_url'  => base_url() . 'captcha/',
			'img_width'  => '130',
			'img_height' => 30,
			'border' => 0,
			'expiration' => 7200
		);

		// create captcha image
		$cap = create_captcha($config_captcha);

		// store image html code in a variable
		$data['captchaImg'] = $cap['image'];

		// store the captcha word in a session
		$this->session->set_userdata('mycaptcha', $cap['word']);


		$this->logged_in_check();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules("username", "username", "trim|required");
		$this->form_validation->set_rules("password", "password", "trim|required");
		if ($this->form_validation->run() == true) 
		{
			$this->load->model('auth_model', 'auth');	
			// check the username & password of user
			$status = $this->auth->validate();
			if ($status == ERR_INVALID_USERNAME) {
				$this->session->set_flashdata('message', '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-animation="true" data-delay="5000" data-autohide="true" style="position: absolute; top: 0; right: 0;">
				<div class="toast-header">
					<span class="rounded mr-2 bg-danger" style="width: 15px;height: 15px"></span>
					<strong class="mr-auto">Warning</strong>
					<button type="button" class="close" data-dismiss="toast" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="toast-body">
					User tidak Valid !!!
					<br/>
					Silahkan hubungi Administrator.
				</div>
			</div>');
			}
			elseif ($status == ERR_INVALID_PASSWORD) {
				$this->session->set_flashdata('message', '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-animation="true" data-delay="5000" data-autohide="true" style="position: absolute; top: 0; right: 0;">
				<div class="toast-header">
					<span class="rounded mr-2 bg-danger" style="width: 15px;height: 15px"></span>
					<strong class="mr-auto">Warning</strong>
					<button type="button" class="close" data-dismiss="toast" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="toast-body">
					User tidak Valid !!!
					<br/>
					Silahkan hubungi Administrator.
				</div>
			</div>');
			}elseif ($kode != $mycaptcha){
				$this->session->set_flashdata('message', '
				<div class="toast" role="alert"  aria-live="assertive" aria-atomic="true" data-animation="true" data-delay="5000" data-autohide="true" style="position: absolute; top: 0; right: 0;">
				<div class="toast-header">
					<span class="rounded mr-2 bg-warning" style="width: 15px;height: 15px"></span>
					<strong class="mr-auto">Notifikasi</strong>
					<button type="button" class="close" data-dismiss="toast" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="toast-body" style="color:black;">
					Kode keamanan salah
					<br/>
					Tekan tombol re-Captcha jika kode tidak terlihat.
				</div>
			</div>');
			}
			else
			{
				// success
				// store the user data to session
				$this->session->set_userdata($this->auth->get_data());
				$this->session->set_userdata("logged_in", true);
				// redirect to dashboard
				redirect("dashboard");
			}
		}
		
		$this->load->view("auth",$data);
	}

	public function logout()
	{
		$this->session->unset_userdata("logged_in");
		$this->session->sess_destroy();
		redirect("auth");
	}

	public function forget()
	{
		$this->load->view('forget');
	}


	public function refresh(){
	    // Captcha configuration
	    $config = array(
	        'img_path'  => './captcha/',
					'img_url'  => base_url() . 'captcha/',
					'img_width'  => '130',
					'img_height' => 30,
					'border' => 0,
					'expiration' => 7200
	    );
	    $captcha = create_captcha($config);
	    
	    // Unset previous captcha and set new captcha word
	    $this->session->unset_userdata('mycaptcha');
	    $this->session->set_userdata('mycaptcha', $captcha['word']);
	    
	    // Display captcha image
	    echo $captcha['image'];
	}


}