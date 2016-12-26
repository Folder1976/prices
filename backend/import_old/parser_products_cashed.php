<?
include("init.php");

$minfpp=50;
?>
<form action="#action" method="post" enctype="multipart/form-data">
<table>
<input type="hidden" name="importlist" value="1">
	<tr>
    	<td>Тип файла:</td> <td><select name="importtype">
    	<option <? if(!$_POST['importtype']){echo 'selected="selected"';} ?> value="">Выберите тип файла</option>
        <?
        $data=querytoarray("select * from magazin where status=1 and importopt!='' order by name");
		for($i=0;$i<$data['rows'];$i++){
		?>
        	<option <? if($_POST['importtype']==$data[$i]['importopt'].','.$data[$i]['id']){echo 'selected="selected"';} ?> value="<?=$data[$i]['importopt']?>,<?=$data[$i]['id']?>">
            	<?=$data[$i]['name']?>
            </option>
        <?
		}
		?>
        <!--
        Стандарт значение -  это 
        Название - Цена - гарантия - cells
        -->
    </select></td></tr>
    <tr><td>Выберите файл: <td><input type="file" name="import" value="<?=$_FILES['import']?>"></td></tr>
    <tr><td rowspan="5">Настройки</td><td><input type="checkbox" name="testcategory" <? if($_POST['testcategory']){echo 'checked';} ?>>Тестирование категорий(Товары будут скрыты)</td></tr>
    <tr><td><input type="checkbox" name="addautomate" <? if($_POST['addautomate']){echo 'checked';} ?>>Добавить определенные товары в базу и показать только не неопределенные товары</td></tr>
        <tr><td><input type="checkbox" name="addautomateprices" <? if($_POST['addautomateprices']){echo 'checked';} ?>>Автоматически добавлять цены</td></tr>
		<tr><td><input type="checkbox" name="testfile" <? if($_POST['testfile']){echo 'checked';} ?>>FILE STRUCTURE TEST</td></tr>
        <tr><td><input type="input" style="width:100px;" value="<?=($_POST['fpp'])?$_POST['fpp']:$minfpp?>" name="fpp" <? if($_POST['testfile']){echo 'checked';} ?>>Строк на 1 странице</td></tr>

    <tr><td><input type="submit" value="Импортировать"></td></tr>
</table>
</form>
<?


