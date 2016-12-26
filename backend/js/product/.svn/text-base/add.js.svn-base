productAdd = function()
{   
    var self = this;
    self.imageField = [];
}
productAdd.prototype = 
{
    currentProductId: null,
    imageField : [],
    podcatURL : '',
    sizesURL : '',
    path: '',
    catzPath: '',
    deletePhotoPath: null,
    
    initFieldUploader: function()
    {
        var self = this; 
        for(var id in self.imageField)
            self.uplaoderInit("imgbox_"+self.imageField[id], "img_"+self.imageField[id]);
    },
    uplaoderInit: function(box,field)  
    {   
        var fileDesc = "";
        var fileExt = "";
        var path = "";
        var self = this;
        fileDesc = "Image File *.jpg;*.jpeg;*.png";
        fileExt = "*.jpg;*.jpeg;*.png";
        path = self.path;
        jQuery('#'+box).fileUpload(
        {
            'uploader': '/js/uploader/uploader.swf',
            'script': '/upload.php',
            'folder': path,
            'cancelImg': '/img/cancel.png',
            'auto': false,
            'buttonImg': '/img/button_upload.png',
            'rollover': true,
            'width': 70,
            'height': 20,
            'sizeLimit': 55000000,
            'buttonText': 'View',
            'fileDesc': fileDesc,
            'fileExt': fileExt,
            'displayData': '',
            onProgress: function (event, queueID, fileObj,data)
            {
                jQuery("#"+field).addClass("imageLoader");
            },
            onSelect: function (event, queueID, fileObj)
            {
                jQuery('#'+box).fileUploadStart(queueID);                
            },
            onComplete: function(event, queueID, fileObj, responce, data )
            {
                jQuery("#"+field).removeClass("imageLoader");
                jQuery("#"+field).val(responce);
            }
            });        
    },
    deletePhoto : function(type) 
    {
        if (!confirm('Вы действительно хотите удалить это фото?'))  
            return false;
        var self = this;
        
        var form = jQuery("<form action='"+self.deletePhotoPath+"'><input type='hidden' name='type' value='"+type+"' /><input type='hidden' name='id' value='"+self.currentProductId+"' /></form>")
        handlerForm.init(form, '.delete-form-result-box-'+type, false, false).ajax();
        
        
    },
    addColour : function ()
    {
        var select = jQuery("#buffer_color").html();
        var input = "<div class='operation'><span>"+select+"</span><a href='javascript:void(0)' onclick='javascript:_pa.deleteColor(this)'>удалить</a></div>";           
        jQuery("#colours").append(input);
    },
    deleteColor : function (self)
    {
        jQuery(self).parent("div").remove();
    },
    addMaterial : function ()
    {
       var select = jQuery("#buffer_material").html();
       var input = "<div class='operation'><span>"+select+"</span><a href='javascript:void(0)' onclick='javascript:_pa.deleteMaterial(this)'>удалить</a></div>";           
       jQuery("#materials").append(input);
    },
    deleteMaterial : function (self)
    {
        jQuery(self).parent("div").remove();
    },
    addCats : function ()
    {
        var select = jQuery("#buffer_cats").html();
        if(!select){ alert('Выберите сначало каталог!'); return false;}
        var input = "<div class='operation'><span>"+select+"</span><a href='javascript:void(0)' onclick='javascript:_pa.deleteCats(this)'>удалить</a></div>";           
        jQuery("#podcatSelect").append(input);
    },
    deleteCats : function (self)
    {
        jQuery(self).parent("div").remove();
    },
    editSubCats : function (cat)
    {
        var self = this;
        var cat_id = jQuery(cat).parent("div").find("select").val(); 
        var dialog = jQuery("<div id='_add_catz_d'><img src='/img/progressbar.gif' /></div>");
        dialog.dialog({
           width: 500,
           height: 500,
           resizable:false,
           modal: true,
           close: function(){jQuery(this).remove()}
        });
        jQuery.post(self.catzPath, {cat_id:cat_id, pid: self.currentProductId}, function(r){
           dialog.html(r);
        }); 
    },
    selectCatalog : function(selector){
        var self = this;
        var val = jQuery(selector).val();
        jQuery.post(self.podcatURL, {id:val}, function(r,s,xhr){
            jQuery("#buffer_cats").html(r);
        });
    },
    getSizes : function(selector){
        var self = this;
        var val = jQuery(selector).val();
        jQuery.post(self.sizesURL, {ids:val}, function(r,s,xhr){
            jQuery("#sizedchek").html(self.str_replace('<br/>', '', r));
        });
    },
    str_replace: function (search, replace, subject) {
        return subject.split(search).join(replace);
    },
    getShowPriceDown: function(pid)
    {
        var div = jQuery("<div title='Собщить когда цена упадет' id='__PRICE_DOWN_DIALOG'></div>");
        div.html("<center><img src='/img/ajax-loader.gif' /></center>");
        div.dialog({
            width:500,
            height:500,
            resizable: false,
            modal: true,
            draggable: false,
            close: function(){
                jQuery(this).remove();
            },
            buttons:{
                "Закрыть" : function(){
                    jQuery(this).remove();
                }
            }
        });
        
        jQuery.post('/product/getpricedown', {pid:pid}, function(r){
           div.html(r); 
        });
    }
}
var _pa = new productAdd();