Search = function()
{
    var self = this;
}

Search.prototype = 
{
       callContent: function()
       {
            var self = this;
            self.loader(true);
            var data = jQuery("#params").serialize();
            jQuery.post('/search/content', data, function(r,s,xhr){
                            jQuery("#result").html(r);
                            self.loader(false); 
            });
       },
       loader:function(type)
       {
           if(type)
           jQuery("<div id='sLoader' title='Идет загрузка данных...'><img src='/img/ajax-loader.gif' /></div>").appendTo('body').dialog({
               modal:true,
               resizable: false,
               draggable: false,
               closeText: 'hide',
               closeOnEscape: false,
               width: 250,
               height: 80,
               hide: "explode",
           });
           else{
               jQuery("#sLoader").dialog('close');
               jQuery("#sLoader").remove();
           }
       },
       doPager: function(page)       
       {
            jQuery("#page").val(page);
            this.callContent();
       },
       sDesigner: function(selfDesgner){
            if(jQuery("#page").val()) 
                jQuery("#page").val("");     
            jQuery("#designerId").val(jQuery(selfDesgner).val());
            this.callContent();
       }, 
       sCatalog : function(selfCatalog){
            var val = jQuery(selfCatalog).val();
            var self = this;
            jQuery.post('/product/podcatselectsearch', {id: val}, function(r,s,xhr){
                self.callContent();                   
                jQuery("#podcatSelect").html(r);
                jQuery("#pcat_id").attr("onchange", "javascript:_sc.sPodcat(this)");
            });
       },
       sPodcat: function(){ 
            var self = this;
            if(jQuery("#colorForm").val()) jQuery("#colorForm").val("");
            if(jQuery("#sizeForm").val()) jQuery("#sizeForm").val("");
            if(jQuery("#materialForm").val()) jQuery("#materialForm").val("");    
            if(jQuery("#page").val()) jQuery("#page").val("");    
            self.callContent();
        },
        sSize: function(selfSize){ 
            if(jQuery("#page").val()) jQuery("#page").val("");    
            jQuery("#sizeForm").val(jQuery(selfSize).val());
            this.callContent();
        }, 
        sColor: function(selfColor){
            if(jQuery("#page").val()) jQuery("#page").val("");    
            jQuery("#colorForm").val(jQuery(selfColor).val()); 
            this.callContent();
        },
        sMaterial: function(selfMaterial){ 
            if(jQuery("#page").val()) jQuery("#page").val("");    
            jQuery("#materialForm").val(jQuery(selfMaterial).val());
            this.callContent();
        },
}

var _sc = new Search();