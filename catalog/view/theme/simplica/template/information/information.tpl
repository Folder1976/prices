<?php echo $header; ?>

<main role="main" class="l-main-information g-container">

  <div class="l-main-information__header">
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

  <div class="l-main-information__top" style="display: none;">
    <div class="html-slot-container b-slot--customer-service-top">
      <div class="b-customer_service-sub_header" style="padding-left:31%">
        <div class="b-customer_service-sub_header-sub_title">
          <div class="b-customer_service-sub_header-right">
            <div class="b-customer_service-sub_header-title"><?php echo $text_write_to_us; ?></div>
            <div class="b-customer_service-sub_header-sub_title"><?php echo $text_customer_service; ?></div>
            <a class="b-customer_service-sub_header-link" href="index.php?route=information/contact"><?php echo $email; ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="l-main-information__content">

    <div class="b-customer_service_navigation-mob-button js-toggler"
         data-slide=".js-l-customer_service-left"
         data-toggle-class="h-minimized-customer_service-left"
         data-toggle-elem-class="h-toggled"></div>
    <div class="l-main-information__left js-l-customer_service-left h-minimized-customer_service-left">
      <div class="b-customer-service-navigation">
        <?php echo $leftmenu; ?>
      </div>
    </div>

    <div class="l-main-information__right">
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $description; ?>
    </div>


  </div>
</main>

<?php echo $footer; ?>
