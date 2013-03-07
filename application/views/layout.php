<?php echo "<!DOCTYPE html>"?>
<html class="no-js">
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
        <meta name="viewport" content="width=device-width" />
        <title><?php echo $pageTitle?></title>
        <!--[if IE 9]>
        <style type="text/css"> .gradient { filter: none;} </style>
        <![endif]-->
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<?
        foreach ($stylesheets as $stylesheet): ?>
        <?php echo css($stylesheet);
        endforeach;
        echo jquery('1.9.1');
        foreach ($javascripts as $javascript): ?>
        <?php echo js($javascript);
        endforeach;?>
        <script type="text/javascript">
            (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)
            <?php echo $script_head;?>
        </script>
    </head>
    <body class="<?php if (isset($body_class)) { echo $body_class; }?>">
        <div id="body">
            <div id="body_header"></div>
            <div id="body_inner">
                <div id="header">
                    <img src="/assets/images/marker.svg" id="logo" alt="Market Maps Logo" />
                    <div id="auth_links">
                    <?php if ($logged_in) { ?>
                         <span class="welcome">Welcome <?=$the_user->username?>!</span>
                         <a href="<?php echo base_url() . "logout"?>">Logout</a>
                    <?php } else { ?>
                         <a href="<?php echo base_url() . "login"?>">Login</a>
                    <?php } ?>
                    </div>
                </div>
                <div id="content">
    <?php echo $content?>
                </div>
                <div id="footer">
                    Page rendered in <strong>{elapsed_time}</strong> seconds<br/>
                    &copy; <?php echo date('Y')?> Market Maps, LLC. All rights reserved
                </div>
            </div>
        </div>
        <?php //echo "<pre>" . print_r($GLOBALS, true) . "</pre>";?>
    </body>
</html>
