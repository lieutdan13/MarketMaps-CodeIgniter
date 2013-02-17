<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {
    const MODEL = '';
    
    public function index() {
        $this->load->library('form_validation');
        $content = $this->load->view('welcome_message', NULL, true);
        $this->render(array(
            'content' => $content,
            'pageTitle' => 'Welcome to Market Maps'
        ));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */