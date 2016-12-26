handlerForm = function(selector,selectorMessage,selectorData,isMini) {
   this.selector = selector;   
   this.selectorMessage = selectorMessage || '.messageBox';
   this.selectorData = selectorData || '';
   this.isMini = isMini || false;      
}
handlerForm.init = function(selector,selectorMessage,selectorData,isMini){
    var obj = new handlerForm(selector,selectorMessage,selectorData,isMini);
    return obj;
}
handlerForm.prototype = {        
    $ : function(selector) { 
        if (typeof selector != 'undefined')
            return jQuery(selector);
        return jQuery; 
        
    },
    serialize : function ()
    {
        return this.$(this.selector).serialize();
    },
    confirm: function (dlog) {
        var self = this;
        self.$(dlog).dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons: {                
                "Отмена": function() {
                    jQuery( this ).dialog( "close" );
                },
                "Выполнить": function() {
                    jQuery( this ).dialog( "close" );
                    self.ajax();                    
                }
            }
        });
    },
    ajax : function(onSuccess, onError) {         
        
        var self = this;
        self.setPreload()                              
        this.$(this.selector).find('*').each(function(){
           jQuery(this).removeClass("ui-state-error");
           jQuery(this).next("u").html('');
        });
        if(!self.formValidate()) {
            self.setMsg(self.getErrorMsg('Не валидные данные'));
            return false;   
        }
        
        this.$().ajax({url: this.$(this.selector).attr('action'),
                  cache: false,type: "POST",
                  data: self.serialize(),
                  async: false,
                  success: function(data,status,xhr)
                  {
                      self.onSuccessReq(self,data,status,xhr);
                      if(self.isReqSuccess)
                      if (typeof onSuccess == 'function') {
                          onSuccess();
                      }
                      else
                      if (typeof onError == 'function') {
                          onSuccess();
                      }
                  }
              });
    },
    getInfoMsg : function(message) {
            var msg = '';
            msg += '<div style="margin-top: 5px;" class="ui-state-highlight ui-corner-all">';
            msg += '<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>';
            msg += message + '</p></div>';
            return msg;
    },
    getErrorMsg : function(message) {
            var msg = '';
            msg += '<div style="margin-top: 5px;" class="ui-state-error ui-corner-all">';
            msg += '<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>';
            msg +=  message + '</p></div>';
            return msg;
    },
    setMsg : function(message) {
         this.$(this.selectorMessage).html(message);         
    },
    setData : function(data) {
        this.$(this.selectorData).html(data);         
    },
    setValidationResult : function(elem,is_valid,message)
    {
        if(is_valid) {
            jQuery(elem).removeClass("ui-state-error");
            jQuery(elem).attr("title","");
            jQuery(elem).next("u").html("");
        } else {
            jQuery(elem).addClass("ui-state-error");
            jQuery(elem).attr("title",message);
            jQuery(elem).next("u").html(message);
        }    
        return is_valid;    
    },
    onSuccessReq : function (self,data,status,xhr) {
         
         var exception = typeof xhr.getResponseHeader('exception') == "string" ? eval(xhr.getResponseHeader('exception')) : '';
         var message = typeof xhr.getResponseHeader('message') == "string" ? eval (xhr.getResponseHeader('message')) : '';
         var validation =  '';
         if (typeof xhr.getResponseHeader('validation') == "string") {
             eval('validation = ' + xhr.getResponseHeader('validation'));
         }         
         var redirect = typeof xhr.getResponseHeader('redirect') == "string" ? eval(xhr.getResponseHeader('redirect')) : '';
         if(validation != '') {
            for(var i in validation) {
                this.setValidationResult('#'+i, false, validation[i]);                             
            }
         }
         
         var msg = '';
         if (message != '' && typeof message != 'undefined') {
            this.isReqSuccess = true; 
            msg += this.getInfoMsg(message);
         }
         if (exception != '' && typeof exception != 'undefined') {
            this.isReqSuccess = false;
            msg += this.getErrorMsg(exception);
         }
         if (redirect != '' && typeof redirect != 'undefined') {
             window.location.href = redirect;
         }
         this.setMsg(msg);
         this.setData(data);         
    },
    setPreload : function(){ 
        
        var gif = this.isMini ? '/img/miniload.gif' : '/img/mwait2.gif';
        this.$(this.selectorMessage).html('<img src="' + gif + '"/>').show(); 
    },
    formValidate: function()
    {
        var self = this;
        var valid = true;
        self.$(self.selector).find(".notEmpty").removeAttr("title");
        self.$(self.selector).find(".notEmpty").removeClass("ui-state-error");
        self.$(self.selector).find(".notEmpty").each(function(){
            if(self.$(this).is('input'))
                if(self.$(this).val() <= 0)
                {
                    self.$(this).addClass("ui-state-error");                    
                    self.$(this).attr("title", "Некорректно введены данные");
                    valid = false;
                }            
            if(self.$(this).is('textarea'))
                if(self.$(this).val() <= 0)
                {
                    self.$(this).addClass("ui-state-error");
                    self.$(this).attr("title", "Некорректно введены данные");
                    valid = false;
                }
            if(self.$(this).hasClass('isEmail'))            
            {
                var email = self.$(this).val();
                var re = new RegExp('[a-z0-9\.\-_]+@[a-z0-9\.\-_]+\.[a-z0-9]{2,4}');
                if(!re.exec(email))
                {
                    self.$(this).addClass("ui-state-error");                    
                    self.$(this).attr("title", "Некорректно введены данные");
                    valid = false;
                }                
            }
        });
        self.$(self.selector).find(".isInn").each(function(){  
                var inn = self.$(this).val();
                var re = new RegExp('[0-9]{9}');
                if(inn && !re.exec(inn))
                {
                    self.$(this).addClass("ui-state-error");                    
                    self.$(this).attr("title", "Поле должно содержать 9 цифр от 0 до 9");
                    valid = false;
                } 
        });
        return valid;
    }
    
}

Page = function(url)
{
    var self = this;
}
Page.prototype = 
{
    url: null,
    getPage:function(url)
    {
        var self = this;
        jQuery.post('/getajaxpage/'+url, function(r,s,xhr){
            var req = null;
            eval(" req = " + r);
            jQuery("<div title='"+req.page_title+"'>"+req.page_content+"</div>").appendTo("body").dialog({
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
    doSetCount : function(val)
    {
        jQuery.post('/cabinet/dosetcount', {val:val}, function(r,s,xhr){
            eval("var actionMessage = " + xhr.getResponseHeader("actionmessage"));
                if(actionMessage.type == 'success')
                    window.location.reload(true);
                else
                    alert('Произошла ошибка при смене.');
                        
        });
    },
    go : function(url)
    {
        window.location.href = url;
        return false;    
    },
}

_page = new Page();






