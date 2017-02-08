<?php echo $header; ?>

<main role="main" class="b-brand_page g-container">

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

  <div class="b-brand__content">
    
    <?php if ($categories) { ?>
    <?php foreach (array_chunk($categories, 4) as $cat) { ?>

    <div class="b-brand-row">
      <?php foreach ($cat as $category) { ?>
      <div class="b-brand-block">
        <h2><?php echo $category['name']; ?></h2>
        <ul>
          <?php foreach ($category['manufacturer'] as $manufacturer) { ?>
          <li><a href="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
    </div>

    <?php } ?>
    <?php } else { ?>
    <p><?php echo $text_empty; ?></p>
    <div class="buttons clearfix">
      <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
    </div>
    <?php } ?>
  </div>
</main>

<?php echo $footer; ?>