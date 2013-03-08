<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('debugOut')) {

    /**
     * Outputs a variable and exits if desired.
     * @param mixed $var
     * @param boolean $exit
     */
    function debugOut($var = NULL, $exit=true) {
        if ($var === NULL) { $var = $GLOBALS; }
        echo "<pre>" . print_r($var, true) . "</pre>";
        if ($exit) { exit; }
    }

}