<div id="register">
    <div class="header">
        <span class="registerText">REGISTER HERE</span>
        <span class="orText">&mdash;<span>OR</span>&mdash;</span>
        <button class="button orange" id="loginBtn">Login</button>
    </div>

    <div id="infoMessage"><?php echo $message;?></div>

    <?php echo form_open("user/register");?>

    <?php echo form_input($first_name, '', "class='input'");?>
    <?php echo form_input($last_name, '', "class='input'");?>
    <?php echo form_input($company, '', "class='input'");?>
    <?php echo form_input($email, '', "class='input'");?>
    <?php echo form_input($username, '', "class='input'");?>
    <?php echo form_input($password, '', "class='input'");?>
    <?php echo form_input($passconf, '', "class='input'");?>
    <?php echo form_submit(array('id' => 'submit', 'name' => 'submit'), 'Register', "class='input button orange wide'");?>

    <?php echo form_close();?>
</div>
