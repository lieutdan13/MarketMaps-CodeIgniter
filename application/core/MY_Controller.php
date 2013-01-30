<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $layout = 'layout';
    protected $stylesheets = array(
        'app.css'
    );
    protected $javascripts = array(
        'app.js'
    );
    
    public function __construct() {
        parent::__construct();
        if (get_class() != get_class($this)) {
            if (!defined(get_class($this) . '::MODEL')) {
                show_error("Undefined " . get_class($this) . "::MODEL");
            }
            $this->load->model($this::MODEL);
        }
    }

    protected function render($view_data) {
        if (is_string($view_data)) {
            $view_data = array(
                'content' => $view_data,
            );
        }
        $view_data['stylesheets'] = $this->get_stylesheets();
        $view_data['javascripts'] = $this->get_javascripts();
        $this->load->view($this->layout, $view_data);
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
            'pageTitle' => 'List ' . $this->get_class('plural')
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
            'pageTitle' => $data[$this->get_class('lower') . '_item']['Name']
        ));
    }
}
?>
