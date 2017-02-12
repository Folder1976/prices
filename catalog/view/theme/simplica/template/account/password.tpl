<div class="b-account-form">
  <h2><?php echo $heading_title; ?></h2>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <fieldset>

      <div class="f-group f-required">
        <div class="f-field-wrapper">
          <div class="f-label">
            <label for="input-password"><?php echo $entry_password; ?></label>
          </div>
          <div class="f-field">
            <input type="password"
                   name="password"
                   value="<?php echo $password; ?>"
                   placeholder="<?php echo $entry_password; ?>"
                   id="input-password"
                   class="f-input"
                   required="required"
                   pattern=".{3,}"
                   title="минимум 3 символа" />
          </div>
        </div>
      </div>

      <div class="f-group f-required">
        <div class="f-field-wrapper">
          <div class="f-label">
            <label for="input-confirm"><?php echo $entry_confirm; ?></label>
          </div>
          <div class="f-field">
            <input type="password"
                   name="confirm"
                   value="<?php echo $confirm; ?>"
                   placeholder="<?php echo $entry_confirm; ?>"
                   id="input-confirm"
                   class="f-input"
                   required="required"
                   pattern=".{3,}"
                   title="минимум 3 символа" />
          </div>
        </div>
      </div>

      
    </fieldset>

    <div class="buttons f-text-right">
      <a href="<?php echo $back; ?>" class="f-button"><?php echo $button_back; ?></a>
      <input type="submit" value="<?php echo $button_continue; ?>" class="f-button" />
    </div>

  </form>
</div>