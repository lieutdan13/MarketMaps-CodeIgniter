<div id="login">
    <div class="header">
        <span class="loginText">LOGIN HERE</span>
        <span class="orText">&mdash;<span>OR</span>&mdash;</span>
        <button class="button orange" id="registerBtn">Register</button>
    </div>

    <div id="infoMessage"><?php echo $message;?></div>

    <?php echo form_open("user/login");?>

    <?php echo form_input($identity, '', "class='input'");?>
    <?php echo form_input($password, '', "class='input'");?>
    <div class="input">
        <span for="remember" class="remember">Remember Me</span>
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
    </div>
    <?php echo form_submit(array('id' => 'submit', 'name' => 'submit'), 'Login', "class='input button orange wide'");?>

    <?php echo form_close();?>

    <?php /*<div class="forgot"><a href="forgot_password" class="subtle">Forgot your password?</a></div>*/?>
</div>