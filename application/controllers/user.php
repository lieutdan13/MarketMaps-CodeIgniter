<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
    const MODEL = 'Ion_auth_model';
    
    public $public_methods = array(
        'login',
        'register',
        'register_confirm',
        'activate',
    );
    
    function __construct() {
        parent::__construct();
        $this->load->config('ion_auth', TRUE);
        $this->min_pass_length = $this->config->item('min_password_length', 'ion_auth');
        $this->max_pass_length = $this->config->item('max_password_length', 'ion_auth');
    }

    public function index($identity = NULL) {
        $identity_field = $this->config->item('identity', 'ion_auth');
        if ($identity === NULL) {
            $identity = $this->session->userdata($identity_field);
        }
        $this->data['user'] = $this->ion_auth->select('*')
                                   ->where($identity_field, $identity)
                                   ->users()
                                   ->row();
        if (empty($this->data['user'])) {
            show_404("user/edit/{$identity}");
        }
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['can_edit'] =
                $this->data['the_user']->id == $this->data['user']->id ||
                $this->ion_auth->is_admin();
        if ($this->data['can_edit']) {
            $this->data['editBtn'] = array('id' => 'editBtn',
                'content' => 'Edit',
                'onclick' => "location.href='" . site_url("user/edit/" . ($this->ion_auth->is_admin() ? $this->data['user']->username : '')) . "'"
            );
        }
        $this->data['pageTitle'] = "User View";
        $this->data['content'] = $this->load->view('user/view', $this->data, true);
        $this->render($this->data);
	}

    //log the user in
    function login() {
        if ($this->ion_auth->logged_in()) {
            redirect('/', 'refresh');
        }
        $this->data['pageTitle'] = "Login";
        $this->data['body_class'] = "login";

        if ($this->form_validation->run() == true) {
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                redirect('user', 'refresh');
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('login', 'refresh');
            }
        } else {
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = $this->session->flashdata('message');
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'placeholder' => 'Username',
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'placeholder' => 'Password',
            );
            $this->data['content'] = $this->load->view('user/login', $this->data, true);
            $this->render($this->data);
        }
    }

    public function logout() {
        // log current user out and send back to public root
        $this->ion_auth->logout();
        redirect('/');
    }

    public function register() {
        $this->data['pageTitle'] = "Register";
        $this->data['body_class'] = "register";

        $validated = $this->form_validation->run('register');
        if ($validated) {
            $username = strtolower($this->input->post('username'));
            $email    = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
            );
        }
        if ($validated === true && $this->ion_auth->register($username, $password, $email, $additional_data)) {
            //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("user/register_confirm", 'refresh');
        } else {
            //the user is not regitering in so display the register page
            $this->data['error'] = validation_errors();
            $this->data['message'] = $this->session->flashdata('message');

            $this->data['first_name'] = array('name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
                'placeholder' => 'First Name',
            );
            $this->data['last_name'] = array('name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
                'placeholder' => 'Last Name',
            );
            $this->data['company'] = array('name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
                'placeholder' => 'Company',
            );
            $this->data['email'] = array('name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
                'placeholder' => 'Email',
            );
            $this->data['username'] = array('name' => 'username',
                'id' => 'username',
                'type' => 'text',
                'value' => $this->form_validation->set_value('username'),
                'placeholder' => 'Username',
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'placeholder' => 'Password',
            );
            $this->data['passconf'] = array('name' => 'passconf',
                'id' => 'passconf',
                'type' => 'password',
                'placeholder' => 'Confirm Password',
            );
            $this->data['content'] = $this->load->view('user/register', $this->data, true);
            $this->render($this->data);
        }
    }

    function register_confirm() {
        $this->data['pageTitle'] = "Registration Confirmation";
        $this->data['body_class'] = "register_confirm";
        $this->data['content'] = $this->load->view('user/register_confirm', $this->data, true);
        $this->render($this->data);
    }

	//activate the user
	function activate($identity, $code=false) {
        $identity_field = $this->config->item('identity', 'ion_auth');
        $this->data['user'] = $this->ion_auth->select('id')
                                   ->where($identity_field, $identity)
                                   ->users()
                                   ->row();
        if (empty($this->data['user'])) {
            show_404("user/edit/{$identity}");
        }

        if ($code !== false) {
            $activation = $this->ion_auth->activate($this->data['user']->id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($this->data['user']->id);
        } else {
            $activation = FALSE;
        }

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("login", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect("login", 'refresh');
            //TODO re-enable this when forgot_password has been implemented
            //redirect("auth/forgot_password", 'refresh');
        }
    }

	//edit a user
	function edit($identity = NULL) {
		$this->data['pageTitle'] = "Edit User";
        $identity_field = $this->config->item('identity', 'ion_auth');
        if ($identity === NULL) {
            $identity = $this->session->userdata($identity_field);
        }
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		}
        $user = $this->ion_auth->select('*')
                                   ->where($identity_field, $identity)
                                   ->users()
                                   ->row();
        if (empty($user)) {
            show_404("user/edit/{$identity}");
        }
        $id = $user->id;

		//process the phone number
		if (isset($user->phone) && !empty($user->phone)) {
			$user->phone = explode('-', $user->phone);
		} else {
            $user->phone = array('', '', '');
        }

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
				show_error('This form post did not pass our security checks.');
			}

			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
			);

            $this->load->config('form_validation');
			//update the password if it was posted
			if ($this->input->post('password')) {
				$data['password'] = $this->input->post('password');
                $this->form_validation->set_rules($this->config->item('password'));
			}
			if ($this->input->post('phone1') || $this->input->post('phone2') || $this->input->post('phone3')) {
				$data['phone'] = $this->input->post('phone1') . '-' . $this->input->post('phone2') . '-' . $this->input->post('phone3');
                $this->form_validation->set_rules($this->config->item('phone'));
			} else {
                $data['phone'] = "";
            }

			if ($this->form_validation->run('user/edit') === TRUE) {
				$this->ion_auth->update($user->id, $data);

				//redirect them back to the admin page
				$this->session->set_flashdata('message', "User Saved");
				redirect("user/{$identity}", 'refresh');
			}
		}

		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
        $this->data['message'] = $this->session->flashdata('message');
		$this->data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

		//pass the user to the view
		$this->data['user'] = $user;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone1'] = array(
			'name'  => 'phone1',
			'id'    => 'phone1',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone1', $user->phone[0]),
		);
		$this->data['phone2'] = array(
			'name'  => 'phone2',
			'id'    => 'phone2',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone2', $user->phone[1]),
		);
		$this->data['phone3'] = array(
			'name'  => 'phone3',
			'id'    => 'phone3',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone3', $user->phone[2]),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['passconf'] = array(
			'name' => 'passconf',
			'id'   => 'passconf',
			'type' => 'password'
		);
        $this->data['cancelBtn'] = array('id' => 'cancelBtn',
            'content' => 'Cancel',
            'onclick' => "location.href='" . site_url("user/" . ($this->ion_auth->is_admin() ? $this->data['user']->username : '')) . "'"
        );
        $this->data['form_action'] = "user/edit/{$identity}";
        $this->data['content'] = $this->load->view('user/edit', $this->data, true);
        $this->render($this->data);
	}

}
