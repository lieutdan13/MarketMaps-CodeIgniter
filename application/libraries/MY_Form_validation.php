<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    function __construct($rules = array()) {
        parent::__construct($rules);
    }

    function no_reserves($str) {
        if ($this->regex_match($str, "/admin/i")) {
            $this->set_message('no_reserves', $this->CI->lang->language['no_reserve_admin']);
            return FALSE;
        } else if ($this->regex_match($str, "/marketmaps/i")) {
            $this->set_message('no_reserves', $this->CI->lang->language['no_reserve_mm']);
            return FALSE;
        }
        return TRUE;
    }
}
?>
