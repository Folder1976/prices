<?php
?>

<!--script src="../js/editor/redactor.js"></script-->
<input type="hidden" class="product_id" value="<?php echo $_GET['id']; ?>">
<input type="hidden" class="products" value="<?php echo $_GET['products']; ?>">
<!--script type="text/javascript" src="/js/common.js"></script-->
<!-- elFinder CSS (REQUIRED) -->
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/css/elfinder.full.css">
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/css/theme.css">


 <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<!-- elFinder JS (REQUIRED) -->
<script src="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/js/elfinder.min.js"></script>
<!-- elFinder translation (OPTIONAL) -->
<script src="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/js/i18n/elfinder.ru.js"></script>
<!-- elFinder initialization (REQUIRED) -->
<script type="text/javascript" charset="utf-8">
	/*
	$(document).ready(function() {
		$('#main_text_textarea_menu').elfinder({
			url : '../js/elFinder-master/php/connector.minimal.php'  // connector URL (REQUIRED)
			// , lang: 'ru'                    // language (OPTIONAL)
		});
	});*/
</script>
	
<div class='moduletitle'>Модерация товаров</div>
<div style="max-width: 1375px;">
<div class="table_body">
	
	<!-- Заголовок -->
	
	<div class="top_header">
		<h1 style="margin-bottom: 10px;" class="header">Товар: Название товара</h1>
		<div style="width: 150px;float: left;">Название : </div><input type="text" class="product_names product_name" value="" style="width: 600px;">
		<br>
		<br><div style="width: 150px;float: left;">Полное название : </div><input type="text" class="product_names product_full_name" value="" style="width: 600px;">

		<div class="prices cost">Зак. <br><label>0.00</label></div>
		<div class="prices real_cost">Цена <br><label>0.00</label></div>
		<div class="prices old_cost">Old <br><label>0.00</label></div>

	</div>
	<div style="clear: both;"></div>
	<style>
		.prices{
			width: 100px;
			/*height: 30px;*/
			font-size: 16px;
			display: block;
			border: 1px solid;
			padding: 5px;
			text-align: right;
			position: relative;
			float: left;
			margin-top: -25px;
			margin-left: 10px;
		}
		.cost{
			/*margin-left: 800px;*/
			border-color: #FF0000;
		}
		.old_cost{
			/*margin-left: 950px;*/
			border-color: #0037FF;
		}
		.real_cost{
			/*margin-left: 1100px;*/
			border-color: #54FF00;
		}
		.product_names{
			float: left;
			display: block;
		}
		
	</style>
	
	<div class="navigation">
		
		<!-- Выбор магазинов и тд -->
		<div class="top_select">
		
			<div class="select_top shop">
				<label class="select_lable">Магазин</label>
				<select class="select" id="shop">
					<option value="0">Выбрать...</option>
				</select>
			</div>
			<div class="select_top brand">
				<label class="select_lable">Бренд</label>
				<select class="select" id="brand">
					<option value="0">Выбрать...</option>
				</select>
			</div>
			<div class="select_top category">
				<label class="select_lable">Раздел</label>
				<select class="select" id="category">
					<option value="0">Выбрать...</option>
				</select>
			</div>
			<div class="select_top podcategory">
				<label class="select_lable">Подраздел</label>
				<select class="select" id="podcategory">
					<option label="Выбор..." value="">Выбор...</option>
				</select>
			</div>
			
		</div>
		
		<div class="top_key">
			<!-- Кнопка Ссыслка к нам -->
			<!--div class="top_key" style="width: 120px;height: 62px;"-->
				<a href="#" class="link_in" target="_blank"><button class="key_link" style="color:blue;height: 40px;">У нас на сайте</button></a>
			<!--/div-->
			
			<!-- Кнопка Ссылка к ним -->
			<!--div class="top_key" style="width: 120px;height: 62px;"-->
				<br><a href="#" class="link_out" target="_blank"><button class="key_link" style="color:green;height: 40px;margin-top: 10px;">У них на сайте</button></a>
			<!--/div-->
		</div>
			
		<!-- Кнопка Брак -->
		<div class="top_key top_brack_blok">
			<button class="key_brack">Брак</button>
		</div>
		
		<!-- Кнопка Модерация -->
		<div class="top_key top_moderation_blok">
			<button class="key_moderation">Модерация</button>
		</div>
		
		<!-- Кнопка На сайт -->
		<div class="top_key top_online_blok">
			<button class="key_online">На сайт</button>
		</div>


	

<style>
	/*Кнопка сохранить */		
	.top_key{
		border: 1px solid #b7ddf2;
		padding: 10px 10px 0 10px;
		float: left;
		margin-left: 10px;
		height: 102px;
	}
	.top_key button{
		width: 110px;
		height: 92px;
		font-size: 14px;
		font-weight: bold;
	}
	.key_brack{
		color: #FF0000;
	}
	.key_moderation{
		color: #C48900;
	}
	.key_online{
		color: #00720B;
	}
</style>

		
		<!-- Кнопки переходов -->
		<div class="top_prev_key">
				<a href="javascript:" class="prev">&#11013;</a>
		</div>
		<div class="top_next_key">
				<a href="javascript:" class="next">&#11013;</a>
		</div>
		
	
		<div style="clear: both"></div>	
		
	</div>


	<!-- Основной блок -->
	<div class="navigation" style="margin-top: 15px;"><!--
		
		--><div class="main_block_1">
			<div class="main_1"><!--
				--><div class="main_header">Картинки и категории :</div><!--
				--><div class="main_photo" >
					<img id="image_front" src="/<?php echo TMP_DIR; ?>image/placeholder.png" style="max-height: 300px; max-width: 255px;">
				
				</div>
				<div style="clear: both"></div>
				
				<div class="photos">
					<img id="image_back" width="80px" src="/<?php echo TMP_DIR; ?>image/no_image.png">
				</div>
				<div class="photos">
					<img id="image_middle" width="80px" src="/<?php echo TMP_DIR; ?>image/no_image.png">
				</div>
				<div class="photos">
					<img id="image_other" width="80px" src="/<?php echo TMP_DIR; ?>image/no_image.png">
				</div>
				<div style="clear: both"></div>
			</div>
		</div>
	
<!-- Вкладки фильтров -->
		<div class="main_block_2"><!--
			--><div class="main_2"><!--
				--><div class="main_header">Фильтры-Характеристики :</div><!--
				--><div class="tabs">
					<ul class="tab-links" id="filters_tabs">
						<li class="active"><a href="#tab1">Tab #1</a></li>
						<li><a href="#tab2">Tab #2</a></li>
					</ul>
				 
					<div class="tab-content" id="tab_content">
						<div id="tab1" class="tab active">
							<p>Tab #1 content goes here!</p>
							<p>Donec pulvinar </p>
						</div>
					</div>
				</div>	
				
			</div>
		</div><!--
Описание
		--><div class="main_block_3"><!--
			--><div class="main_3">
				<!--div class="main_text">Описание :</div-->
				<!--textarea class="main_text_textarea">Описание :</textarea-->
				<!--textarea  cols='100' rows='80' name='info_memo_1' >1111 cols=62 rows=30  </textarea-->
				
				<button class="save_text" style="color:green;width: 150px;height: 30px;">Сохранить описание</button>
				
				<textarea style="width: 480px; height: 500px;" id="main_text_textarea" class="product_names main_text_textarea" name="tovaropis">
					Описание
				</textarea>
				<div id="main_text_textarea_menu"></div>
			</div>
		</div><!--
	--><div style="clear: both"></div><!--
	--></div>	
	

</div>
</div>
</div>
<div style="clear: both"></div>


<script>
	
