<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$table = '';
?>
<br>
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/backend/ajax_edit_attributes.js"></script>
<h1>Фильтр : <?php echo $filter_name;?></h1>
<a href="/<?php echo TMP_DIR; ?>backend/index.php?route=attribute/attribute.main.index.php" class="detail">Вернуться к группам фильтров</a>
<div style="width: 50%">
<div class="table_body">

<table class="text">
    <tr>
        <th>id</th>
        <th>Группа</th>
        <th>Название</th>
        <th>URL</th>
        <th>Активный</th>
        <th>Сорт</th>
        <th>&nbsp;</th>
    </tr>
<?php $arr = $List; ?>
    <tr>
        <td class="mixed">новый</td>
        <td class="mixed"><select id="group" style="width:300px;">
                <?php foreach($Groups as $index => $value){?>
                    <?php if($index == (int)$_GET['guide']){ ?>
                        <option value="<?php echo $index; ?>" selected><?php echo $value; ?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $index; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                <?php } ?>
            
                </select>
        </td>
        <td class="mixed"><input type="text"        id="name" style="width:300px;" value="" placeholder="Название фильтра"></td>
        <td class="mixed"><input type="text"        id="filter_name" style="width:300px;" value="" placeholder="Дополнительное имя"></td>
        <td class="mixed"><input type="checkbox"    id="enable"  checked ></td>
        <td class="mixed"><input type="text"        id="sort" style="width:100px;" value=""></td>
        <td>        
            <a href="javascript:" class="add_detail">
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
        <td class="mixed">
                <select class="edit_detail" id="group<?php echo $ex['id'];?>" style="width:300px;">
                <?php foreach($Groups as $index => $value){?>
                    <?php if($index == $ex['group']){ ?>
                        <option value="<?php echo $index; ?>" selected><?php echo $value; ?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $index; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                <?php } ?>
            
                </select>
        </td>
        <td class="mixed"><input type="text" class="edit_detail" id="name<?php echo $ex['id'];?>" style="width:300px;" value="<?php echo $ex['name']; ?>"></td>
        <td class="mixed"><input type="text" class="edit_detail" id="filter_name<?php echo $ex['id'];?>" style="width:300px;" value="<?php echo $ex['filter_name']; ?>"></td>
        <td class="mixed"><input type="checkbox" class="edit_detail" id="enable<?php echo $ex['id'];?>"  <?php if($ex['enable']) echo 'checked';?>></td>
        <td class="mixed"><input type="text" class="edit_detail" id="sort<?php echo $ex['id'];?>" style="width:100px;" value="<?php echo $ex['sort']; ?>"></td>
         <td>        
            <a href="javascript:;" class="dell_detail" data-id="<?php echo $ex['id'];?>">
                <img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16">
            </a>
           </td>              
    </tr>
<?php } ?>
<input type="hidden" id="table" value="<?php echo $table; ?>">
</table>
<script>
    

</script>

</div>
<div class="operation">
    <div style="clear: both;"></div>
    
</div>
</div>
<script>
	
//======================================================================
    
    jQuery(document).on('change','.edit_detail', function(){
      
	    var id = jQuery(this).parent('td').parent('tr').attr('id');
        var name = jQuery('#name'+id).val();
        var table = '';//jQuery('#table').val();
        var filter_name = jQuery('#filter_name'+id).val();
        var enable_tmp = 0;
        var group = jQuery('#group'+id).val();//<?php echo (int)$_GET['guide'];?>;
        var sort = jQuery('#sort'+id).val();
        
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
        jQuery.ajax({
            type: "POST",
            url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_guideuniversal.php",
            dataType: "text",
            data: "id="+id+"&group="+group+"&filter_name="+filter_name+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&key=edit_attr",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
 
    jQuery(document).on('click','.add_detail', function(){
        var id = 0;
        var name = jQuery('#name').val();
        var filter_name = jQuery('#filter_name').val();
        var table = '';//jQuery('#table').val();
        var enable_tmp = 0;
        var sort = jQuery('#sort').val();
        var group = jQuery('#group').val(); //<?php echo (int)$_GET['guide'];?>;
       
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
        
        if (name != "") {
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&group="+group+"&filter_name="+filter_name+"&name="+name+"&enable="+enable_tmp+"&sort="+sort+"&key=add_attr",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    location.reload();
                }
            });
        }
    });
    
    jQuery(document).on('click','.dell_detail', function(){
        var id = jQuery(this).data('id');
        var table ='';// jQuery('#table').val();
        
        if (confirm('Вы действительно желаете удалить фильтр?')){
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_guideuniversal.php",
                dataType: "text",
                data: "id="+id+"&key=dell_attr",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    jQuery('#'+id).hide();
                }
            });
        }
    });
    

</script>
