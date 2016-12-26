<?php echo $header; ?>


<main class="l-main_account l-main_account-edit">
  
  <div class="l-main_account-header">
    <!-- Хлебные крошки. START -->
    <ul class="b-product_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
      <?php $count = 0; ?>
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li class="b-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" <?php if ($count == 0) { echo ' style="display: none;"';} ?>>
          <a  class="b-breadcrumb-link js-breadcrumb_refinement-link" href="<?php echo $language_href; ?><?php echo $breadcrumb['href']; ?>" itemprop="item" title="<?php echo $breadcrumb['text']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
          <meta content="<?php echo $count++; ?>">
        </li>
      <?php } ?>
    </ul>
    <!-- Хлебные крошки. END -->
  </div>

  <div class="l-main_account-content">
<!-- Левая колонка. START -->
    <div class="l-main_account-left-mob-button js-toggler"
                 data-slide=".js-l-main_account-left"
                 data-toggle-class="h-minimized-main_account-left"
                 data-toggle-elem-class="h-toggled"></div>
    <div class="l-main_account-left js-l-main_account-left h-minimized-main_account-left">
      <?php echo $column_right; ?>
    </div>
<!-- Левая колонка. END -->

<!-- Правая колонка. START -->
    <div class="l-main_account-right">
      <div class="l-main_account-block">
        <h1 class="h-hidden"><?php echo $heading_title; ?></h1>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
          <fieldset>
            <div class="form-group required f-field required f-state-required">
              <div class="f-field-wrapper">
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control f-textinput" />
                <?php if ($error_lastname) { ?>
                <span class="f-error_message">
                  <span class="f-error_message-block"><?php echo $error_lastname; ?></span>
                </span>
                <?php } ?>
              </div>
              <div class="f-field-wrapper">
                <input type="text"
                       name="firstname"
                       value="<?php echo $firstname; ?>"
                       placeholder="<?php echo $entry_firstname; ?>"
                       id="input-firstname"
                       class="form-control f-textinput" />
                <?php if ($error_firstname) { ?>
                <span class="f-error_message">
                  <span class="f-error_message-block"><?php echo $error_firstname; ?></span>
                </span>
                <?php } ?>
              </div>
              <div class="f-field-wrapper">
                <input type="text" name="patronymic" value="<?php echo $patronymic; ?>" placeholder="<?php echo $entry_patronymic; ?>" id="input-patronymic" class="form-control f-textinput" />
                <?php if ($error_lastname) { ?>
                <span class="f-error_message">
                  <span class="f-error_message-block"><?php echo $error_patronymic; ?></span>
                </span>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required f-field f-state-required">
              <label class="control-label f-label" for="input-email">
                <span class="f-label-value"><?php echo $entry_email; ?></span>
              </label>
              <div class="f-field-wrapper">
                <input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control f-email" />
                <?php if ($error_email) { ?>
                <span class="f-error_message">
                  <span class="f-error_message-block"><?php echo $error_email; ?></span>
                </span>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required f-field f-state-required">
              <label class="control-label f-label" for="input-telephone">
                <span class="f-label-value"><?php echo $entry_telephone; ?></span>
              </label>
              <div class="f-field-wrapper">
                <input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control f-textinput" />
                <?php if ($error_telephone) { ?>
                <span class="f-error_message">
                  <span class="f-error_message-block"><?php echo $error_telephone; ?></span>
                </span>
                <?php } ?>
              </div>
            </div>
            <div class="form-group f-field h-hidden">
              <label class="control-label f-label-value" for="input-fax">
                <span class="f-label-value"><?php echo $entry_fax; ?></span>
              </label>
              <div class="f-field-wrapper">
                <input type="text" name="fax" value="<?php echo $fax; ?>" placeholder="<?php echo $entry_fax; ?>" id="input-fax" class="form-control f-textinput" />
              </div>
            </div>
            <?php foreach ($custom_fields as $custom_field) { ?>
            <?php if ($custom_field['location'] == 'account') { ?>
            <?php if ($custom_field['type'] == 'select') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <select name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                  <?php if (isset($account_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $account_custom_field[$custom_field['custom_field_id']]) { ?>
                  <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'radio') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div>
                  <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                  <div class="radio">
                    <?php if (isset($account_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $account_custom_field[$custom_field['custom_field_id']]) { ?>
                    <label>
                      <input type="radio" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } else { ?>
                    <label>
                      <input type="radio" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'checkbox') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div>
                  <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                  <div class="checkbox">
                    <?php if (isset($account_custom_field[$custom_field['custom_field_id']]) && in_array($custom_field_value['custom_field_value_id'], $account_custom_field[$custom_field['custom_field_id']])) { ?>
                    <label>
                      <input type="checkbox" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } else { ?>
                    <label>
                      <input type="checkbox" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                      <?php echo $custom_field_value['name']; ?></label>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'text') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'textarea') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <textarea name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?></textarea>
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'file') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <button type="button" id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                <input type="hidden" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : ''); ?>" />
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'date') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div class="input-group date">
                  <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'time') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div class="input-group time">
                  <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($custom_field['type'] == 'datetime') { ?>
            <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
              <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
              <div class="col-sm-10">
                <div class="input-group datetime">
                  <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
                <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </fieldset>
          <div class="buttons clearfix">
            <div class="pull-left h-hidden"><a href="<?php echo $back; ?>" class="btn btn-default g-button"><?php echo $button_back; ?></a></div>
            <div class="pull-right">
              <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary g-button" />
            </div>
          </div>
        </form>
      </div>
  <!-- смена пароля. START -->
      <div class="l-main_account-block">
        <div class="panel" id="block-change_password">
          <div class="panel-body"></div>
        </div>
      </div>
  <!-- смена пароля. END -->

  <!-- Адреса доставки START -->
    <div class="l-main_account-block">
      <div class="panel" id="block-address_delivery">
        <div class="panel-body"></div>
      </div>
    </div>
  <!-- Адреса доставки END -->
    </div>
<!-- Правая колонка. END -->

  </div>
</main>

<script>
// подгружаем смену пароля. START
  $(document).ready(function() {
    $.ajax({
        url: '/<?php echo $language_href; ?>index.php?route=account/password',
        dataType: 'html',
        success: function(html) {
           $('#block-change_password .panel-body').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
// подгружаем смену пароля. END

// подгружаем адреса доставки. START
  $(document).ready(function() {
    $.ajax({
        url: '/<?php echo $language_href; ?>index.php?route=account/address',
        dataType: 'html',
        success: function(html) {
           $('#block-address_delivery .panel-body').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
// подгружаем адреса доставки. END
</script>



<script type="text/javascript"><!--
// Sort the custom fields
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length) {
		$('.form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('.form-group').length) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('.form-group').length) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('.form-group').length) {
		$('.form-group:first').before(this);
	}
});
//--></script>
<script type="text/javascript"><!--
$('button[id^=\'button-custom-field\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});
//--></script>



<?php echo $footer; ?>