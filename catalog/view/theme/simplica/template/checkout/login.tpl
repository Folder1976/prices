<div class="js-checkout_login_button">
  <div class="b-checkout_login-title">
    <p>Войдите в аккаунт для ускорения процесса оформления заказа.</p>
  </div>
  <div class="b-checkout_login-button">
    <button class="g-button js_show_block"
            data-show-block=".js-checkout_login_container"
            data-hide-block=".js-checkout_login_button"
            onclick="return false"><span>ВОЙТИ</span></button>
  </div>
</div>
<div class="js-checkout_login_container h-hidden">
  <div class="b-checkout_login-title">
    <p>Если Вы зарегистрированный пользователь, пожалуйста, введите Ваш адрес элетронной почты и пароль.</p>
  </div>

  <div class="form-group f-field f-field-email">
    <label class="control-label f-label" for="input-email"><span class="f-label-value"><?php echo $entry_email; ?></span></label>
    <div class="f-field-wrapper">
      <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control f-email" />
    </div>
  </div>
  <div class="form-group f-field f-field-password">
    <label class="control-label f-label" for="input-password"><span class="f-label-value"><?php echo $entry_password; ?></span></label>
    <div class="f-field-wrapper">
      <input type="password" name="password" value="" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control f-password" />
    </div>
    <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
  </div>
  <input type="button"
         value="<?php echo $button_login; ?>"
         id="button-login"
         data-loading-text="<?php echo $text_loading; ?>"
         class="btn btn-primary b-login_account-login_button" />


</div>

<!-- <div class="row">

  <div class="col-sm-6">
    <h2><?php echo $text_new_customer; ?></h2>
    <p><?php echo $text_checkout; ?></p>
    <div class="radio">
      <label>
        <?php if ($account == 'register') { ?>
        <input type="radio" name="account" value="register" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="account" value="register" />
        <?php } ?>
        <?php echo $text_register; ?></label>
    </div>
    <?php if ($checkout_guest) { ?>
    <div class="radio">
      <label>
        <?php if ($account == 'guest') { ?>
        <input type="radio" name="account" value="guest" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="account" value="guest" />
        <?php } ?>
        <?php echo $text_guest; ?></label>
    </div>
    <?php } ?>
    <p><?php echo $text_register_account; ?></p>
    <input type="button" value="<?php echo $button_continue; ?>" id="button-account" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
  
</div> -->

<script>
$(document).ready(function() {
  $('.js_show_block').on('click', function(){
      $($(this).data('show-block')).removeClass('h-hidden');
      $($(this).data('hide-block')).addClass('h-hidden');
  });
});
</script>