<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {
    const MODEL = '';
    
    public function index() {
        $this->data['content'] = $this->load->view('welcome_message', NULL, true);
        $this->data['title'] = 'Welcome to Market Maps';
        $this->render($this->data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */