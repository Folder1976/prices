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
      <h1 class="h-hidden"><?php echo $heading_title; ?></h1>
      <div class="b-account-form">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

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
                <label for="input-patronymic"><?php echo $entry_patronymic; ?></label>
              </div>
              <div class="f-field">
                <input type="text"
                       name="patronymic"
                       value="<?php echo $patronymic; ?>"
                       placeholder="<?php echo $entry_patronymic; ?>"
                       id="input-patronymic"
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
                <label for="input-email"><?php echo $entry_email; ?></label>
              </div>
              <div class="f-field">
                <input type="email"
                       name="email"
                       value="<?php echo $email; ?>"
                       placeholder="<?php echo $entry_email; ?>"
                       id="input-email"
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
                  <label for="input-telephone"><?php echo $entry_telephone; ?></label>
                </div>
                <div class="f-field">
                  <input type="tel"
                         name="telephone"
                         value="<?php echo $telephone; ?>"
                         placeholder="<?php echo $entry_telephone; ?>"
                         id="input-telephone"
                         class="f-input"
                         required="required"
                         pattern="[0-9]{3,}"
                         title="минимум 3 символа (0-9)" />
                </div>
              </div>
            </div>

            <div class="f-group">
              <div class="f-field-wrapper">
                <div class="f-label">
                  <label for="input-fax"><?php echo $entry_fax; ?></label>
                </div>
                <div class="f-field">
                  <input type="text"
                         name="fax"
                         value="<?php echo $fax; ?>"
                         placeholder="<?php echo $entry_fax; ?>"
                         id="input-fax"
                         class="f-input" />
                </div>
              </div>
            </div>

            <div class="f-buttons">
              <div class="f-group f-text-right">
                <a href="<?php echo $back; ?>" class="f-button"><?php echo $button_back; ?></a>
                <input type="submit" value="<?php echo $button_continue; ?>" class="f-button" />
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
  <div style="clear: both;"></div>
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