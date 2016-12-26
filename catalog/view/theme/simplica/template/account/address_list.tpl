
      <?php if ($success) { ?>
      <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
      <?php } ?>
      <?php if ($error_warning) { ?>
      <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
      <?php } ?>

      <h2><?php echo $text_address_delivery; ?>:</h2>
      <?php if ($addresses) { ?>
      <div class="table-addresses">
        <?php $count_addres = 0; ?>
        <?php foreach ($addresses as $result) { ?>
        <div class="table-addresses_row">
          <div class="table-addresses_count"><?php echo $text_address.' '.++$count_addres; ?></div>
          <div class="table-addresses_result">
            <span class="table-addresses_result-title"><?php echo $text_country; ?></span>
            <span class="table-addresses_result-value"><?php echo $result['array']['country']; ?></span>
            
            <span class="table-addresses_result-title"><?php echo $text_city; ?></span>
            <span class="table-addresses_result-value"><?php echo $result['array']['city']; ?></span>
            
            <span class="table-addresses_result-title"><?php echo $text_postcode; ?></span>
            <span class="table-addresses_result-value"><?php echo $result['array']['postcode']; ?></span>
            
            <span class="table-addresses_result-title"><?php echo $text_address_1; ?></span>
            <span class="table-addresses_result-value"><?php echo $result['array']['address_1']; ?></span>
          </div>
          <div class="table-addresses_edit"><a href="<?php echo $result['update']; ?>" class="btn btn-info"><?php echo $button_edit; ?></a></div>
          <div class="table-addresses_remove"><a href="<?php echo $result['delete']; ?>" class="btn btn-danger"><?php echo $button_delete; ?></a></div>
        </div>
        <?php } ?>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-left h-hidden"><a href="<?php echo $back; ?>" class="btn btn-default g-button"><?php echo $button_back; ?></a></div>
        <div class="pull-right"><a href="<?php echo $add; ?>" class="btn btn-primary g-button"><?php echo $button_new_address; ?></a></div>
      </div>
