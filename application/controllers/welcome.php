<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {
    const MODEL = '';
    
    public function index() {
        $content = $this->load->view('welcome_message', NULL, true);
        $this->render(array(
            'content' => $content,
            'pageTitle' => 'Welcome to MarktMaps'
        ));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */