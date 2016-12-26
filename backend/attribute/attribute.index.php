<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
?>
<br>
<!--script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/backend/ajax_edit_attributes.js"></script-->
<h1>Справочник : Фильров/Атрибутов</h1>
<div style="width: 50%">
<div class="table_body">

<table class="text">
    <tr>
        <th>id</th>
        <th>Название</th>
        <th>Активный</th>
        <th>Сорт</th>
        <th>Значения</th>
        <th>Описание</th>
        <th>&nbsp;</th>
    </tr>
<?php $arr = $List; ?>
    <tr>
        <td class="mixed">новый</td>
        <td class="mixed"><input type="text"        id="name" style="width:300px;" value="" placeholder="Название фильтра"></td>
        <td class="mixed"><input type="checkbox"    id="enable"  checked ></td>
        <td class="mixed"><input type="text"        id="sort" style="width:100px;" value=""></td>
        <td>        
            &nbsp;
           </td>              
        <td class="mixed"><input type="text"        id="description" style="width:400px;" value=""></td>
        <td>        
            <a href="javascript:" class="add">
                <img src="/<?php echo TMP_DIR; ?>backend/img/add.png" title="удалить" width="16" height="16">
            </a>
           </td>              
    </tr>
    <td>
        <td colspan="6">&nbsp;</td>
    </td>

<?php foreach($arr as $index => $ex){ ?>
    <tr id="<?php echo $ex['id'];?>">
        <td class="mixed"><?php echo $ex['id'];?></td>
        <td class="mixed"><input type="text" class="edit" id="name<?php echo $ex['id'];?>" style="width:300px;" value="<?php echo $ex['name']; ?>"></td>
        <td class="mixed"><input type="checkbox" class="edit" id="enable<?php echo $ex['id'];?>"  <?php if($ex['enable']) echo 'checked';?>></td>
        <td class="mixed"><input type="text" class="edit" id="sort<?php echo $ex['id'];?>" style="width:100px;" value="<?php echo $ex['sort']; ?>"></td>
        <td align="center">        
            <a href="/<?php echo TMP_DIR; ?>backend/index.php?route=attribute/attribute.main.index.php&guide=<?php echo $ex['id'];?>" class="detail" data-id="<?php echo $ex['id'];?>">
                <img src="/<?php echo TMP_DIR; ?>backend/img/jleditor_ico.png" title="редактировать" width="16" height="16">
            </a>
           </td>
        <td class="mixed"><input type="text" class="edit" id="description<?php echo $ex['id'];?>" style="width:400px;" value="<?php echo $ex['description']; ?>"></td>
        <td>        
            <a href="javascript:;" class="dell" data-id="<?php echo $ex['id'];?>">
                <img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16">
            </a>
           </td>              
    </tr>
<?php } ?>

</table>
<input type="hidden" id="table" value="<?php echo $table; ?>">
<script>

    
</script>



</div>

</div>


<script>
	 //======================================================================   
    
    jQuery(document).on('change','.edit', function(){
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var name = jQuery('#name'+id).val();
        var enable_tmp = 0;
        var sort = jQuery('#sort'+id).val();
        var description = jQuery('#description'+id).val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "id="+id+"&description="+description+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&key=edit_attr_grp",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
 
    jQuery(document).on('click','.add', function(){
		
		//console.log('11 '+name);   
        var id = 0;
        var name = jQuery('#name').val();
        var enable_tmp = 0;
        var sort = jQuery('#sort').val();
        var description = jQuery('#description').val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
     
        if (name != "") {
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&description="+description+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&key=add_attr_grp",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    location.reload();
                }
            });
        }
        
    });
    
    jQuery(document).on('click','.dell', function(){
        var id = jQuery(this).data('id');
        var table = jQuery('#table').val();
        
        if (confirm('Вы действительно желаете удалить фильтр?')){
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&key=dell_attr_grp",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    jQuery('#'+id).hide();
                }
            });
        }
    });
    //======================================================================
</script>
