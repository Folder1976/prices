$(document).on('click', 'span', function(event){
                           
    var id = event.target.id;
   
   
    if (id) {
         //debugger;
         console.log($('#select_cetegory_target').val());
        if($('#select_cetegory_target').val() == 'list'){
            $('#category').val(id);
            $('#container').hide();
            $('#container_back').hide();
            $('#category').trigger('change');
            
        }else if($('#select_cetegory_target').val() == 'category'){
         
            $('#category_id').val(id);
         
         console.log($('#select_cetegory_target').val()+' '+id);   
            
            jQuery.ajax({
				type: "POST",
				url: "/backend/seo/ajax/get_info.php",
				dataType: "json",
				data: "category_id="+id+"&key=get_category_info",
				beforeSend: function(){
				},
				success: function(msg){
					console.log(msg);
                    
                    jQuery("#category_name").val(msg.category_name);
					jQuery("#category_url").val(msg.category_url);
                    jQuery("#url").val(msg.category_url);
                    
                    $('.filters').each(function( index, value ) {
				
                        if ($(this).prop('checked')) {
                            $(this).prop('checked',false);
                        }
                            
                    });
                    
                    $('#category_id').trigger('change');
                    
                    
                    $('#container').hide();
                    $('#container_back').hide();
          
				}
			});
            
        }
     
                          
    }else{
                  
        if ($(this).attr('class').search("handle ") != -1) {
                      $(this).toggleClass('closed opened').nextAll('ul').toggle(300);
        }
                  
     }
});