//=================================================================================
   
 	//Смена БРАК
	jQuery(document).on('click', '.key_brack', function(){
		jQuery('.key_brack').css('color','white');
		jQuery('.key_brack').css('background-color','#FF0000');
		
		jQuery('.key_moderation').css('color','#C48900');
		jQuery('.key_moderation').css('background-color','rgb(221,221,221)');
		
		jQuery('.key_online').css('color','#00720B');
		jQuery('.key_online').css('background-color','rgb(221,221,221)');
		
		set_status(2);
	});
	//Смена МОДЕРАЦИЯ
	jQuery(document).on('click', '.key_moderation', function(){
		jQuery('.key_brack').css('color','#FF0000');
		jQuery('.key_brack').css('background-color','rgb(221,221,221)');
		
		jQuery('.key_moderation').css('color','white');
		jQuery('.key_moderation').css('background-color','#C48900');
		
		jQuery('.key_online').css('color','#00720B');
		jQuery('.key_online').css('background-color','rgb(221,221,221)');
		
		set_status(1);
	});
	//Смена НА САЙТ
	jQuery(document).on('click', '.key_online', function(){
		jQuery('.key_brack').css('color','#FF0000');
		jQuery('.key_brack').css('background-color','rgb(221,221,221)');
		
		jQuery('.key_moderation').css('color','#C48900');
		jQuery('.key_moderation').css('background-color','rgb(221,221,221)');
		
		jQuery('.key_online').css('color','white');
		jQuery('.key_online').css('background-color','#00720B');
		
		set_status(0);
	});
	
	function set_status(id) {
        var product_id = jQuery('.product_id').val();
		
		jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_moderated_product.php",
			dataType: "text",
			data: "product_id="+product_id+"&status_id="+id+"&key=save_status",
			beforeSend: function(){
				
			},
			success: function(msg){
			
				//console.log( msg );
				
			}
		});
    }

