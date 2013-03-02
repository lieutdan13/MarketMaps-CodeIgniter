<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
    const MODEL = 'Ion_auth_model';
    
    public $public_methods = array('login');
    
    function __construct() {
        parent::__construct();
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

        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('user', 'refresh');
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
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
}