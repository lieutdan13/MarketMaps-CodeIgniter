<?php

$config = array(
    'login' => array(
        array(
            'field' => 'identity',
            'label' => 'Identity',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|xss_clean'
        ),
    ),
    'register' => array(
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|xss_clean|alpha_dash|'.
                       'min_length[5]|max_length[15]|strtolower|'.
                       'no_reserves|is_unique[users.username]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|xss_clean|valid_email|strtolower|'.
                       'is_unique[users.email]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|xss_clean|password_crit|matches[passconf]'
        ),
        array(
            'field' => 'passconf',
            'label' => 'Confirm Password',
            'rules' => 'required'
        ),
    )
);


?>
