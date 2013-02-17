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
    
    private $public_page = true;
    private $viewdata = array();

    public function __construct() {
        parent::__construct();
        if (get_class() != get_class($this)) {
            if (!defined(get_class($this) . '::MODEL')) {
                show_error("Undefined " . get_class($this) . "::MODEL");
            }
            $this->load->model($this::MODEL);
        }
        $this->user = $this->ion_auth->user()->row();
        $this->viewdata['logged_in'] = $this->ion_auth->logged_in();
        if (!$this->viewdata['logged_in']) {
            if (!$this->public_page) {
                redirect('auth/login');
            }
        } else {
            $this->viewdata['user']['username'] = $this->user->username;
        }
    }

    protected function render($view_data = NULL, $render=false) {
        if (is_string($view_data)) {
            $this->viewdata['content'] = $view_data;
        } else if (is_array($view_data)) {
            $this->viewdata = array_merge($this->viewdata, $view_data);
        }
        $this->viewdata['stylesheets'] = $this->get_stylesheets();
        $this->viewdata['javascripts'] = $this->get_javascripts();
        if (!isset($view_data['script_head'])) {
            $this->viewdata['script_head'] = '';
        }
        $this->load->view($this->layout, $this->viewdata, $render);
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
