//validator

 function trim(string)
 {
        return string.replace(/(^\s+)|(\s+$)/g, "");
 }

function isNotEmpty(elem)
{
    var val = trim(jQuery(elem).val());
    if(val.length == 0) return false;
    
    return true;    
}

function isEmail(elem)
{
    var val = jQuery(elem).val();    
    return (/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(val);    
}

function isEqual(elem1, elem2)
{
    var val1 = jQuery(elem1).val();    
    var val2 = jQuery(elem2).val();    
    return (val1 == val2);
}

function isSomeChecked(elem)
{
    var arrBox = jQuery("input:checkbox:checked",elem);
    return (arrBox.length > 0);
}

function isSomeHidden(elem)
{
    return (jQuery("input:hidden",elem).length > 0);
}

function setValidationResult(elem,is_valid,message)
{

    if(is_valid)
    {
        jQuery(elem).removeClass("error");
        jQuery(elem).attr("title","");
    }        
    else
    {
        jQuery(elem).addClass("error");
        jQuery(elem).attr("title",message);
    }
    
    return is_valid;    
}

function parseError(elem)
{
    var arrBox = jQuery("input:hidden",elem);
    for(var i = 0; i < arrBox.length; i++)
    {
        var ex = arrBox[i];
        var id = ex.id;
        var newid = id.substring(4, id.length);
        setValidationResult(jQuery("#"+newid),false,jQuery(ex).val());
    }
}