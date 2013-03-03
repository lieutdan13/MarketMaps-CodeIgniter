<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('debugOut')) {

    /**
     * Outputs a variable and exits if desired.
     * @param mixed $var
     * @param boolean $exit
     */
    function debugOut($var, $exit=true) {
        echo "<pre>" . print_r($var, true) . "</pre>";
        if ($exit) { exit; }
    }

}