//=========================================================================				 
	jQuery(document).on('click', '.save_text', function(){
		jQuery('.product_names').trigger('change');
	});
	jQuery(document).on('change', '.product_names', function(){
		var product_name = jQuery('.product_name').val();
		var product_full_name = jQuery('.product_full_name').val();
		var text = tinyMCE.get('main_text_textarea').getContent();//jQuery('#main_text_textarea').val();
		var product_id = jQuery('.product_id').val();
		
		text = text.replace('<!DOCTYPE html>','');
		text = text.replace('<html>','');
		text = text.replace('<head>','');
		text = text.replace('</head>','');
		text = text.replace('<body>','');
		text = text.replace('</body>','');
		text = text.replace('</html>','');
		
		console.log( text );
		
		jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_moderated_product.php",
			dataType: "text",
			data: "product_id="+product_id+"&text="+text+"&product_name="+product_name+"&product_full_name="+product_full_name+"&key=save_names",
			beforeSend: function(){
				
			},
			success: function(msg){
				console.log( msg );
			}
		});
	})
	
	//Смена Фильтра
	jQuery(document).on('change', '.filters', function(){
		var product_id = jQuery('.product_id').val();
		var filter_id = jQuery(this).attr('id');
		
		var check = 0;
		if (jQuery(this).prop('checked')) {
             check = 1;
        }
      
	  jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_moderated_product.php",
			dataType: "text",
			data: "product_id="+product_id+"&filter_id="+filter_id+"&check="+check+"&key=save_filter",
			beforeSend: function(){
				
			},
			success: function(msg){
			
				//console.log( msg );
				
			}
		});
	})
	
	//Смена магазина
	jQuery(document).on('change', '#shop', function(){
		var product_id = jQuery('.product_id').val();
		var shop_id = jQuery(this).val();
		
		jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_moderated_product.php",
			dataType: "text",
			data: "product_id="+product_id+"&shop_id="+shop_id+"&key=save_magazin",
			beforeSend: function(){
				
			},
			success: function(msg){
			
				//console.log( msg );
				
			}
		});
	})
	//Смена бренда
	jQuery(document).on('change', '#brand', function(){
		var product_id = jQuery('.product_id').val();
		var brand_id = jQuery(this).val();
		
		jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_moderated_product.php",
			dataType: "text",
			data: "product_id="+product_id+"&brand_id="+brand_id+"&key=save_brand",
			beforeSend: function(){
				
			},
			success: function(msg){
			
				//console.log( msg );
				
			}
		});
	})
	
	//Смена Категории
	jQuery(document).on('change', '#category', function(){
		var product_id = jQuery('.product_id').val();
		var category_id = jQuery(this).val();
		
		jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_moderated_product.php",
			dataType: "text",
			data: "product_id="+product_id+"&category_id="+category_id+"&key=save_category",
			beforeSend: function(){
				
			},
			success: function(msg){
			
				//console.log( msg );
				
			}
		});
	})
	
	//Смена ПОДКатегории
	jQuery(document).on('change', '#podcategory', function(){
		var product_id = jQuery('.product_id').val();
		var podcategory_id = jQuery(this).val();
		
		jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_moderated_product.php",
			dataType: "text",
			data: "product_id="+product_id+"&podcategory_id="+podcategory_id+"&key=save_podcategory",
			beforeSend: function(){
				
			},
			success: function(msg){
			
				//console.log( msg );
				//location.reload();
				get_product(jQuery('.product_id').val());
			}
		});
	})

	jQuery.urlParam = function(name){
		//var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		//return results[1] || 0;
	}
	
    jQuery(document).ready(function() {
	
	
		jQuery(document).on('click', '.tabs .tab-links a', function(e)  {
			var currentAttrValue = jQuery(this).attr('href');
	 
			// Show/Hide Tabs
			jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
	 
			// Change/remove current tab to active
			jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	 
			e.preventDefault();
		});
		
		  //jQuery('.product_id').val(jQuery.urlParam('id'));
        
	
		console.log('product_id = '+jQuery('.product_id').val());
		
		get_product(jQuery('.product_id').val());//jQuery('.product_id').val());
	});
	

	//Переходы вперед-назад
	jQuery(document).on('click', '.prev', function(){
		var products = jQuery('.products').val().split(',');
		var id = jQuery('.product_id').val();
		
		jQuery.each(products, function(index, value){
			if(id == value){
				
				if (index >= 1) {
                    jQuery('.product_id').val(products[index - 1]);
					location = '/<?php echo TMP_DIR; ?>backend_new/index.php?route=moderation&id='+products[index - 1]+'&products=<?php echo $_GET['products']; ?>';
					//console.log(jQuery('.product_id').val());
					//get_product(products[index - 1]);
                }else{
					console.log('Начало массива');
				}
				
			}
		});
	});
	jQuery(document).on('click', '.next', function(){
		var products = jQuery('.products').val().split(',');
		var id = jQuery('.product_id').val();
		
		jQuery.each(products, function(index, value){
			if(id == value){
				
				if (products.length > index + 1) {
                    jQuery('.product_id').val(products[index + 1]);
					location = '/<?php echo TMP_DIR; ?>backend_new/index.php?route=moderation&id='+products[index + 1]+'&products=<?php echo $_GET['products']; ?>';
					//console.log(jQuery('.product_id').val());
					//get_product(products[index + 1]);
                }else{
					console.log('Конец массива');
				}
				
			}
		});
	});
	
	//Перечитать подкатегории по выборе категории
	jQuery(document).on('change', '#category', function(){
		var id = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_get_moderated_product.php",
			dataType: "json",
			data: "id="+id+"&key=get_podcategory",
			beforeSend: function(){
			},
			success: function(msg){
				console.log( msg );
			
				//подкатегория
				jQuery("#podcategory").empty();
				
				jQuery.each(msg.podcategory, function( index, value ) {
					jQuery("#podcategory").append( '<optgroup label="'+value.name+'">');
						jQuery.each(value.options, function( index2, value2 ) {
							jQuery("#podcategory").append( '<option value="'+index2+'" select>'+value2+'</option>');
						});
					jQuery("#podcategory").append( '</optgroup>');
				});
				jQuery("#podcategory [value='"+msg.podcategory_id+"']").attr("selected", "selected");
					
			}
		});
		
	});
	
	//Основная функция загрузки информации поп родукту
	function get_product(id) {
	console.log('11111111111');	
        jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_get_moderated_product.php",
			dataType: "text",
			data: "id="+id+"&key=get_product",
			beforeSend: function(){
			},
			success: function(msg){
				console.log( msg );
				
				//Линки
				jQuery('.link_in').attr('href','/product/view/'+msg.url);
				jQuery('.link_out').attr('href',msg.origin_url);
				
				//Имя
				jQuery('.header').html('Товар : '+msg.name+' ('+msg.full_name+')');
				jQuery('.product_name').val(msg.name);
				jQuery('.product_full_name').val(msg.full_name);
				
				jQuery('.cost label').html(msg.cost);
				jQuery('.real_cost label').html(msg.real_cost);
				jQuery('.old_cost label').html(msg.old_cost);
				
				//Описание
				console.log(msg.text);
				tinyMCE.get('main_text_textarea').setContent(msg.text);
				//tinyMCE.execCommand('mceInsertContent', false, msg.text);
				//jQuery('#main_text_textarea').setContent(msg.text);
				//jQuery('#main_text_textarea').html(msg.text);
				//jQuery('#main_text_textarea').redactor();

				
				//Магазин
				jQuery("#shop").empty();
				jQuery.each(msg.shop, function( index, value ) {
					jQuery("#shop").append( '<option value="'+index+'" select>'+value+'</option>');
				});
				jQuery("#shop [value='"+msg.shop_id+"']").attr("selected", "selected");
				
				//Магазин
				jQuery("#brand").empty();
				jQuery.each(msg.brand, function( index, value ) {
					jQuery("#brand").append( '<option value="'+index+'" select>'+value+'</option>');
				});
				jQuery("#brand [value='"+msg.brand_id+"']").attr("selected", "selected");
				
				//категория
				jQuery("#category").empty();
				jQuery.each(msg.category, function( index, value ) {
					//console.log(index+' '+value);
					jQuery("#category").append( '<option value="'+index+'" select>'+value+'</option>');
				});
				jQuery("#category [value='"+msg.category_id+"']").attr("selected", "selected");
				
				//подкатегория
				jQuery("#podcategory").empty();
				jQuery.each(msg.podcategory, function( index, value ) {
					jQuery("#podcategory").append( '<option value="0" select>выбрать. . .</option>');
					jQuery("#podcategory").append( '<optgroup label="'+value.name+'">');
						jQuery.each(value.options, function( index2, value2 ) {
							jQuery("#podcategory").append( '<option value="'+index2+'" select>'+value2+'</option>');
						});
					jQuery("#podcategory").append( '</optgroup>');
				});
				jQuery("#podcategory [value='"+msg.podcategory_id+"']").attr("selected", "selected");
				
				//jQuery('#podcategory').trigger('change');
				
				//Картинки
				jQuery("#image_front").prop('src', '/upload/product/large_front_'+msg.image_front);
				
				if (msg.image_back == '') {
					jQuery("#image_back").prop('src', '/img/images.png');
				}else{
					jQuery("#image_back").prop('src', '/upload/product/thumb_back_'+msg.image_back);
				}
				
				if (msg.image_middle == '') {
					jQuery("#image_middle").prop('src', '/img/images.png');
				}else{
					jQuery("#image_middle").prop('src', '/upload/product/thumb_middle_'+msg.image_middle);
				}
				if (msg.image_other == '') {
                    jQuery("#image_other").prop('src', '/img/images.png');
                }else{
					jQuery("#image_other").prop('src', '/upload/product/thumb_other_'+msg.image_middle);
				}
				
				//Статус
				if (msg.is_hidden == 2) {
					jQuery('.key_brack').css('color','white');
					jQuery('.key_brack').css('background-color','#FF0000');
					
					jQuery('.key_moderation').css('color','#C48900');
					jQuery('.key_moderation').css('background-color','rgb(221,221,221)');
					
					jQuery('.key_online').css('color','#00720B');
					jQuery('.key_online').css('background-color','rgb(221,221,221)');
				}else if (msg.is_hidden == 1) {
				//Смена МОДЕРАЦИЯ
					jQuery('.key_brack').css('color','#FF0000');
					jQuery('.key_brack').css('background-color','rgb(221,221,221)');
					
					jQuery('.key_moderation').css('color','white');
					jQuery('.key_moderation').css('background-color','#C48900');
					
					jQuery('.key_online').css('color','#00720B');
					jQuery('.key_online').css('background-color','rgb(221,221,221)');
				}else if (msg.is_hidden == 0) {
				//Смена НА САЙТ
					jQuery('.key_brack').css('color','#FF0000');
					jQuery('.key_brack').css('background-color','rgb(221,221,221)');
					
					jQuery('.key_moderation').css('color','#C48900');
					jQuery('.key_moderation').css('background-color','rgb(221,221,221)');
					
					jQuery('.key_online').css('color','white');
					jQuery('.key_online').css('background-color','#00720B');
				}
				
				//Фильтры
				jQuery("#filters_tabs").empty();
				jQuery("#tab_content").empty();
				var count = 1;
				var tmp = '';
			
				jQuery(".header").append(' [');
				jQuery.each(msg.size, function( index, value ) {
					jQuery(".header").append(value+', ');
				});
				jQuery(".header").append(']');
			
			
				jQuery.each(msg.filters, function( index, value ) {
					tmp = '';
					//Добавляем закладки
					if (count == 1) {
                        jQuery("#filters_tabs").append( '<li class="active"><a href="#tab'+count+'"><input type="checkbox" href="javascript:;" class="all_filter_group">'+index+'</a></li>');
                    }else{
						jQuery("#filters_tabs").append( '<li><a href="#tab'+count+'">'+index+'</a></li>');
					}
					
					//Добавляем контент закладки
					if (count == 1) {
                        tmp = tmp + '<div id="tab'+count+'" class="tab active">';
                    }else{
						tmp = tmp + '<div id="tab'+count+'" class="tab">';
					}
						
					jQuery.each(value, function( index1, value1 ) {
						if (value1['isset'] == 1) {
                            tmp = tmp + '<input type="checkbox" class="filters" name="'+value1.filtername+'_'+index1+'" id="'+value1.filtername+'_'+index1+'" checked>'+value1['name']+'<br>';
                        }else{
							tmp = tmp + '<input type="checkbox" class="filters" name="'+value1.filtername+'_'+index1+'" id="'+value1.filtername+'_'+index1+'">'+value1['name']+'<br>';
						}
						
					});
					tmp = tmp + '</div>';
					
					jQuery("#tab_content").append( tmp );
					
					count = count + 1;
						
				});
				
					
			}
		});
    }
	
	  function elFinderBrowser (field_name, url, type, win) {
            
			tinymce.activeEditor.windowManager.open({
              file: '/<?php echo TMP_DIR; ?>admin/elFinder-master/elfinder.html',// use an absolute path!
              title: 'elFinder 2.0',
              width: 900,  
              height: 450,
              resizable: 'yes'
            }, {
              setUrl: function (url) {
                win.document.getElementById(field_name).value = 'elFinder-master/'+url;
              }
            });
            return false;
    }
  
            
  
	tinymce.init({
			selector: "textarea",
			height: 500,
            file_browser_callback : elFinderBrowser,
			plugins: [
			  "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
			  "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			  "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
			],
		  
			toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
			toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
			//toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",
		  
			menubar: false,
			toolbar_items_size: 'small',
		  
			style_formats: [{
			  title: 'Bold text',
			  inline: 'b'
			}, {
			  title: 'Red text',
			  inline: 'span',
			  styles: {
				color: '#ff0000'
			  }
			}, {
			  title: 'Red header',
			  block: 'h1',
			  styles: {
				color: '#ff0000'
			  }
			}, {
			  title: 'Example 1',
			  inline: 'span',
			  classes: 'example1'
			}, {
			  title: 'Example 2',
			  inline: 'span',
			  classes: 'example2'
			}, {
			  title: 'Table styles'
			}, {
			  title: 'Table row 1',
			  selector: 'tr',
			  classes: 'tablerow1'
			}],
		  
			templates: [{
			  title: 'Test template 1',
			  content: 'Test 1'
			}, {
			  title: 'Test template 2',
			  content: 'Test 2'
			}],
			content_css: [
			  '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
			  '//www.tinymce.com/css/codepen.min.css'
			]
	});
  
