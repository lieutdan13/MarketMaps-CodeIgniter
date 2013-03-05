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

    public function index() {
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

        if ($this->form_validation->run('login') == true) {
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('user', 'refresh');
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

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
    
    public function view() {
        redirect('user/');
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
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

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
	function activate($id, $code=false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("login", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("login", 'refresh');
            //TODO re-enable this when forgot_password has been implemented
            //redirect("auth/forgot_password", 'refresh');
        }
    }
}