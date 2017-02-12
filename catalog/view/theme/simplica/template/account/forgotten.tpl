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
        <h1><?php echo $heading_title; ?></h1>
        <p><?php echo $text_email; ?></p>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <fieldset>
            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="input-email"><?php echo $text_your_email; ?></label>
                </div>
                <div class="f-field">
                  <input type="email"
                         name="email"
                         value=""
                         placeholder="<?php echo $entry_email; ?>"
                         id="input-email"
                         class="f-input"
                         required="required"
                         pattern=".{3,}"
                         title="минимум 3 символа" />
                </div>
              </div>
            </div>
          </fieldset>
          <div class="buttons">
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