</script>
<style>
	.top_header{
		display: block;
		text-align: left;
		padding: 10px;
		border: 2px solid #b7ddf2;
		background-color: #fff;
		margin-bottom: 15px;
		height: 80px;
	}
	
/*Верхний блок*/
	.navigation{
		display: block;
		text-align: left;
		padding: 10px;
		border: 2px solid #b7ddf2;
		background-color: #fff;
	}
/*Выбор магазинов и подкатегорий */
	.top_select{
		border: 1px solid #b7ddf2;
		width:405px;
		/*height: 132px;*/
		padding-top: 5px;
		float: left;
	}
	select{
		font-size: 12px;
		padding: 2px 2px;
		border: solid 1px #aacfe4;
		width: 300px;
		margin: 2px 0 10px 10px;
	}
	label.select_lable{
		font-size: 12px;
		font-weight: bold;
		padding: 2px 2px;
		width: 70px;
		margin: 2px 0 10px 10px;
		display: block;
		float: left;
	}
/*Кнопки обновить и перейти */	
	.top_nav_blok{
		border: 1px solid #b7ddf2;
		padding: 10px 10px 0 10px;
		float: left;
		margin-left: 10px;
		height: 102px;
	}
	.top_nav_key_blok button{
		width: 120px;
		height: 40px;
		
	}

