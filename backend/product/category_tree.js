$(document).on('click', 'span', function(event){
                           
    var id = event.target.id;
   
    if (id) {
        
        var name = $('.category_id_'+id).html();
        $('.selected_category').html(name);
        $('.selected_category_id').val(id);
        
        $('#container').hide();
        $('#container_back').hide();
        //$('#category').trigger('change');
                                              
    }else{
                  
        if ($(this).attr('class').search("handle ") != -1) {
                      $(this).toggleClass('closed opened').nextAll('ul').toggle(300);
        }
                  
     }
});