//import file to DB
if($_POST['importlist']){
	mysql_query("truncate tempfolder") or die(mysql_error());
	$conect=explode(',',$_POST['importtype']);
	$file=$_FILES['import']['tmp_name'];
	
	require('excel_reader/reader.php');
	$connection = new Spreadsheet_Excel_Reader();
	$connection->setOutputEncoding('UTF8');
	$connection->read($file);
	
	$list=$connection->sheets[$conect[3]]['cells'];
	
	
	
	if($_POST['testfile']){echo '<pre>';print_r($connection->sheets);exit();}
	
	
	for($i=1;$i<sizeof($list);$i++){
		//detect category
		if(sizeof($list[$i])==1 && $list[$i][$conect[4]]!='' || sizeof($tesifpr)<3 && $list[$i][$conect[4]]!=''){
			$name=ltrim(rtrim($list[$i][$conect[4]]));
			/*
			//if is brend name
			$btestid=queryresult("select id from brend where name='$name'","id");
			if(!$btestid){
				$btestid=queryresult("select brendid from brenddopnames where dopname='$name'",'brendid');
			}
			
			if($btestid){$datatype=2;}
			
			//else if menu name
			if(!$btestid){
				$mtestid=queryresult("select id from menu where name='$name'","id");
				if(!$mtestid){
					$mtestid=queryresult("select wmotmenuid from menudopnames where dopname='$name'",'wmotmenuid');
				}
			}*/
			
			if($mtestid){$datatype=1;}
			
			$price='';
		}
		//else product name
		else{
			$name=ltrim(rtrim($list[$i][$conect[0]]));
			$datatype=0;
		}
		
		$price=ltrim(rtrim($list[$i][$conect[1]]));
		$garant=ltrim(rtrim($list[$i][$conect[2]]));
		
		mysql_query("insert into tempfolder(name,garant,price,magazinid,brendid,wmotmenuid,datatype) 
		values('$name','$garant','$price','".$conect[5]."','$btestid','$mtestid','$datatype')");
	}
}
elseif(sizeof($_POST['products'])){
	mysql_query("");
}

echo '<div style="width:100%;clear:both;line-height:30px;">Импортированные данные</div>';

function brendtest($key){
	$mybrendid_test=queryresult("select id from brend where name='$key'","id");
	if(!$mybrendid_test){
		$mybrendid_test=queryresult("select brendid from brenddopnames where dopname='$key'",'brendid');
	}
	
	return $mybrendid_test;
}

function producttest($key){
	$mybrendid_test=queryresult("select id from products where name='$key'","id");
	if(!$mybrendid_test){
		$mybrendid_test=queryresult("select productid from productdopnames where dopname='$key'",'productid');
	}
	
	return $mybrendid_test;
}

function menuidtest($key){
	$mybrendid_test=queryresult("select id from menu where name='$key'","id");
	if(!$mybrendid_test){
		$mybrendid_test=queryresult("select wmotmenuid from menudopnames where dopname='$key'",'wmotmenuid');
	}
	
	return $mybrendid_test;
}

function detectedproduct($id,$key){
	//echo 'DETECT: '.$key.'<hr>';
	$dbr=explode(' ',$key);
	$sizeof=sizeof($dbr);
	
	$status=1;
	$mybrendid_test=producttest($key);
	$sizeof--;
	while(!$mybrendid_test && $status){
		if($sizeof>1){
			$dbr[$sizeof]='';
			$str=ltrim(rtrim(implode(' ',$dbr)));
			$last=substr($str,strlen($str)-1,strlen($str));
			if($last==',' || $last=='(' || $last==')' || $last=='/'){$str=rtrim(substr($str,0,strlen($str)-1));}
			
			//echo $str.'<br>';
			if($str!=''){
				$mybrendid_test=producttest($str);
			}
			if($mybrendid_test){$status=0;}
		}else{$status=0;}
		$sizeof--;
	}
	
	if($mybrendid_test){
		mysql_query("update tempfolder set productid=$mybrendid_test where id=".$id);
		return queryresult("select name from products where id=".$mybrendid_test,'name');
	}
	
	return '-';
}

function detect(){
	$mymenuid=0;
	$data=querytoarray("select * from tempfolder order by id asc");
	for($i=0;$i<$data['rows'];$i++){
		//detect brend
		$dbr=explode(' ',$data[$i]['name']);
		$sizeof=sizeof($dbr);
		
		$mybrendid_test=brendtest($dbr[0]);
		if(!$mybrendid_test && $sizeof>1)$mybrendid_test=brendtest($dbr[1]);
		if(!$mybrendid_test && $sizeof>2)$mybrendid_test=brendtest($dbr[2]);
		if(!$mybrendid_test && $sizeof>3)$mybrendid_test=brendtest($dbr[3]);
		if(!$mybrendid_test && $sizeof>4)$mybrendid_test=brendtest($dbr[4]);
		
		
		$test_mymenuid=menuidtest($data[$i]['name']);
		if($test_mymenuid){$mymenuid=$test_mymenuid;}
		
		mysql_query("update tempfolder set brendid=$mybrendid_test,wmotmenuid=$mymenuid where id=".$data[$i]['id']);
		
		
	}
	
}

if($_GET['func']=='redetect'){
	detect();
}

$fpp=($_POST['fpp'])?$_POST['fpp']:$minfpp;
$limiter=intval($_GET['limiter']);
$sort=($_GET['sort'])?$_GET['sort']:'id';
$orderby=($_GET['orderby'])?$_GET['orderby']:'asc';

$s=($_GET['s'])?$_GET['s']:'';
$wmotmenuid=queryresult("select wmotmenuid from tempfolder where id=".$_GET['grouby'],'wmotmenuid');
$brendid=queryresult("select brendid from tempfolder where id=".$_GET['grouby'],'brendid');
	
if($s){
	$groupis=($_GET['grouby'])?" and wmotmenuid=$wmotmenuid or name like '%".$s."%' and brendid=$brendid":'';
	$data=querytoarray("select * from tempfolder where name like '%".$s."%' $groupis order by $sort $orderby limit ".($fpp*$limiter).",$fpp");
}
else{
	
	$groupis=($_GET['grouby'])?" where wmotmenuid=$wmotmenuid and wmotmenuid!=0 or brendid=$brendid and brendid!=0":'';
	$data=querytoarray("select * from tempfolder $groupis order by $sort $orderby limit ".($fpp*$limiter).",$fpp");
}
	$datag=querytoarray("select id,wmotmenuid,brendid from tempfolder where price=0 and garant=0 group by name");
?>
<style>
tr{ color:#535657; font-size:14px; line-height:17px;}
.onstat td{ background:#FFCC99;}
.rows:hover td{background:#E5F1A1;}

.pageon td{ width:25px; background:#F7F7F7;}
</style>
<script>

function GetSelectedText () {
    if (window.getSelection) {  // all browsers, except IE before version 9
        var range = window.getSelection ();
        return range.toString();
    } 
    else {
        if (document.selection.createRange) { // Internet Explorer
            var range = document.selection.createRange ();
            return range.text;
        }
    }
	return '';
}

document.oncontextmenu = function() {return false;};
$(document).ready(function() {
	$('#action').click(function() {
		$('#rmenu').css('display','none');
		return false; 
	}); 
	jQuery.expr[':'].contains = function(a, i, m) {
	  return jQuery(a).text().toUpperCase()
		  .indexOf(m[3].toUpperCase()) >= 0;
	};
	
	$('#action').mousedown(function(e){ 
		if( e.button == 2 ) { 
		   if($('#rmenu').css('display')=='block'){
		   	  $('#rmenu').css('top',e.pageY);
			  $('#rmenu').css('left',e.pageX);
		   }
		   else{
		  		$('#rmenu').css('display','block');
		   }
		  return false; 
		} 
		return true; 
	});
	
	$(document).mousemove(function(e){
		if($('#rmenu').css('display')!='block'){
			$('#rmenu').css('top',e.pageY);
			$('#rmenu').css('left',e.pageX);
		}
	});
	
	$('.originaltext').mouseup(function() {
		var selection = GetSelectedText();
		if(selection!='undefined' && selection!='' && selection){
			$('.products:input').attr('checked',false);
			$('.rows').removeClass('onstat');
			$('.pageon2').addClass('pageon').removeClass('pageon2');
			$('.rows > td.originaltext:contains("'+selection+'")').each(function() {
				if($('#rowsno'+$(this).attr('data')).hasClass('pageon')){$('#rowsno'+$(this).attr('data')).addClass('pageon2').removeClass('pageon');}
				$('#rowsno'+$(this).attr('data')).addClass('onstat');
				$('#rowsno'+$(this).attr('data')).find('.products').attr('checked',true);
			});
		}
	});
	
	$('.products').change(function(e){
        if($(this).attr('checked')==true){
			$(this).parents(this).parents(this).removeClass('onstat');
		}
		else{
			$(this).parents(this).parents(this).addClass('onstat');
		}
    });
	
	$('.rows').click(function(e){
        if($(this).hasClass('onstat')){
			$(this).removeClass('onstat');
			if($(this).hasClass('pageon2')){$(this).removeClass('pageon2').addClass('pageon');}
			$('#productno'+$(this).attr("data")).attr('checked',false);
		}
		else{
			$(this).addClass('onstat');
			if($(this).hasClass('pageon')){$(this).removeClass('pageon').addClass('pageon2');}
			$('#productno'+$(this).attr("data")).attr('checked',true);
			
		}
    });
});
</script>
<table width="100%" id="action" border="1" style="border-collapse:collapse;">
	<tr>
    	<td colspan="100%">Функции: 
        	<a href="?s=<?=$s?>&sort=<?=$_GET['sort']?>&orderby=<?=$_GET['orderby']?>&limiter=<?=$_GET['limiter']?>&func=redetect">Определить категории и бренды</a>
        </td>
    </tr>
    <tr>
        <td colspan="100%">
        	Страницы: 
            <?
			if($s){
				$max=round(queryresult("select count(*) as total from tempfolder where name like '%$s%'",'total')/$fpp);
			}
			else{
				$max=round(queryresult("select count(*) as total from tempfolder",'total')/$fpp);
			}
            for($i=0;$i<$max;$i++){
				echo '<a '.(($_GET['limiter']==$i)?' class="pageon"':'').' href="?s='.$s.'&sort='.$sort.'&orderby='.$orderby.'&limiter='.$i.'#action">'.$i.'</a>&nbsp;&nbsp; - ';
			}
			?>
        </td>
        
    </tr>
	<tr>
   		<td width="15"><a href="javascript:;" onclick="$('.products').attr('checked','checked');">Выб</a>/<a href="javascript:;" onclick="$('.products').attr('checked','');">Уб</a></td>
        <td width="100">Brend</td>
        
    	
        <td><form action="#action" method="get">Название <a <?=($_GET['sort']=='name' && $_GET['orderby']=='asc')?' class="pageon"':''?> href="?s=<?=$s?>&sort=name&orderby=asc#action">&uarr;</a>&nbsp;&nbsp;<a href="?s=<?=$s?>&sort=name&orderby=desc#action" <?=($_GET['sort']=='name' && $_GET['orderby']=='desc')?' class="pageon"':''?>>&darr;</a> 
        	Поиск: 
            <input type="hidden" name="sort" value="<?=$_GET['sort']?>">
            <input type="hidden" name="orderby" value="<?=$_GET['orderby']?>">
            <input type="hidden" name="limiter" value="<?=$_GET['limiter']?>">
            <input type="text" name="s" value="<?=$_GET['s']?>" style="width:300px;">
            <input type="submit" value="искать">
        	    
        </form>
        <select onchange="document.location.href='parser_products_cashed.php?grouby='+this.value+'&s=<?=$s?>&sort=<?=$_GET['sort']?>&orderby=<?=$_GET['orderby']?>&limiter=<?=$_GET['limiter']?>#action';">
        	<?
            for($i=0;$i<$datag['rows'];$i++){
				$groupis=' where wmotmenuid='.$datag[$i]['wmotmenuid']." and wmotmenuid!=0 or brendid=".$datag[$i]['brendid']." and brendid!=0";
				
				echo '<option '.(($_GET['grouby']==$datag[$i]['id'])?'selected="selected"':'').' value="'.$datag[$i]['id'].'">'.queryresult("select name from tempfolder where id=".$datag[$i]['id'],'name').'('.queryresult("select count(*) as total from tempfolder $groupis",'total').')</option>';
			}
			?>
        </select>
        </td>
        <td>
        	Определенный товар <a <?=($_GET['sort']=='productid' && $_GET['orderby']=='asc')?' class="pageon"':''?> href="?s=<?=$s?>&sort=productid&orderby=asc#action">&uarr;</a>&nbsp;&nbsp;<a href="?s=<?=$s?>&sort=productid&orderby=desc#action" <?=($_GET['sort']=='productid' && $_GET['orderby']=='desc')?' class="pageon"':''?>>&darr;</a>
        </td>
        
       <td width="120">Категория <a <?=($_GET['sort']=='wmotmenuid' && $_GET['orderby']=='asc')?' class="pageon"':''?> href="?s=<?=$s?>&sort=wmotmenuid&orderby=asc#action">&uarr;</a>&nbsp;&nbsp;<a href="?s=<?=$s?>&sort=wmotmenuid&orderby=desc#action" <?=($_GET['sort']=='wmotmenuid' && $_GET['orderby']=='desc')?' class="pageon"':''?>>&darr;</a></td>
       
        <td width="50">Цена <a <?=($_GET['sort']=='price' && $_GET['orderby']=='asc')?' class="pageon"':''?> href="?s=<?=$s?>&sort=price&orderby=asc#action">&uarr;</a>&nbsp;&nbsp;<a href="?s=<?=$s?>&sort=price&orderby=desc#action" <?=($_GET['sort']=='price' && $_GET['orderby']=='desc')?' class="pageon"':''?>>&darr;</a></td>
        <td width="50">Гарантия <a <?=($_GET['sort']=='garant' && $_GET['orderby']=='asc')?' class="pageon"':''?> href="?s=<?=$s?>&sort=garant&orderby=asc#action">&uarr;</a>&nbsp;&nbsp;<a href="?s=<?=$s?>&sort=garant&orderby=desc#action" <?=($_GET['sort']=='garant' && $_GET['orderby']=='desc')?' class="pageon"':''?>>&darr;</a></td>
    	
    </tr>
    <form action="" method="post">
	
<?
$menu=querytoarray("select * from brend where status=1 order by name");
$menuhtml='';
for($j=0;$j<$menu['rows'];$j++){
	$menuhtml.='<option value="'.$menu[$j]['id'].'">'.$menu[$j]['name'].'</option>';
}

for($i=0;$i<$data['rows'];$i++){
	?>
	<tr class="rows<?=($i%2)?' pageon':''?>" id="rowsno<?=$data[$i]['id']?>" data="<?=$data[$i]['id']?>">
    	<td><input type="checkbox" name="products[]" id="productno<?=$data[$i]['id']?>" class="products" value="<?=$data[$i]['id']?>"></td>
        <td style="padding-right:10px;"><select name="menuid" onfocus="$('#productno<?=$data[$i]['id']?>').attr('checked','checked');" onchange="changebrendcash(<?=$data[$i]['id']?>,this.value)" id="menuidselectno<?=$data[$i]['id']?>">
    	<?
        echo str_replace('value="'.$data[$i]['brendid'].'"','value="'.$data[$i]['brendid'].'" selected="selected"',$menuhtml);
		?>
    </select></td>
        
    	<td title="Выделите название товара" class="originaltext" data="<?=$data[$i]['id']?>"><?=$data[$i]['name']?></td>
        <td class="dbtextno<?=$data[$i]['id']?>"><?=($data[$i]['productid'])?queryresult("select name from products where id=".$data[$i]['productid'],'name'):detectedproduct($data[$i]['id'],$data[$i]['name'])?></td>
        
        
        <td align="center"><?=($data[$i]['wmotmenuid'])?queryresult("select name from menu where id=".$data[$i]['wmotmenuid'],'name'):'-'?></td>
        
        
        <td align="center"><?=$data[$i]['price']?></td>
        <td align="center"><?=$data[$i]['garant']?></td>
    </tr>
	<?
}
?></form></table>
<style>
#rmenu{width:300px; position:absolute; display:none; background:#FFF; border:#003 1px solid; border-radius:5px;}
</style>

<div id="rmenu">wefwefwef</div>
<?



exit();


$dater=date("Y-m-d");
if($_POST['importlist']){
	$menu=querytoarray("select * from menu where tip=0 and status=1");
	$file=$_FILES['import']['tmp_name'];
	
	
	
	
	
	
	echo '<pre>';
	if($_POST['testfile']){print_r($connection->sheets);exit();}
	
	
	
	$mymenuid=0;
	$mybrendid=0;
	
	for($i=1;$i<sizeof($list);$i++){
		unset($tesifpr);
		$tesifpr=explode(' ',ltrim(rtrim($list[$i][$conect[0]])));
		
		if(sizeof($list[$i])==1 && $list[$i][$conect[4]]!='' || sizeof($tesifpr)<3 && $list[$i][$conect[4]]!=''){
		    //$name=iconv('','utf-8',$list[$i][$conect[4]]);
			$name=ltrim(rtrim($list[$i][$conect[4]]));
			
			$id=rand(111111,99999999);
			
$btestid=queryresult("select id from brend where name='$name'","id");
if(!$btestid){
	$btestid=queryresult("select brendid from brenddopnames where dopname='$name'",'brendid');
}
if(!$btestid){
	$mtestid=queryresult("select id from menu where name='$name'","id");
	if(!$mtestid){
		$mtestid=queryresult("select wmotmenuid from menudopnames where dopname='$name'",'wmotmenuid');
	}
}

			if($btestid){
				echo '- - <b>Бренд:</b> '.$name.'<br>';
				$mybrendid=$btestid;
			}
			elseif($mtestid){
				echo '- <b>Категория:</b> '.$name.'<br>';
				$mymenuid=$mtestid;
			}
			else{

				$mymenuid=0;
				//$mybrendid=0;

				echo '<b>Категория не определена:</b> '.$name.' <a href="javascript:;" onclick="addbrend(\''.$name.'\',\''.$id.'\');" id="addbrendid'.$id.'">[Добавить в бренды]</a> -  <span id="categoryblokno'.$id.'">[';
				?><select id="set_subcategory0_<?=$id?>" onChange="setnewlist(<?=$id?>,1,this.value);"><option value="0">Выберите категорию</option>
					<?
					for($j=0;$j<$menu['rows'];$j++){
						echo '<option value="'.$menu[$j]['id'].'">'.$menu[$j]['name'].'</option>';
					}
					?>
				</select><select id="set_subcategory1_<?=$id?>" onChange="setnewlist(<?=$id?>,2,this.value);"></select><select 
				id="set_subcategory2_<?=$id?>" onChange="setnewlist(<?=$id?>,3,this.value);"></select><select 
				id="set_subcategory3_<?=$id?>" onChange="setnewlist(<?=$id?>,4,this.value);"></select><select 
				id="set_subcategory4_<?=$id?>"></select> Добавить как: <a href="javascript:;" onClick="addcategory('<?=$name?>',<?=$id?>);">новая запись</a> - <a href="javascript:;" onClick="addcategoryas('<?=$name?>',<?=$id?>);">доп.название</a><?
				
				echo ']</span><br>';
			}
		}
		elseif($list[$i][$conect[0]]!=''){

			$name=$list[$i][$conect[0]];
			$name=ltrim(rtrim($name));
/*
			$max=0;
			$max=strpos($name,',');
			$max_sko=strpos($name,'(');
			$max_kva=strpos($name,'[');
			$max_tza=strpos($name,';');
			$max_bsl=strpos($name,'/');
			
			$test='0';
			
			if($max_sko>10 && $max>$max_sko || $max==0 && $max_sko>0){$max=$max_sko;$test=2;}
			if($max>0 && $max_kva>0 && $max>$max_kva){$max=$max_kva;$test=3;}
			if($max>0 && $max_tza>0 && $max>$max_tza){$max=$max_tza;$test=4;}
			if($max>0 && $max_bsl>0 && $max>$max_bsl){$max=$max_bsl;$test=5;}
			
			*/
			
			
			//if($max){$name=substr($name,0,$max);}
			//else{$name=$name;}
			
			$price=ltrim(rtrim($list[$i][$conect[1]]));
			$price=str_replace(',','.',$price);
			$price=number_format($price,2,'.','');
			

//detect brend
unset($dbr);
$dbr=explode(' ',iconv('','utf-8',$name));

if(strpos('x'.strtolower($dbr[0]),'intel')){$dbr[0]='Intel';}
elseif(strpos('x'.strtolower($dbr[1]),'intel')){$dbr[1]='Intel';}


if(sizeof($dbr)){
	$mybrendid_test=queryresult("select id from brend where name='".$dbr[0]."'","id");
	if(!$mybrendid_test){
		$mybrendid_test=queryresult("select brendid from brenddopnames where dopname='".$dbr[0]."'",'brendid');
	}


	if($mybrendid_test){$mybrendid=$mybrendid_test;}
	else{
		$mybrendid_test=queryresult("select id from brend where name='".$dbr[1]."'","id");

		if(!$mybrendid_test){
			$mybrendid_test=queryresult("select brendid from brenddopnames where dopname='".$dbr[1]."'",'brendid');
		}


		if($mybrendid_test){$mybrendid=$mybrendid_test;}
		else{
			$mybrendid_test=queryresult("select id from brend where name='".$dbr[2]."'","id");


			if(!$mybrendid_test){
				$mybrendid_test=queryresult("select brendid from brenddopnames where dopname='".$dbr[2]."'",'brendid');
			}

			if($mybrendid_test){$mybrendid=$mybrendid_test;}
			else{
				$mybrendid_test=queryresult("select id from brend where name='".$dbr[3]."'","id");


				if(!$mybrendid_test){
					$mybrendid_test=queryresult("select brendid from brenddopnames where dopname='".$dbr[3]."'",'brendid');
				}

				if($mybrendid_test){$mybrendid=$mybrendid_test;}
			}
		}
	}
}

			if($mymenuid && $mybrendid){
				$pid=queryresult("select id from products where name='$name'",'id');
				if(!$pid){
					$pid=queryresult("select productid from productdopnames where dopname='$name'",'productid');
				}
				
				if(!$pid){
					if(!$_POST['testcategory'] && !$_POST['addautomate']){
						echo '- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from brend where id=$mybrendid","name"):'No').' - Товар: '.$name.'<br>';
					}
					if($_POST['addautomate'] && $mybrendid>0 && $mymenuid>0){
						mysql_query("insert into products(name,status,wmotmenuid,brendid) values('$name','1','$mymenuid','$mybrendid')");
						$pid=queryresult("select id from products order by id desc limit 0,1",'id');
						mysql_query("insert into product_prices(name,productid,status,magazinid,price,garant,dater) 
						values('".ltrim(rtrim($list[$i][$conect[0]]))."','$pid','1','".$conect[5]."','$price','".ltrim(rtrim($list[$i][$conect[2]]))."','$dater')") or die(mysql_error());
					}
					
				}else{
					$oldprice=queryresult("select price from product_prices where productid=$pid and magazinid=".$conect[5]." and dater=curdate() order by id desc limit 0,1",'price');
					if($_POST['addautomateprices'] && $oldprice<$price){
						if($oldprice>0){
							$did=queryresult("select id from product_prices where productid=$pid and magazinid=".$conect[5]." and dater=curdate() order by id desc limit 0,1",'id');
							mysql_query("delete from product_prices where id=$did");
						}
						
						mysql_query("insert into product_prices(name,productid,status,magazinid,price,garant,dater) 
						values('".ltrim(rtrim($list[$i][$conect[0]]))."','$pid','1','".$conect[5]."','$price','".ltrim(rtrim($list[$i][$conect[2]]))."','$dater')") or die(mysql_error());
						
					}
				}
echo $test.'- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from brend where id=$mybrendid","name"):'No').' - Товар: '.$name.'<br>';
				
			}else{
				//$name=iconv('','utf-8',$list[$i][$conect[0]]);$name=ltrim(rtrim($name));
				echo $test.'- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from brend where id=$mybrendid","name"):'No').' - Товар: '.$name.'<br>';
				//echo "x ";
			}
		}
		
		
	}
}
?>