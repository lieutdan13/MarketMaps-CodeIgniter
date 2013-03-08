<div id="user_view" class="middle">
    <?php if (isset($error)) {?>
        <div id="errorMessage"><?php echo $error;?></div>
    <?php } else {?>
        <div id="infoMessage"><?php echo $message;?></div>
        <div class="name"><?=$user->first_name?> <?=$user->last_name?></div>
        <div class="username"><?=$user->username?></div>
        <hr/>
        <div class="created_on">Joined on <?=date("F j, Y", $user->created_on)?></div>
        <div class="last_login">Last logged in <?=date("F j, Y", $user->last_login)?></div>
        <?php if ($can_edit) {?>
        <div id="editBtnWrap"><?php echo form_button($editBtn, '', "class='button orange'")?></div>
        <?php }
    }?>
</div>
