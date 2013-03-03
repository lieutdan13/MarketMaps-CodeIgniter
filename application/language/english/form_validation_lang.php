<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include (BASEPATH . 'language/english/form_validation_lang.php');

$lang['is_unique']          = "The %s is already in use.";
$lang['matches']            = "The passwords do not match.";
$lang['no_reserves']        = "The %s cannot be one of our reserved words";
$lang['no_reserve_admin']   = "The %s cannot contain the word \"admin\"";
$lang['no_reserve_mm']      = "The %s cannot contain the word \"MarketMaps\"";
$lang['password_crit']      = "The password must be between 6 and 20 characters ".
                              "and contain at least 1 number, ".
                              "1 capital letter, and 1 lowercase letter";

?>
