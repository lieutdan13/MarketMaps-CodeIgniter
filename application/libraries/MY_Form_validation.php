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

    function password_crit($str) {
        if (
            !$this->regex_match($str, '/[a-z]/') ||
            !$this->regex_match($str, '/[A-Z]/') ||
            !$this->regex_match($str, '/[0-9]/') ||
            mb_strlen($str) < $this->CI->min_pass_length ||
            mb_strlen($str) > $this->CI->max_pass_length
        ) {
            return FALSE;
        }
        return TRUE;
    }
}
?>
