<?php echo $header; ?>

<main role="main" class="b-brand_page g-container">


<pre><?php //var_dump($categories); ?></pre>



  <div class="b-brand_content">
    
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