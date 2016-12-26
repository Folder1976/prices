<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-manufacturer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <div class="checkbox">
                  <label>
                    <?php if (in_array(0, $manufacturer_store)) { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php foreach ($stores as $store) { ?>
                <div class="checkbox">
                  <label>
                    <?php if (in_array($store['store_id'], $manufacturer_store)) { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-code"><span data-toggle="tooltip" title="<?php echo $help_code; ?>"><?php echo $entry_code; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="code" value="<?php echo $code; ?>" placeholder="<?php echo $entry_code; ?>" id="input-code" class="form-control" />
              <?php if ($error_code) { ?>
              <div class="text-danger"><?php echo $error_code; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
              <?php if ($error_keyword) { ?>
              <div class="text-danger"><?php echo $error_keyword; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-10"> <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-meta-title"><?php echo $entry_meta_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="manufacturer_description[meta_title]" value="<?php echo isset($meta_title) ? $meta_title : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-meta-title"><?php echo $entry_title_h1; ?></label>
            <div class="col-sm-10">
              <input type="text" name="manufacturer_description[title_h1]" value="<?php echo isset($title_h1) ? $title_h1 : ''; ?>" placeholder="<?php echo $entry_title_h1; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-meta-description"><?php echo $entry_meta_description; ?></label>
            <div class="col-sm-10">
              <textarea name="manufacturer_description[meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description" class="form-control"><?php echo isset($meta_description) ? $meta_description : ''; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-meta-keyword"><?php echo $entry_meta_keyword; ?></label>
            <div class="col-sm-10">
              <textarea name="manufacturer_description[meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword" class="form-control"><?php echo isset($meta_keyword) ? $meta_keyword : ''; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
            <div class="col-sm-10">
              <textarea name="manufacturer_description[description]" rows="10" placeholder="<?php echo $entry_description; ?>" id="input-description" class="form-control"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
          </div>

<!-- Поля для склонений -->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-sush"><?php echo $entry_name_sush; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name_sush" value="<?php echo isset($name_sush) ? $name_sush : ''; ?>" placeholder="@block_name@ " id="input-name-sush" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-rod"><?php echo $entry_name_rod; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name_rod" value="<?php echo isset($name_rod) ? $name_rod : ''; ?>" placeholder="@block_name_rod@" id="input-name-rod" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name-several"><?php echo $entry_name_several; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name_several" value="<?php echo isset($name_several) ? $name_several : ''; ?>" placeholder="@block_name_several@" id="input-name-several" class="form-control" />
            </div>
          </div>
<!-- end Поля для склонений -->
          
        </form>
         <ul>Памятка по кодам
            <li>* <b>@min_price@</b> - Минимальная цена</li>
            <li>* <b>@products_count@</b> - Количество продуктов</li>
            <li>* <b>@shops_count@</b> - Количество магазинов</li>
            <li>* <b>@design_count@</b> - Количество дизайнеров</li>
            <li>* <b>@prev_year@</b> - Предыдущий год</li>
            <li>* <b>@now_year@</b> - Текущий год</li>
            <li>* <b>@next_year@</b> - Следующий год</li>
            <li>* <b>@dinamic_year@</b> - Динамический диапазон 2016-2016</li>
            <li>* <b>@city@</b> - Город [именительный] (<i>Москва</i>)</li>
            <li>* <b>@sity_to@</b> - Город [дательный] (<i>В Москву</i>)</li>
            <li>* <b>@city_on@</b> - Город [предложный](<i>По Москве</i>)</li>
            <li>* <b>@city_rod@</b> - Город [родительный](<i>Чего? Москвы</i>)</li>
            <li></li>
            <li>* <b>@block_name@</b> - Существительный (<i>белая блузка</i>)</li>
            <li>* <b>@block_name_rod@</b> - Родительный (<i>белую блузку</i>)</li>
            <li>* <b>@block_name_several@</b> - Множина (<i>белые блузки</i>)</li>
          </ul>
           
      </div>
    </div>
  </div>
</div>
<script>
  $('#input-description').summernote({
	height: 300
});
</script>
<?php echo $footer; ?>