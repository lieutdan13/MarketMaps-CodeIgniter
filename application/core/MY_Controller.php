<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $layout = 'layout';
    protected $stylesheets = array(
        'app.css',
    );
    protected $javascripts = array(
        '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js',
        'app.js',
    );
    public $public_methods = array();
    
    public $data = array();
    private $the_user;

    public function __construct() {
        parent::__construct();
        if (get_class() != get_class($this)) {
            if (!defined(get_class($this) . '::MODEL')) {
                show_error("Undefined " . get_class($this) . "::MODEL");
            }
            $this->load->model($this::MODEL);
        }

        $logged_in = $this->ion_auth->logged_in();
        if (!$logged_in) {
            if (!in_array($this->router->method, $this->public_methods)) {
                // send back to the login
                redirect('login');
            }
        }
        // get the user object
        $this->data['the_user'] = $this->ion_auth->user()->row();
        $this->data['logged_in'] = $logged_in;
        // put the user object in class wide property
        $this->the_user = $this->data['the_user'];

        // load $the_user in all displayed views automatically
        $this->load->vars($this->data);
    }

    protected function render($view_data = NULL, $render=false) {
        if (is_string($view_data)) {
            $this->data['content'] = $view_data;
        } else if (is_array($view_data)) {
            $this->data = array_merge($this->data, $view_data);
        }
        $this->data['stylesheets'] = $this->get_stylesheets();
        $this->data['javascripts'] = $this->get_javascripts();
        if (!isset($view_data['script_head'])) {
            $this->data['script_head'] = '';
        }
        $this->load->view($this->layout, $this->data, $render);
    }

    protected function get_stylesheets() {
        return $this->stylesheets;
    }

    protected function get_javascripts() {
        return $this->javascripts;
    }
    
    public function get_class($options = array()) {
        if (!is_array($options)) {
            $options = array($options => true);
        }
        $class = get_class($this);
        if (isset($options['plural'])) {
            $class = $class . 's';
        }
        if (isset($options['lower'])) {
            $class = strtolower($class);
        }
        return $class;
    }

    public function index() {
        $data[$this->get_class(array('plural'=>true, 'lower'=>true))] = $this->{$this::MODEL}->get_data();

        $content = $this->load->view($this->get_class('lower') . '/index', $data, true);
        $this->render(array(
            'content' => $content,
            'title' => 'List ' . $this->get_class('plural')
        ));
    }

    public function view($slug) {
        $data[$this->get_class('lower') . '_item'] = $this->{$this::MODEL}->get_data($slug);

        if (empty($data[$this->get_class('lower') . '_item'])) {
            show_404();
        }

        $content = $this->load->view($this->get_class('lower') . '/view', $data, true);
        $this->render(array(
            'content' => $content,
            'title' => $data[$this->get_class('lower') . '_item']['Name']
        ));
    }


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
?>
