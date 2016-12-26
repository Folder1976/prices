$(document).on('click', 'span', function(event){
                           
    var id = event.target.id;
   
    if (id) {
            
        var name = $('.category_id_'+id).html();
    
        var t_id = $('#target_categ_id').val();
        var t_name = $('#target_categ_name').val();
        var t_name = $('#target_categ_name').val();
        var shop_id = $('#shop_id').val();
        
        t_name = t_name.replace("&",'@@@@');
        t_name = t_name.replace("\\",'@##@');
      
        jQuery.ajax({
            type: "POST",
            url: "/backend/import/ajax_replace_editor.php",
            dataType: "text",
            data: "enable=1&alt_category_id="+t_id+"&shop_id="+shop_id+"&category_id="+id+"&alt_category_name="+t_name+"&table=fash_category_alternative&key=add",
            beforeSend: function(){
            },
            success: function(msg){
                console.log(msg);
                
                $('tr#'+t_id).css('background-color','green');
                $('#select_category'+t_id).html(name);
                $('#container').hide();
            }
        });
        
                                              
    }else{
                  
        if ($(this).attr('class').search("handle ") != -1) {
                      $(this).toggleClass('closed opened').nextAll('ul').toggle(300);
        }
                  
     }
});