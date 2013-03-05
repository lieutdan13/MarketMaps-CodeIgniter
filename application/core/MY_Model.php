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
        $this->load->helper('string');
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

    /**
     * Generates a unique hashed id for a database field
     * @param mixed $var
     * @param boolean $exit
     */
    public function get_unique_hash($table, $field, $len = 6) {
        $hash_id = strtolower(random_string('alnum', $len));
        $query = $this->db->get_where($table, array("{$table}.{$field}='{$hash_id}'"));
        $result = $query->row_array();
        if (count($result)) {
            return $this->get_unique_hash($table, $field, $len);
        } else {
            return $hash_id;
        }
    }
}
?>
