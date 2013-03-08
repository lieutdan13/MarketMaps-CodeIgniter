<div id="user_edit" class="middle">
    <h2>Edit User</h2>
    <div id="errorMessage"><?php echo $error;?></div>
    <div id="infoMessage"><?php echo $message;?></div>
    <div id="left_side">
    <?php echo form_open(uri_string());?>

      <p>
            First Name: <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            Last Name: <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            Company Name: <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            Phone: <br />
            <?php echo form_input($phone1);?> - <?php echo form_input($phone2);?> - <?php echo form_input($phone3);?>
      </p>

      <p>
            Password: (if changing password)<br />
            <?php echo form_input($password);?>
      </p>

      <p>
            Confirm Password: (if changing password)<br />
            <?php echo form_input($passconf);?>
      </p>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p class="buttons">
          <?php echo form_button($cancelBtn, '', "class='button orange'")?>
          <?php echo form_submit('submit', 'Save', "class='button orange'");?>
      </p>

    <?php echo form_close();?>
    </div>
</div>