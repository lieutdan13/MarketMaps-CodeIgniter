<?php
class MY_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        if (get_class() != get_class($this)) {
            if (!defined(get_class($this) . '::TABLE')) {
                show_error("Undefined " . get_class($this) . "::TABLE");
            }
            if (!defined(get_class($this) . '::ID_FIELD')) {
                show_error("Undefined " . get_class($this) . "::ID_FIELD");
            }
        }
        $this->load->database();
    }
    
    public function get_data($Id = FALSE) {
        if ($Id === FALSE) {
            $query = $this->db->get($this::TABLE);
            return $query->result_array();
        }
	$query = $this->db->get_where($this::TABLE, array($this::ID_FIELD => $Id));
        return $query->row_array();
    }
}
?>
