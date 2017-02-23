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
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name">Альтернативные</label>
              <div class="col-sm-10">
              <div class="table-responsive">
                <table id="alternative" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Альтернативное название</td>
                      <td class="text-left">Магазин</td>
                      <td class="text-left">Активно</td>
                      <td class="text-right"><?php echo $entry_sort_order; ?></td>
                      <td>
                      </td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $image_row = 0; ?>
                    <?php foreach ($alternatives as $alternative) { ?>
                    <tr id="image-row<?php echo $image_row; ?>">
                      <td class="text-right"><input type="text" name="alternative[<?php echo $image_row; ?>][name]" value="<?php echo $alternative['name']; ?>" placeholder="" class="form-control" /></td>
                      
                      <td class="text-right">
                        <select name="alternative[<?php echo $image_row; ?>][shop_id]" class="form-control">
                            <option value="0">Всем</option>
                            <?php foreach ($shops as $shop) { ?>
                            <?php if ($alternative['shop_id'] == $shop['id']) { ?>
                            <option value="<?php echo $shop['id']; ?>" selected="selected"><?php echo $shop['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $shop['id']; ?>"><?php echo $shop['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                      </td>
                      
                      <td class="text-right">
                        <div class="checkbox">
                          <label>
                            <?php if ($alternative['enable'] == 1) { ?>
                              <input type="checkbox" name="alternative[<?php echo $image_row; ?>][enable]" value="1" checked="checked" />
                            <?php } else { ?>
                              <input type="checkbox" name="alternative[<?php echo $image_row; ?>][enable]" value="1" />
                            <?php } ?>
                          </label>
                        </div>
                      </td>
                      
                      <td class="text-right"><input type="text" name="alternative[<?php echo $image_row; ?>][sort]" value="<?php echo $alternative['sort']; ?>" placeholder="0" class="form-control" /></td>
                      <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="Удалить" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $image_row++; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"></td>
                      <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="Добавить" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
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
          
          <?php foreach ($languages as $language) { ?>
          <?php echo $language['name']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-meta-title"><?php echo $entry_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($description[$language['language_id']]['name']) ? $description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-meta-name<?php echo $language['language_id']; ?>" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-meta-title"><?php echo $entry_meta_title; ?></label>
              <div class="col-sm-10">
                <input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($description[$language['language_id']]['meta_title']) ? $description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-meta-title"><?php echo $entry_title_h1; ?></label>
              <div class="col-sm-10">
                <input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][title_h1]" value="<?php echo isset($description[$language['language_id']]['title_h1']) ? $description[$language['language_id']]['title_h1'] : ''; ?>" placeholder="<?php echo $entry_title_h1; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-meta-description"><?php echo $entry_meta_description; ?></label>
              <div class="col-sm-10">
                <textarea name="manufacturer_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description" class="form-control"><?php echo isset($description[$language['language_id']]['meta_description']) ? $description[$language['language_id']]['meta_description'] : ''; ?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-meta-keyword"><?php echo $entry_meta_keyword; ?></label>
              <div class="col-sm-10">
                <textarea name="manufacturer_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword" class="form-control"><?php echo isset($description[$language['language_id']]['meta_keyword']) ? $description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
              <div class="col-sm-10">
                <textarea name="manufacturer_description[<?php echo $language['language_id']; ?>][description]" rows="10" placeholder="<?php echo $entry_description; ?>" id="input-description" class="form-control"><?php echo isset($description[$language['language_id']]['description']) ? $description[$language['language_id']]['description'] : ''; ?></textarea>
              </div>
            </div>
          <?php } ?>
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

var image_row = <?php echo $image_row; ?>;

function addImage() {
  
  html  = '<tr id="image-row' + image_row + '">';
  html += '<td class="text-right"><input type="text" name="alternative[' + image_row + '][name]" value="" placeholder="" class="form-control"></td>';
  html += '<td class="text-right"> <select name="alternative[' + image_row + '][shop_id]" class="form-control"><option value="0">Всем</option>';
    <?php foreach ($shops as $shop) { ?>
      html += '<option value="<?php echo $shop['id']; ?>"><?php echo $shop['name']; ?></option>';
    <?php } ?>
  html += '</select></td>';
  html += '<td class="text-right"><div class="checkbox"><label><input type="checkbox" name="alternative[' + image_row + '][enable]" value="1"></label></div></td>';
  html += '<td class="text-right"><input type="text" name="alternative[' + image_row + '][sort]" value="0" placeholder="0" class="form-control"></td>';
  html += '<td class="text-left"><button type="button" onclick="$(\'#image-row1\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Удалить"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

	$('#alternative tbody').append(html);

	image_row++;
}
</script>
<?php echo $footer; ?>