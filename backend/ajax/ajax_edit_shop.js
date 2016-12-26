   
    jQuery(document).on('change','.edit_shop_detail', function(){
        var table = jQuery('#table').val();
        var id = jQuery('.id').data('id');
        var name = jQuery(this).data('id');
        var value = jQuery(this).val();
         
         console.log(jQuery(this).attr('type'));
         
        if (jQuery(this).attr('type')){
            value = 0;
            if(jQuery(this).prop('checked')) {
                value = 1;
            }
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "id="+id+"&"+name+"="+value+"&table="+table+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
 
//Смена Категории
	//Перечитать подкатегории по выборе категории
	jQuery(document).on('change', '.main_category', function(){
		var id = jQuery(this).val();
		var target = jQuery(this).data('id');
        
		jQuery.ajax({
			type: "POST",
			url: "/backend/ajax/ajax_get_moderated_product.php",
			dataType: "json",
			data: "id="+id+"&key=get_podcategory",
			beforeSend: function(){
			},
			success: function(msg){
				console.log( msg );
			
				//подкатегория
				jQuery("#podcategory"+target).empty();
                jQuery("#podcategory"+target).append( '<option value="0" select>Выбрать. . .</option>');
				
                jQuery.each(msg.podcategory, function( index, value ) {
					jQuery("#podcategory"+target).append( '<optgroup label="'+value.name+'">');
						jQuery.each(value.options, function( index2, value2 ) {
							jQuery("#podcategory"+target).append( '<option value="'+index2+'" select>'+value2+'</option>');
						});
					jQuery("#podcategory"+target).append( '</optgroup>');
				});
                select = msg.podcategory_id;
                if (jQuery("#podcategory"+target).data('def') > 0) {
                    select = jQuery("#podcategory"+target).data('def');
                }
                //console.log(select);
				jQuery("#podcategory"+target+" [value='"+select+"']").attr("selected", "selected");
					
			}
		});
		
	});
    
//=========================================================================================================================    
//=========================================================================================================================    
//=========================================================================================================================

 jQuery(document).on('change','.edit_shop', function(){
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var name = jQuery('#name'+id).val();
        var enable_tmp = 0;
        var sort = jQuery('#sort'+id).val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "id="+id+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&table="+table+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
 
    jQuery(document).on('click','.add_shop', function(){
        var id = 0;
        var name = jQuery('#name').val();
        var enable_tmp = 0;
        var sort = jQuery('#sort').val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
        
        if (name != "") {
            jQuery.ajax({
                type: "POST",
                url: "/backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&table="+table+"&key=add",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    location.reload();
                }
            });
        }
        
    });
    
    jQuery(document).on('click','.dell_shop', function(){
        var id = jQuery(this).data('id');
        var table = jQuery('#table').val();
        
        if (confirm('Вы действительно желаете удалить фильтр?')){
            jQuery.ajax({
                type: "POST",
                url: "/backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&table="+table+"&key=dell",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    jQuery('#'+id).hide();
                }
            });
        }
    });

//======================================================================   
//======================================================================   
//======================================================================


    jQuery(document).on('click','.add_category_detail', function(){
        var id = 0;
        var alt_id = jQuery('#id').val();
        var alt_name = jQuery('#name').val();
        var shop_id = jQuery('#shop_id').val();
        var categ = jQuery('#podcategory').val();
        var enable_tmp = 0;
        var sort = jQuery('#sort').val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
        
        if (alt_id != '' || alt_name != '') {
            jQuery.ajax({
                type: "POST",
                url: "/backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&category_id="+categ+"&alt_category_id="+alt_id+"&alt_category_name="+alt_name+"&enable="+enable_tmp+"&shop_id="+shop_id+"&sort="+sort+"&table="+table+"&key=add",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    location.reload();
                }
            });
        }
    });
    
     jQuery(document).on('change','.edit_category_detail', function(){
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var alt_id = jQuery('#id'+id).val();
        var alt_name = jQuery('#name'+id).val();
        var shop_id = jQuery('#shop_id').val();
        var categ = jQuery('#podcategory'+id).val();
        var enable_tmp = 0;
        var sort = jQuery('#sort'+id).val();
        var table = jQuery('#table').val();
       
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "id="+id+"&category_id="+categ+"&alt_category_id="+alt_id+"&alt_category_name="+alt_name+"&enable="+enable_tmp+"&shop_id="+shop_id+"&sort="+sort+"&table="+table+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
    
    jQuery(document).on('click','.dell_category_detail', function(){
        var id = jQuery(this).data('id');
        var table = jQuery('#table').val();
        
        if (confirm('Вы действительно желаете удалить связь?')){
            jQuery.ajax({
                type: "POST",
                url: "/backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&table="+table+"&key=dell",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    jQuery('#'+id).hide();
                }
            });
        }
    });