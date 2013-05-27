<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['mailtype'] = 'html';
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";

if (is_file(APPPATH . "config/email.local.php")) {
    include(APPPATH . "config/email.local.php");
}
