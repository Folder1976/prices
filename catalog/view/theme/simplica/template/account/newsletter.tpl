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

  <?php
  // топ-меню для авторизированых пользователей
  if ($logged) { echo $content_top; }
  ?>

  <div class="l-main_account__content">
<!-- Левая колонка. START -->
    <div class="l-main_account__left">
      <?php echo $column_right; ?>
    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-main_account__right">
      <div class="b-account-form">
        <h1><?php echo $heading_title; ?></h1>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
          <fieldset>
            <div class="form-group f-field">
            <label class="control-label f-label">
              <span class="f-label-value"><?php echo $entry_newsletter; ?></span>
            </label>
            <div class="f-field-wrapper">
              <?php if ($newsletter) { ?>
              <label class="radio-inline f-label">
                <input type="radio" name="newsletter" value="1" checked="checked" />
                <?php echo $text_yes; ?> </label>
              <label class="radio-inline f-label">
                <input type="radio" name="newsletter" value="0" />
                <?php echo $text_no; ?></label>
              <?php } else { ?>
              <label class="radio-inline f-label">
                <input type="radio" name="newsletter" value="1" />
                <?php echo $text_yes; ?> </label>
              <label class="radio-inline f-label">
                <input type="radio" name="newsletter" value="0" checked="checked" />
                <?php echo $text_no; ?></label>
              <?php } ?>
            </div>
          </div>
          </fieldset>

          <div class="buttons f-text-right">
            <a href="<?php echo $back; ?>" class="f-button"><?php echo $button_back; ?></a>
            <input type="submit" value="<?php echo $button_continue; ?>" class="f-button" />
          </div>

        </form>
      </div>
    </div>
<!-- Правая колонка. END -->

  </div>
  <div style="clear: both;"></div>
</main>

<?php echo $footer; ?>