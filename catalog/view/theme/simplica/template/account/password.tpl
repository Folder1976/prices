  <h2><?php echo $heading_title; ?></h2>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal f-forgotten-form">
    <fieldset>
      <div class="form-group f-field required f-state-required">
        <label class="control-label f-label" for="input-password">
          <span class="f-label-value"><?php echo $entry_new_password; ?></span>              
        </label>
        <div class="f-field-wrapper">
          <input type="password"
                 name="password"
                 value="<?php echo $password; ?>"
                 placeholder="<?php echo $entry_new_password; ?>"
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
          <?php if ($error_new_confirm) { ?>
          <span class="f-error_message">
            <span class="f-error_message-block js-error_input-confirm"><?php echo $error_new_confirm; ?></span>
          </span>
          <?php } ?>
        </div>
      </div>
    </fieldset>
    <div class="buttons clearfix">
      <div class="pull-left h-hidden"><a href="<?php echo $back; ?>" class="btn btn-default g-button"><?php echo $button_back; ?></a></div>
      <div class="pull-right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary g-button" />
      </div>
    </div>
  </form>


