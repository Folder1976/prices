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
      <h1><?php echo $heading_title; ?></h1>
      <p><?php echo $text_email; ?></p>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal f-forgotten-form">
        <fieldset>
          <div class="form-group required f-field f-field-email f-state-required">
            <label class="control-label f-label" for="input-email">
              <span class="f-label-value"><?php echo $text_your_email; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input type="text"
                     name="email"
                     value="<?php //echo $email; ?>"
                     placeholder="<?php echo $entry_email; ?>"
                     id="input-email"
                     class="form-control f-email f-state-required js-state-required" />
              <span class="f-error_message">
                <span class="f-error_message-block js-error_input-email"></span>
              </span>
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default g-button"><?php echo $button_back; ?></a></div>
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary g-button" />
          </div>
        </div>
      </form>
    </div>
<!-- Правая колонка. END -->

  </div>
</main>

<?php echo $footer; ?>