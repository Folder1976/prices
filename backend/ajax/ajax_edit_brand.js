   
    jQuery(document).on('change','.edit_brand_detail', function(){
       
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var name = jQuery('#name'+id).val();
        var table = jQuery('#table').val();
        var shop_id = jQuery('#shop_id').val();
        var brand_id = jQuery('#brand_id'+id).val();
        var enable_tmp = 0;
        var sort = jQuery('#sort'+id).val();
        
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "id="+id+"&shop_id="+shop_id+"&brand_id="+brand_id+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&table="+table+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
 
    jQuery(document).on('click','.add_brand_detail', function(){
        
        var id = 0;
        var name = jQuery('#name').val();
        var shop_id = jQuery('#shop_id').val();
        var brand_id = jQuery('#brand_id').val();
        var table = jQuery('#table').val();
        var enable_tmp = 0;
        var sort = jQuery('#sort').val();
       
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
        
        if (name != "") {
            jQuery.ajax({
                type: "POST",
                url: "/backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "shop_id="+shop_id+"&brand_id="+brand_id+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&table="+table+"&key=add",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    location.reload();
                }
            });
        }
    });
    
    jQuery(document).on('click','.dell_brand_detail', function(){
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
    
//=========================================================================================================================    
//=========================================================================================================================    
//=========================================================================================================================

 jQuery(document).on('change','.edit_brand', function(){
       
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var name = jQuery('#name'+id).val();
        var enable_tmp = 0;
        var table = jQuery('#table').val();
        
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "id="+id+"&name="+name+"&enable="+enable_tmp+"&table="+table+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
 
    jQuery(document).on('click','.add_brand', function(){
        var id = 0;
        var name = jQuery('#name').val();
        var enable_tmp = 0;
        var table = jQuery('#table').val();
        
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
        
        if (name != "") {
            jQuery.ajax({
                type: "POST",
                url: "/backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&name="+name+"&enable="+enable_tmp+"&table="+table+"&key=add",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    location.reload();
                }
            });
        }
        
    });
    
    jQuery(document).on('click','.dell_brand', function(){
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