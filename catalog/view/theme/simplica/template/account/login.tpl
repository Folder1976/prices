<?php echo $header; ?>

<main class="l-main_account g-container">
  
  <div class="l-main_account__header">
    <!-- Хлебные крошки. START -->
    <div class="b-breadcrumb">
    <?php $count = 0; ?>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php if ($count == 0) { ?>
        <a href="<?php echo $breadcrumb['href']; ?>" title=""><span class="ic-home"></span><?php echo $breadcrumb['text']; ?></a>
      <?php } else { ?>
        <span>&nbsp;>&nbsp;</span><a href="<?php echo $breadcrumb['href']; ?>" title="<?php echo $breadcrumb['text']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
    <?php $count++;} ?>
    </div>
    <!-- Хлебные крошки. END -->
  </div>

  <div class="l-main_account__content">
<!-- Левая колонка. START -->
    <div class="l-main_account__left">
      <?php echo $column_right; ?>
    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-main_account__right">
      <div class="b-account-form">
        <h2 class="b-account-form__title"><?php echo $text_returning_customer; ?></h2>
        <p><?php echo $text_i_am_returning_customer; ?></p>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

          <?php if ( isset($error_warning) && $error_warning != ''  ) { ?>
            <div class="f-alert f-alert_error"><?php echo $error_warning; ?></div>
          <?php } ?>

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="input-email"><?php echo $entry_email; ?></label>
              </div>
              <div class="f-field">
                <input type="email"
                       name="email"
                       value="<?php echo $email; ?>"
                       placeholder="<?php echo $entry_email; ?>"
                       id="input-email"
                       class="f-input"
                       required="required"
                       pattern=".{3,}"
                       title="минимум 3 символа" />
              </div>
            </div>
          </div>

          <div class="f-group f-required">
            <div class="f-field-wrapper">
              <div class="f-label">
                <label for="input-password"><?php echo $entry_password; ?></label>
              </div>
              <div class="f-field">
                <input type="password"
                       name="password"
                       value="<?php echo $password; ?>"
                       placeholder="<?php echo $entry_password; ?>"
                       id="input-password"
                       class="f-input"
                       required="required"
                       pattern=".{3,}"
                       title="минимум 3 символа" />
              </div>
            </div>
            <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
          </div>

          <div class="f-group f-text-right">
            <input type="submit" value="<?php echo $button_login; ?>" class="f-button" />
          </div>

          <?php if ($redirect) { ?>
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          <?php } ?>

        </form>
      </div>

      <div class="b-account-registration">
        <h2 class="b-account-form__title"><?php echo $text_new_customer; ?></h2>
        <p><?php echo $text_register; ?></p>
        <p><?php echo $text_register_account; ?></p>
        <a href="<?php echo $register; ?>" class="f-button"><?php echo $button_continue; ?></a>
      </div>

    </div>
<!-- Правая колонка. END -->

  </div>
  <div style="clear: both;"></div>
</main>

<?php echo $footer; ?>