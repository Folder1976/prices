<?php echo $header; ?>

<main class="l-main_account">
  
  <div class="l-main_account-header">
    <!-- Хлебные крошки. START -->
    <ul class="b-product_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
      <?php $count = 0; ?>
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li class="b-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" <?php if ($count == 0) { echo ' style="display: none;"';} ?>>
          <a  class="b-breadcrumb-link js-breadcrumb_refinement-link" href="<?php echo $breadcrumb['href']; ?>" itemprop="item" title="<?php echo $breadcrumb['text']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
          <meta content="<?php echo $count++; ?>">
        </li>
      <?php } ?>
    </ul>
    <!-- Хлебные крошки. END -->
  </div>

  <div class="l-main_account-content">
<!-- Левая колонка. START -->
    <div class="l-main_account-left-mob-button js-toggler"
                 data-slide=".js-l-main_account-left"
                 data-toggle-class="h-minimized-main_account-left"
                 data-toggle-elem-class="h-toggled"></div>
    <div class="l-main_account-left js-l-main_account-left h-minimized-main_account-left">
      <?php echo $column_right; ?>
    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-main_account-right">
      <div class="b-account-login-form">
        <h2 class="b-account-login-form-title"><?php echo $text_returning_customer; ?></h2>
        <p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <div class="form-group f-field f-field-email f-state-required">
            <label class="control-label f-label" for="input-email">
              <span class="f-label-value"><?php echo $entry_email; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input type="text"
                     name="email"
                     value="<?php echo $email; ?>"
                     placeholder="<?php echo $entry_email; ?>"
                     id="input-email"
                     class="form-control f-email f-state-required js-state-required" />
              <span class="f-error_message">
                <span class="f-error_message-block js-error_input-email"></span>
              </span>
            </div>
          </div>
          <div class="form-group f-field f-field-password f-state-required">
            <label class="control-label f-label" for="input-password">
              <span class="f-label-value"><?php echo $entry_password; ?></span>              
            </label>
            <div class="f-field-wrapper">
              <input type="password"
                     name="password"
                     value="<?php echo $password; ?>"
                     placeholder="<?php echo $entry_password; ?>"
                     id="input-password"
                     class="form-control f-password f-state-required js-state-required" />
              <span class="f-error_message">
                <span class="f-error_message-block js-error_input-password"></span>
              </span>
              <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
            </div>
          <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary g-button" />
          <?php if ($redirect) { ?>
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          <?php } ?>
        </form>
      </div>

      <div class="b-account-registration">
        <h2 class="b-account-login-form-title"><?php echo $text_new_customer; ?></h2>
        <p><strong><?php echo $text_register; ?></strong></p>
        <p><?php echo $text_register_account; ?></p>
        <a href="<?php echo $register; ?>" class="btn btn-primary g-button"><?php echo $button_continue; ?></a>
      </div>

    </div>
<!-- Правая колонка. END -->

  </div>
  <div style="clear: both;"></div>
</main>

<?php echo $footer; ?>