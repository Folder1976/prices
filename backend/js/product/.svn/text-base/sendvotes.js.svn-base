Votes = function()
{
    var self = this;
}

Votes.prototype =
{
    pk : '',
    send: function(pk, key)
    {
        var self = this;
        self.pk = pk;
        jQuery.post('/product/sendvotes', {pk: pk, key: key}, function(r,s,xhr){
              eval("var actionMessage = "+ xhr.getResponseHeader('actionmessage'));             
              self.pushResult(actionMessage.type, actionMessage.message);              
        });
    },
    pushResult: function(state, message)
    {
       var self = this;
       jQuery("#msgRatio_"+self.pk).html(message);
       jQuery("#msgRatio_"+self.pk).attr("class","star"+state);
    }
}

var _votes = new Votes();