<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$table = 'size_group';
?>
<br>
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/backend/ajax_edit_attributes.js"></script>
<h1>Справочник : Размеры</h1>
<div style="width: 50%">
<div class="table_body">

<table class="text">
    <tr>
        <th>id</th>
        <th>Название</th>
        <th>Активный</th>
        <th>Сорт</th>
        <th>Name</th>
         <th>&nbsp;</th><th>&nbsp;</th>
    </tr>
<?php $arr = $List; ?>
    <tr>
        <td class="mixed">новый</td>
        <td class="mixed"><input type="text"        id="name" style="width:300px;" value="" placeholder="Название группы размеров"></td>
        <td class="mixed"><input type="checkbox"    id="enable"  checked ></td>
        <td class="mixed"><input type="text"        id="sort" style="width:100px;" value=""></td>
        <td class="mixed"><input type="text"        id="filter_name" style="width:100px;" value="" placeholder="ua"></td>
        <td></td>   
		   <td>        
            <a href="javascript:" class="add">
                <img src="/<?php echo TMP_DIR; ?>backend/img/add.png" title="Добавить" width="16" height="16">
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
        <td class="mixed"><input type="text" class="edit" id="filter_name<?php echo $ex['id'];?>" style="width:100px;" value="<?php echo $ex['filter_name']; ?>"></td>
        <td align="center">        
            <a href="/<?php echo TMP_DIR; ?>backend/index.php?route=size/size.main.index.php&guide=<?php echo $ex['id'];?>" class="detail" data-id="<?php echo $ex['id'];?>">
                <img src="/<?php echo TMP_DIR; ?>backend/img/jleditor_ico.png" title="редактировать" width="16" height="16">
            </a>
        </td>
    
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
        var filter_name = jQuery('#filter_name'+id).val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
            dataType: "text",
            data: "id="+id+"&filter_name="+filter_name+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&table="+table+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
 
    jQuery(document).on('click','.add', function(){
        var id = 0;
        var name = jQuery('#name').val();
        var enable_tmp = 0;
        var sort = jQuery('#sort').val();
        var filter_name = jQuery('#filter_name').val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
        
        if (name != "") {
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
                dataType: "text",
                data: "id="+id+"&filter_name="+filter_name+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&table="+table+"&key=add",
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
        
        if (confirm('Вы действительно желаете удалить группу?')){
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
                dataType: "text",
                data: "id="+id+"&table="+table+"&key=dell",
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
