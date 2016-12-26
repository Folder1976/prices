Cart = function()
{
    var self = this;
}

Cart.prototype = 
{
    isLog : false,
    addToCart: function (id, selectorButton)
    {
        var self = this;
        //var id = jQuery("#product_id").val();
        var countItem = jQuery("#countItem").val();
        var sizeItem = jQuery("#sizeItem").val();
        var AnySizeItem = jQuery("#anySizeInput").val();
        if(jQuery(selectorButton).hasClass("noactive") )
        {
            self.goToCart();
            return;
        }
        if(countItem < 1)
        {
            alert("Кол-во товаров должно быть хоть 1.");
            return false;
        }        
        jQuery.post('/cart/addtocart', {id: id, count: countItem, sizeItem: sizeItem, any_size:AnySizeItem}, function(r,s, xhr){
            eval("var actionMessage = "+xhr.getResponseHeader("actionmessage"));              
              if(actionMessage.type == 'success')
              {
                  self.updateCart();
                  jQuery(selectorButton).addClass("noactive");
                  jQuery(selectorButton).text("перейти в корзину");
              } else {
                  alert('Произошла ошибка при добавлении товара. Попробуйте ещё раз или обратитесь к администратору.');
              }
        });
    },
    deleteFromCart:function(pk)
    {
        var self = this;
        jQuery.post('/cart/fastdelete', {pk: pk}, function(r,s,xhr){
                eval("var actionMessage = "+xhr.getResponseHeader("actionmessage"));
                if(actionMessage.type == 'success')
                {
                    jQuery("#item_"+pk).fadeOut(function(){
                     if(jQuery("#orderForm items").length <= 0)   
                        window.location.reload(true);
                     else jQuery(this).remove();                     
                    });
                    self.updateCart();
                }
            }
        ); 
    },
    goToLogin: function()
    {
       window.location.href = '/registration/enter';  
    },
    createFreeOrder : function()
    {
        window.location.href = '/cart/create';
    },
    updateCart : function()
    {
        jQuery.post('/cart/block', function(r,s,xhr){
            jQuery("#mainCart").html(r);
        });
    },
    recount: function()    
    {
        var data = jQuery("#orderForm").serialize();
        jQuery.post('/cart/recount', data, function(r,s,xhr){
           eval("var actionMessage = " + xhr.getResponseHeader('actionmessage'));
           if(actionMessage.type == 'error')
               alert(actionMessage.message);
           else
               window.location.reload(true);
        });
    },
    sendToManager: function()
    {
        var self = this;
        jQuery.post('/cart/sendtomanager', function(r,s,xhr){
            eval("var actionMessage = "+xhr.getResponseHeader("actionmessage"));
            if(actionMessage.type == 'success')
            {
                self.succesDialog();
                setTimeout('self.goToCart();', 3000 );
            }
            else
                self.showDialog(actionMessage.message, 'Ошибка', false);
        });         
    },
    regSessUser: function()
    {
        var self = this;
        jQuery("#enterForm").attr("action", "/registration/regsessuser");
        handlerForm.init('#enterForm', '.result-reg-sess-user').ajax(
            function(){
                self.sendToManager();
            }    
        );                                       
    },
    showSpecialOrder:function(free)
    {
        window.location.href = '/cart/specialoffers';
    },
    successOrder : function()
    {
        window.location.href = '/cart/successorder';
    },
    sendOrder:function()
    {
        var self = this;
        handlerForm.init('#enterForm', '.result-send-free-order').ajax(
            function(){
                setTimeout('_cart.successOrder()', 3000);
            }    
        );                                       
        
    },
    goToCart: function(redirect)
    {
        window.location.href = ((typeof redirect != 'undefined') && (redirect != 'null')) ? redirect : '/cart/order';  
    },
    confirmRegister: function(action)
    {
        var self = this;
        var data = jQuery("#confirmForm").serialize();
        jQuery.post(action, data, function(r,s,xhr){
             eval("var status = " + xhr.getResponseHeader('actionmessage'));
             if(status.type == 'error')
             {
                 self.showDialog(status.message, 'Ошибка', false); 
             }else{
                 self.showDialog(status.message,'', 'self.goToCart();');                       
             }
        });          
    },                
    showDialog: function(message, title, __callback)
    {
         var self = this;
         jQuery("<div title="+title+">"+message+"</div>").appendTo("body").dialog({
                modal: true,
                width:400,
                height:100,
                resizable: false,
                close: function()
                {
                   if(__callback) 
                        eval(__callback);
                   jQuery(this).remove();
                }
         });        
    },
    getTopWishList: function(self)
    {
        jQuery.post('/cart/gettopwishlist', function(r,s,xhr){
            jQuery("<div title='"+jQuery(self).attr("title")+"'>"+r+"</div>").appendTo("body").dialog({
                modal: true,
                width:1000,
                height:500,
                draggable: false,
                resizable: false,
                buttons : {
                        "Закрыть" : function(){
                            jQuery(this).dialog("close");
                        }
                }
            });
        });
    },
    showAnySizeInput: function(id)    
    {
    	var pk = '';
        if(id == 9999)
        {
            jQuery("#anySizeInput" + ( pk ? '-'+pk:'' ) ).fadeIn("slow");
            jQuery("#anySizeBut" + ( pk ? '-'+pk:'' ) ).fadeIn("slow");
        }
        else{ 
            jQuery("#anySizeBut"+ ( pk ? '-'+pk:'' ) ).fadeOut("slow");
            jQuery("#anySizeInput"+ ( pk ? '-'+pk:'' ) ).fadeOut("slow");
        }
    },
    getComments: function(id)
    {
        var self = this;
        jQuery.post('/product/comments',{id:id}, function(r,s,xhr){
            eval("var title = " + xhr.getResponseHeader('page_title'));
            eval("var content = " + xhr.getResponseHeader('page_content'));
            var div = jQuery("<div id='commentBox-"+id+"' title='"+title+"'></div>").html(content);
            jQuery(div).appendTo("body").dialog({
                modal: true,
                width:900,
                height:500,
                resizable: false,
                buttons : {
                        "Закрыть" : function(){
                            jQuery(this).dialog("close");
                        }
                }
            });
        });        
    },
    getSizes: function(id)
    {
        var self = this;
        jQuery.post('/product/sizes',{id:id}, function(r,s,xhr){

            var div = jQuery("<div id='sizesBox-"+id+"' title='Размерная сетка'></div>").html(r);
            jQuery(div).appendTo("body").dialog({
                modal: true,
                width:700,
                height:'auto',
                resizable: false,
                closeText: '',
                buttons : {
                        "Закрыть" : function(){
                            jQuery(this).dialog("close");
                        }
                }
            });
        });        
    },
    doSelectGift: function(id, form)
    {
        jQuery("#productGiftId").val(id);
        handlerForm.init(form, '.result-select-gift-box-'+id, false, true).ajax(
            function(){
                //window.location.href = '#order';
                setTimeout('window.location.href="/cart/order";', 3000);
            }
        );
    },
    doChangeSpecialOffer:function(id, form)
    {
        var self = this;
        jQuery("#sp_id").val(id);
        handlerForm.init(form, '.result-select-gift-box-'+id, false, true).ajax(
            function(){
                 self.sendToManager();
            }
        );
    },
    doDeleteSpecialOffer:function()
    {
        var self = this;
        if(self.isLog)
            self.sendToManager();
        else self.sendOrder();
    },
    registerNew : function ()
    {
        var self = this;
        
        jQuery("#enterForm").attr("action", "/registration/finalstep");
        handlerForm.init('#enterForm', '.result-registered').ajax(
            function(){
                setTimeout('_cart.goToCart("/registration/confirm")', 4000);
            }    
        );         
    },
    getFastOrderForm: function(id)
    {
        jQuery.post('/product/getfastorderform', {id:id}, function(r,s,xhr){
            var dia = jQuery("<div id='FastOrderBox' title='Купить в один клик'></div>");
            dia.html(r);
            dia.dialog({
                modal: true,
                width:500,
                height:'auto',
                resizable: false,
                buttons : {
                        "Закрыть" : function(){
                            jQuery(this).dialog("close");
                        }
                }
            });
        });  
    },
    saveFastOrderFrom: function(form)
    {
        jQuery("#fastOrderSizeId").val(jQuery("#sizeItem").val());
        
        handlerForm.init('#fastOrderForm', '.messageBoxFastOrder').ajax(
            function(){
                setTimeout(function(){
                    jQuery("#FastOrderBox").dialog("destroy");
                }, 4000);
            }    
        );
    }
}

