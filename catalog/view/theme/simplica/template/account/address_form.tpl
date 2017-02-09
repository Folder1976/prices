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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <fieldset>
            <div class="f-group f-required">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="input-firstname"><?php echo $entry_firstname; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="firstname"
                         value="<?php echo $firstname; ?>"
                         placeholder="<?php echo $entry_firstname; ?>"
                         id="input-firstname"
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
                  <label for="input-lastname"><?php echo $entry_lastname; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="lastname"
                         value="<?php echo $lastname; ?>"
                         placeholder="<?php echo $entry_lastname; ?>"
                         id="input-lastname"
                         class="f-input"
                         required="required"
                         pattern=".{3,}"
                         title="минимум 3 символа" />
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="input-company"><?php echo $entry_company; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="company"
                         value="<?php echo $company; ?>"
                         placeholder="<?php echo $entry_company; ?>"
                         id="input-company"
                         class="f-input" />
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="input-address-1"><?php echo $entry_address_1; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="address_1"
                         value="<?php echo $address_1; ?>"
                         placeholder="<?php echo $entry_address_1; ?>"
                         id="input-firstname"
                         class="f-input" />
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="input-address-2"><?php echo $entry_address_2; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="address_2"
                         value="<?php echo $address_2; ?>"
                         placeholder="<?php echo $entry_address_2; ?>"
                         id="input-firstname"
                         class="f-input" />
                </div>
              </div>
            </div>

            <div class="f-group f-required">
              <div class="f-field-wrapper f-required">
                <div class="f-label">
                  <label for="input-city"><?php echo $entry_city; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="city"
                         value="<?php echo $city; ?>"
                         placeholder="<?php echo $entry_city; ?>"
                         id="input-city"
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
                  <label for="input-postcode"><?php echo $entry_postcode; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="postcode"
                         value="<?php echo $postcode; ?>"
                         placeholder="<?php echo $entry_postcode; ?>"
                         id="input-postcode"
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
                  <label for="input-country"><?php echo $entry_country; ?></label>
                </div>
                <div class="f-field">
                  <select name="country_id" id="input-country" class="f-select">
                    <option value=""><?php echo $text_select; ?></option>
                    <?php foreach ($countries as $country) { ?>
                    <?php if ($country['country_id'] == $country_id) { ?>
                    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="f-group f-required">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="input-zone"><?php echo $entry_zone; ?></label>
                </div>
                <div class="f-field">
                  <select name="zone_id" id="input-zone" class="f-select">
                  </select>
                </div>
              </div>
            </div>
          </fieldset>

        <div class="buttons f-text-right">
          <input type="submit" value="<?php echo $button_continue; ?>" class="f-button" />
        </div>

        </form>
      </div>
    </div>
<!-- Правая колонка. END -->

  </div>
  <div style="clear: both;"></div>
</main>










<script type="text/javascript"><!--
// Sort the custom fields
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length-2) {
		$('.form-group').eq(parseInt($(this).attr('data-sort'))+2).before(this);
	}

	if ($(this).attr('data-sort') > $('.form-group').length-2) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('.form-group').length-2) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('.form-group').length-2) {
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
				url: '<?php echo $language_href; ?>index.php?route=tool/upload',
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
<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: '<?php echo $language_href; ?>index.php?route=account/account/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
			  		}

			  		html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<?php echo $footer; ?>