/*Кнопки переходов */			
	.top_prev_key{
		float: left;
		font-size: 100px;
		margin-top: 40px;
		margin-left: 10px;
		color: #57B8ED;
	}
	.top_next_key{
		float: right;
		font-size: 100px;
		-moz-transform: rotate(180deg);
		-webkit-transform: rotate(180deg);
	    -o-transform: rotate(180deg);
		margin-top: 20px;
		margin-right: 10px;
		color: #57B8ED;
	}
	.top_next_key a{
		color: #57B8ED;
	}
	.top_prev_key a{
		color: #57B8ED;
	}
	.top_next_key a:hover{
		color: #009DF2;
	}
	.top_prev_key a:hover{
		color: #009DF2;
	}
	
/*Заголовки*/
.main_header{
	font-weight: bold;
	margin: 10px;
	text-decoration: underline;
	
}

/*Главный блок 1 */
	.main_block_1{
		width: 300px;
		float: left;
	}
	.main_1{
		border: solid 1px #aacfe4;
		margin-right: 10px;
		padding: 0px 0 10px 0; 
	}
	.main_photo{
		width: 255px;
		height: 300px;
		border-right: solid 1px #aacfe4;
		border-bottom: solid 1px #aacfe4;
		padding: 5px;
		float: left;
		text-align: center;
	}
	.photos{
		width: 80px;
		height: 80px;
		float: left;
		margin-top: 10px;
		text-align: center;
	}
	.photos img{
		 max-height: 100px;
		 max-width: 100px;
	}
	.main_category{
		font-size: 12px;
		width: 150px;
		height: 290px;
		overflow-y: hidden;
		overflow-x: hidden;
		padding: 10px;
		float: left;
		border-bottom: solid 1px #aacfe4;
	}
