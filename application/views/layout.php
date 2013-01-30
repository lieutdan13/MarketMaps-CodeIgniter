<?php echo "<!DOCTYPE html>"?>
<html>
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
        <? foreach ($stylesheets as $stylesheet): ?>
            <?php echo css($stylesheet)?>
        <? endforeach; ?>
        <? foreach ($javascripts as $javascript): ?>
            <?php echo js($javascript)?>
        <? endforeach; ?>

    </head>
    <body>
        <div id="body">
            <div id="header">Market Maps Administration Console</div>
            <div id="title"><?php echo $pageTitle?></div>
            <div id="content">
<?php echo $content?>
            </div>
            <div id="footer">&copy; <?php echo date('Y')?> Market Maps, LLC. All rights reserved</div>
        </div>
    </body>
</html>
