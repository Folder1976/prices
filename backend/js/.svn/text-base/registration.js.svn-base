Registration = function()
{
    var self = this;
}

Registration.prototype = 
{
   initType:function()
   {
       var type = jQuery("#enterForm input[type='radio']:checked").val();
       if(type == 1)
       {
            jQuery("#enterForm input[type='password']").attr("disabled", "disabled");
            jQuery("#enterForm input[type='password']").addClass("disabled");
       } else {
            jQuery("#enterForm input[type='password']").removeAttr("disabled");   
            jQuery("#enterForm input[type='password']").removeClass("disabled");   
       }
   } 
}

_reg = new Registration();