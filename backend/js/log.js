function insert_log(log_key, log_target, log_text) {
    
    //console.log(log_key);
    //console.log(log_target);
    //console.log(log_text);
    $.ajax({
        type: "get",
        url: "ajax/add_log.php",
        dataType: "text",
        data: "log_key="+log_key+"&log_target="+log_target+"&log_text="+log_text+"&key=add_log",
        beforeSend: function(){
        },
        success: function(msg){
            console.log( msg );
        }
    });
    
}