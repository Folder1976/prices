<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

$sql = 'SELECT * FROM '.DB_PREFIX.'main_page WHERE target="left_menu" ORDER BY sort;';
$r = $mysqli->query($sql) or die(';kjasvdbpn '.$sql);

$sql = "SELECT cp.category_id AS category_id,
        GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '1' AND cd2.language_id = '1'";
$sql .= " GROUP BY cp.category_id";
$r1 = $mysqli->query($sql) or die(';kjasvdbpn '.$sql);
$categories = array();
while($row = $r1->fetch_assoc()){
   $categories[$row['category_id']] =  $row['name'];
}




?>
<br>
<h1>Категории в левом меню (главная страница)</h1>

<div style="width: 100%">
    <div class="table_body">
        
        <table class="text">
            <tr>
                <th>#</th>
                <th>Включено</th>
                <th style="width:400px;">Категория</th>
                <th>Альтенативное название</th>
                <th>Сортировка</th>
            </tr>
            <tr>
                <td class="mixed">новый</td>
                <td class="mixed"><input type="checkbox"    id="enable"  checked ></td>
                <td class="mixed" ><input type="hidden"        id="category_id" value=""><a href="javascript:;" class="category_tree select_category" data-id="0"><span class="category_name" id="category_name">выбрать категорию</span></a></td>
                <td class="mixed"><input type="text"        id="name" style="width:300px;" value="" placeholder="Если пустое - будет название категории"></td>
                <td class="mixed"><input type="text"        id="sort" style="width:100px;" value="0"></td>
                <td>        
                    <a href="javascript:" class="add">
                        <img src="/<?php echo TMP_DIR; ?>backend/img/add.png" title="удалить" width="16" height="16">
                    </a>
                   </td>              
            </tr>
            <td>
                <td colspan="5">&nbsp;</td>
            </td>
        
        <?php while($ex = $r->fetch_assoc()){ ?>
            <?php
				$tmp = $ex['params'];
				if(strpos($tmp, '##') !== false){
					$tmp = explode('##', $tmp);
					$params = $tmp[0];
					$name = $tmp[1];
				}else{
					$params = $tmp;
					$name = '';
				}
			?>
              <tr id="<?php echo $ex['id'];?>">
                <td class="mixed"><?php echo $ex['id'];?></td>
                <td class="mixed"><input type="checkbox"  class="edit"  id="enable<?php echo $ex['id'];?>"  <?php if($ex['enable']) echo 'checked';?> ></td>
                <td class="mixed" style="text-align: left;"><input type="hidden"    id="category_id<?php echo $ex['id'];?>" value="<?php echo $params; ?>"><a href="javascript:;" class="category_tree select_category" data-id="<?php echo $ex['id'];?>"><span class="category_name<?php echo $ex['id'];?>" id="category_name<?php echo $ex['id'];?>"><?php echo $categories[$params];?></span></a></td>
                <td class="mixed"><input type="text"      class="edit"  id="name<?php echo $ex['id'];?>" style="width:300px;" value="<?php echo $name;?>" placeholder="Если пустое - будет название категории"></td>
                <td class="mixed"><input type="text"      class="edit"  id="sort<?php echo $ex['id'];?>" style="width:100px;" value="<?php echo $ex['sort'];?>"></td>
                <td>        
                    <a href="javascript:" class="dell">
                        <img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16">
                    </a>
                   </td>              
            </tr>
        
            
        <?php } ?>
        </table>
    </div>
</div>

<input type="hidden"  class="table"  id="table" value="main_page">
<script>
    jQuery(document).on('click','.add', function(){
		
		var id = 0;
        var category_id = jQuery('#category_id').val();
        var sort = jQuery('#sort').val();
        var name = jQuery('#name').val();
        var enable_tmp = 0;
        var table = jQuery('#table').val();
        
        if (jQuery('#enable').prop('checked')) {
             enable_tmp = 1;
        }
        
		if (name != '') {
            category_id = category_id+'##'+name;
        }
		
        //if (category_id != 0) {
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
                dataType: "text",
                data: "sort="+sort+"&params="+category_id+"&target=left_menu&enable="+enable_tmp+"&table="+table+"&key=add",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    location.reload();
                }
            });
        //}
        
    });
    
    jQuery(document).on('change','.edit', function(){
       
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var enable_tmp = 0;
        var category_id = jQuery('#category_id'+id).val();
        var sort = jQuery('#sort'+id).val();
		var name = jQuery('#name'+id).val();
        var table = jQuery('#table').val();
        
        if (jQuery('#enable'+id).prop('checked')) {
             enable_tmp = 1;
        }
        
		if (name != '') {
            category_id = category_id+'##'+name;
        }
		
        jQuery.ajax({
            type: "POST",
            url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
            dataType: "text",
            data: "id="+id+"&params="+category_id+"&enable="+enable_tmp+"&sort="+sort+"&table="+table+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                console.log( msg );
            }
        });
        
    });
    jQuery(document).on('click','.dell', function(){
       
        var id = jQuery(this).parent('td').parent('tr').attr('id');
        var table = jQuery('#table').val();
        if (confirm('Вы действительно желаете удалить категорию?')){
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
                dataType: "text",
                data: "id="+id+"&table="+table+"&key=dell",
                beforeSend: function(){
                },
                success: function(msg){
						console.log( msg );
                     jQuery('#'+id).hide()
                }
            });
        }
    });
</script>