/*Главный блок 2 */
	.main_block_2{
		width: 370px;
		float: left;
	}
	.main_2{
		border: solid 1px #aacfe4;
		margin-right: 10px;
		border-right: solid 1px #aacfe4;
		min-height: 551px;
	}
	
	
/*Главный блок 3 */
	.main_block_3{
		width: 520px;
		float: left;
	}
	.main_3{
		border: solid 1px #aacfe4;
		margin-right: 10px;
		padding: 10px 10px 10px 10px; 
		min-height: 531px;
		border-right: solid 1px #aacfe4;
	}
/*	
@media screen and (max-width: 1630px) {
   .main_block_3 {
      width: 100%;
   }
   .main_block_2{
		width: 60%;
   }
   .main_block_1{
		width: 40%;
   }
}*/
/*----- Tabs -----*/
.tabs {
    width:100%;
    display:inline-block;
}
 
    /*----- Tab Links -----*/
    /* Clearfix */
    .tab-links:after {
        display:block;
        clear:both;
        content:'';
    }
 
    .tab-links li {
        margin:0px 5px;
        float:left;
        list-style:none;
    }
 
        .tab-links a {
            padding:9px 15px;
            display:inline-block;
            border-radius:3px 3px 0px 0px;
            background:#7FB5DA;
            font-size:16px;
            font-weight:600;
            color:#4c4c4c;
            transition:all linear 0.15s;
        }
 
        .tab-links a:hover {
            background:#a7cce5;
            text-decoration:none;
        }
 
    li.active a, li.active a:hover {
        background:#fff;
        color:#4c4c4c;
    }
 
    /*----- Content of Tabs -----*/
    .tab-content {
        padding:15px;
        border-radius:3px;
        box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
        background:#fff;
    }
 
        .tab {
            display:none;
        }
 
        .tab.active {
            display:block;
        }
	
		
	#actionmessage{
		display: none;
	}
	
html, body {
    height: 100%;
    width: 100%;
    overflow: auto;
	}
</style>
