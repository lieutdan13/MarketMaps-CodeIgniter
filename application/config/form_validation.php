<?php

$config['user/login'] = array(
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
);

$config['password'] = array(
    array(
        'field' => 'password',
        'label' => 'Password',
        'rules' => 'required|xss_clean|password_crit|matches[passconf]'
    ),
    array(
        'field' => 'passconf',
        'label' => 'Confirm Password',
        'rules' => 'required'
    )
);

$config['username'] = array(
    'field' => 'username',
    'label' => 'Username',
    'rules' => 'trim|required|xss_clean|alpha_dash|'.
               'min_length[5]|max_length[15]|strtolower|'.
               'no_reserves|is_unique[users.username]'
);

$config['email'] = array(
    'field' => 'email',
    'label' => 'Email',
    'rules' => 'trim|required|xss_clean|valid_email|strtolower|'.
                   'is_unique[users.email]'
);

$config['user/edit'] = array(
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
        'field' => 'company',
        'label' => 'Company',
        'rules' => 'trim|xss_clean',
    )
);

$config['register'] = array_merge($config['user/edit'], $config['password']);
$config['register'][] = $config['username'];
$config['register'][] = $config['email'];

$config['phone'] = array(
    array(
        'field' => 'phone1',
        'label' => 'First Part of Phone',
        'rules' => 'trim|required|xss_clean|min_length[3]|max_length[3]',
    ),
    array(
        'field' => 'phone2',
        'label' => 'Second Part of Phone',
        'rules' => 'trim|required|xss_clean|min_length[3]|max_length[3]',
    ),
    array(
        'field' => 'phone3',
        'label' => 'Third Part of Phone',
        'rules' => 'trim|required|xss_clean|min_length[4]|max_length[4]',
    ),
);
?>
