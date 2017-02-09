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
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>
      <div class="f-buttons">
        <a href="<?php echo $continue; ?>" class="f-button"><?php echo $button_continue; ?></a>
      </div>
    </div>
<!-- Правая колонка. END -->

  </div>
  <div style="clear: both;"></div>
</main>

<?php echo $footer; ?>