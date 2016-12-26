   /*
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
 */
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
				//console.log( msg );
			
				//подкатегория
				jQuery("#podcategory"+target).empty();
                jQuery("#podcategory"+target).append('<option value="0" select>Выбрать. . .</option>');
				
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
    
    
    jQuery(document).on('change','.edit_category_detail', function(){
      
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var alt_id = jQuery('#'+id).data('id');
        var alt_name = jQuery('#'+id).data('name');
        var shop_id = jQuery('#shop_id').val();
        var categ = jQuery('#podcategory'+id).val();
        var table = 'shop_category_alternative';
         
        jQuery.ajax({
            type: "POST",
            url: "/backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "shop_id="+shop_id+"&alt_category_id="+alt_id+"&alt_category_name="+alt_name+"&category_id="+categ+"&enable=1&table="+table+"&key=add",
            beforeSend: function(){
            },
            success: function(msg){
                jQuery('#'+id).css('background-color','green');
                console.log( msg );
            }
        });
        
    });
//=========================================================================================================================    
//=========================================================================================================================    
//=========================================================================================================================
