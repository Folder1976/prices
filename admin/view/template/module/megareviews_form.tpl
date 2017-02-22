<?php 
ini_set('display_errors',0);
error_reporting(0);?><?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-author"><?php echo $entry_author; ?></label>
            <div class="col-sm-10">
              <input type="text" name="author" value="<?php echo $author; ?>" placeholder="<?php echo $entry_author; ?>" id="input-author" class="form-control" />
              <?php if ($error_author) { ?>
              <div class="text-danger"><?php echo $error_author; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="product" value="<?php echo $product; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
              <?php if ($error_product) { ?>
              <div class="text-danger"><?php echo $error_product; ?></div>
              <?php } ?>
            </div>
          </div>
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-text"><?php echo $entry_text_plus; ?></label>
            <div class="col-sm-10">
              <textarea name="text_plus" cols="60" rows="8" placeholder="<?php echo $entry_text_plus; ?>" id="input-text_plus" class="form-control"><?php echo $text_plus; ?></textarea>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-text_minus"><?php echo $entry_text_minus; ?></label>
            <div class="col-sm-10">
              <textarea name="text_minus" cols="60" rows="8" placeholder="<?php echo $entry_text_minus; ?>" id="input-text" class="form-control"><?php echo $text_minus; ?></textarea>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-text"><?php echo $entry_text; ?></label>
            <div class="col-sm-10">
              <textarea name="text" cols="60" rows="8" placeholder="<?php echo $entry_text; ?>" id="input-text" class="form-control"><?php echo $text; ?></textarea>
              <?php if ($error_text) { ?>
              <dspan class="text-danger">
              <?php echo $error_text; ?></span>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_rating; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($rating == 1) { ?>
                <input type="radio" name="rating" value="1" checked="checked" />
                1
                <?php } else { ?>
                <input type="radio" name="rating" value="1" />
                1
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating == 2) { ?>
                <input type="radio" name="rating" value="2" checked="checked" />
                2
                <?php } else { ?>
                <input type="radio" name="rating" value="2" />
                2
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating == 3) { ?>
                <input type="radio" name="rating" value="3" checked="checked" />
                3
                <?php } else { ?>
                <input type="radio" name="rating" value="3" />
                3
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating == 4) { ?>
                <input type="radio" name="rating" value="4" checked="checked" />
                4
                <?php } else { ?>
                <input type="radio" name="rating" value="4" />
                4
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating == 5) { ?>
                <input type="radio" name="rating" value="5" checked="checked" />
                5
                <?php } else { ?>
                <input type="radio" name="rating" value="5" />
                5
                <?php } ?>
              </label>
              <?php if ($error_rating) { ?>
              <div class="text-danger"><?php echo $error_rating; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php foreach($options as $option) { if ($option['value']>-1){ ?>
          <div class="form-group ">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $option['name']; ?></label>
            <div class="col-sm-10">
              <?php for($i=0;$i<count(explode(',',$option['values']));$i++) {?>
                  <label class="radio-inline">
                    <input type="radio" name="options[<?php echo $option['option_id'];?>]" value="<?php echo $i; ?>" <?php if($option['value']==$i)echo 'checked="checked"';?> />
                    <?php $e=explode(',',$option['values']);echo $e[$i];?>
                  </label>
              <?php } ?>
              
            </div>
          </div>
          <?php }} ?>
          <?php foreach($ays as $ay) { if ($ay['value']>-1){ ?>
          <div class="form-group ">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $ay['name']; ?></label>
            <div class="col-sm-10">
              <?php for($i=0;$i<count(explode(',',$ay['values']));$i++) {?>
                  <label class="radio-inline">
                    <input type="radio" name="ays[<?php echo $ay['ay_id'];?>]" value="<?php echo $i; ?>" <?php if($ay['value']==$i)echo 'checked="checked"';?> />
                    <?php $e=explode(',',$ay['values']);echo $e[$i];?>
                  </label>
              <?php } ?>
              
            </div>
          </div>
          <?php }} ?>
          <style>.adminimage{display:inline-block;}</style>
          <div class="form-group ">
            <label class="col-sm-2 control-label" for="input-name"></label>
            <div class="col-sm-10">
              <?php foreach($files as $file) {  
                  echo"<div class='adminimage'><input type='hidden' name='files[]' value='".$file['big']."'/><img src='".$file['small']."'/><br/><a href='#' onclick='$(this).parent().remove();return false;'>".$text_remove."</a></div>";
                  
              } ?>
              
            </div>
          </div>
           <div class="form-group ">
            <label class="col-sm-2 control-label" for="input-name"></label>
            <div class="col-sm-10">
               <input name="upload[]"  type="file" multiple="" />
            </div>
          </div>
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $text_frecommend; ?></label>
            <div class="col-sm-10">
              <select name="recommend" id="input-status" class="form-control">
                <?php if ($recommend) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          
          
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
            dataType: 'json',           
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['name'],
                        value: item['product_id']
                    }
                }));
            }
        });
    },
    'select': function(item) {
        $('input[name=\'product\']').val(item['label']);
        $('input[name=\'product_id\']').val(item['value']);     
    }   
});
//--></script></div>
<?php echo $footer; ?>