SpecialOffers = function()
{
    var self = this;
    self.countElem = jQuery("#offersBox li").size(); 
    self.eqs = 1; 
}

SpecialOffers.prototype = 
{
    getLeft: function()
    {
        var self = this;
        self.animate('-');
        
    },
    getRight: function()
    {
        var self = this;
        self.animate('+');
        
    },
    animate: function(dest)
    {
        var self = this;
        var oneW = jQuery("#offersBox li:eq(0)").css('width');
        var curLeft = parseInt(jQuery("#offersBox").css('left'));
        var fullWidth = parseInt(jQuery(".productSPContainer").css('width'));
        var boxWidth = parseInt(jQuery("#offersBox").css('width'));
        var value = dest+'='+oneW;
        var maxLeft = -(( boxWidth - fullWidth ));
        var mark = true;
        if(dest == '+' && curLeft > 0 )
            mark = false;
        if(dest == '-' && curLeft < maxLeft)
            mark = false;
        
        if(mark == true)
        {
            jQuery("#offersBox li").find(".giftTitle").fadeOut("slow");
            jQuery("#offersBox li").find(".buttonBox").fadeOut("slow");
        }                         
        if(mark == true)
        jQuery("#offersBox").animate({
            left: value
        }, function(){
            var ScurLeft = parseInt(jQuery("#offersBox").css('left'));
            self.eqs = -(ScurLeft/340)+1;
            jQuery("#offersBox li:eq("+self.eqs+")").find(".giftTitle").fadeIn("slow");
            jQuery("#offersBox li:eq("+self.eqs+")").find(".buttonBox").fadeIn("slow");
        });
    }
}


var _cart = new Cart();
jQuery(document).ready(function(){
     _sp = new SpecialOffers();
});
