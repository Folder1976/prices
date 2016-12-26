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
    <div class="l-main_account-left">
      <?php echo $column_right; ?>
    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-main_account-right">
      <h1><?php echo $heading_title; ?></h1>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal f-forgotten-form">
        <fieldset>
          <div class="form-group f-field required f-state-required">
            <label class="control-label f-label" for="input-password">
              <span class="f-label-value"><?php echo $entry_password; ?></span>              
            </label>
            <div class="f-field-wrapper">
              <input type="password"
                     name="password"
                     value="<?php echo $password; ?>"
                     placeholder="<?php echo $entry_password; ?>"
                     id="input-password"
                     class="form-control f-password" />
              <?php if ($error_password) { ?>
              <span class="f-error_message">
                <span class="f-error_message-block js-error_input-password"><?php echo $error_password; ?></span>
              </span>
              <?php } ?>
            </div>
          </div>
          <div class="form-group f-field required f-state-required">
            <label class="control-label f-label" for="input-confirm">
              <span class="f-label-value"><?php echo $entry_confirm; ?></span>
            </label>
            <div class="f-field-wrapper">
              <input type="password"
                     name="confirm"
                     value="<?php echo $confirm; ?>"
                     placeholder="<?php echo $entry_confirm; ?>"
                     id="input-confirm"
                     class="form-control f-password" />
              <?php if ($error_confirm) { ?>
              <span class="f-error_message">
                <span class="f-error_message-block js-error_input-confirm"><?php echo $error_confirm; ?></span>
              </span>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php } ?>
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