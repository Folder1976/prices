$(document).on('click', 'span', function(event){
                           
    var id = event.target.id;
   
    if (id) {
        
        console.log(id);
        
        var name = $('.category_id_'+id).html();
        var target = $('#target_categ_id').val();
       
       console.log(target);
       
        if (target > 0) {
            $('#category_id'+target).val(id);
            $('#category_name'+target).html(name);
            $('#enable'+target).trigger('change');
        }else{
            $('#category_id').val(id);
            $('#category_name').html(name);
        }
        
        
        $('#container').hide();
        $('#container_back').hide();
        //$('#category').trigger('change');
                                              
    }else{
                  
        if ($(this).attr('class').search("handle ") != -1) {
                      $(this).toggleClass('closed opened').nextAll('ul').toggle(300);
        }
                  
     }
});