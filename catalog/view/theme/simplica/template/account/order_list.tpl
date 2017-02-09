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
        <?php if ($orders) { ?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-right"><?php echo $column_order_id; ?></td>
                <td class="text-left"><?php echo $column_customer; ?></td>
                <td class="text-right"><?php echo $column_product; ?></td>
                <td class="text-left"><?php echo $column_status; ?></td>
                <td class="text-right"><?php echo $column_total; ?></td>
                <td class="text-left"><?php echo $column_date_added; ?></td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order) { ?>
              <tr>
                <td class="text-right">#<?php echo $order['order_id']; ?></td>
                <td class="text-left"><?php echo $order['name']; ?></td>
                <td class="text-right"><?php echo $order['products']; ?></td>
                <td class="text-left"><?php echo $order['status']; ?></td>
                <td class="text-right"><?php echo $order['total']; ?></td>
                <td class="text-left"><?php echo $order['date_added']; ?></td>
                <td class="text-right"><a href="<?php echo $order['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div class="text-right b-pagination"><?php echo $pagination; ?></div>
        <?php } else { ?>
        <p><?php echo $text_empty; ?></p>
        <?php } ?>

        <div class="buttons f-text-right">
          <a href="<?php echo $continue; ?>" class="f-button"><?php echo $button_continue; ?></a>
        </div>
      </div>
    </div>
<!-- Правая колонка. END -->

  </div>
  <div style="clear: both;"></div>
</main>

<?php echo $footer; ?>