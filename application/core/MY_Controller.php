<?php
class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (get_class() != get_class($this)) {
            if (!defined(get_class($this) . '::MODEL')) {
                show_error("Undefined " . get_class($this) . "::MODEL");
            }
            $this->load->model($this::MODEL);
        }
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
	$data['title'] = 'List ' . $this->get_class('plural');

	$this->load->view('templates/header', $data);
	$this->load->view($this->get_class('lower') . '/index', $data);
	$this->load->view('templates/footer');
    }

    public function view($slug) {
        $data[$this->get_class('lower') . '_item'] = $this->{$this::MODEL}->get_data($slug);

	if (empty($data[$this->get_class('lower') . '_item']))
	{
		show_404();
	}

	$data['title'] = $data[$this->get_class('lower') . '_item']['Name'];

	$this->load->view('templates/header', $data);
	$this->load->view($this->get_class('lower') . '/view', $data);
	$this->load->view('templates/footer');
    }
}
?>
