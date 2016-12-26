<?
if($_POST['importlist']){
	
	
	$menu=querytoarray("select * from menu where tip=0 and status=1");

	$file=$_FILES['import']['tmp_name'];
	
	
	require('excel_reader/reader.php');
	$connection = new Spreadsheet_Excel_Reader();
	$connection->setOutputEncoding('UTF-8');
	$connection->read($file);
	
	
	$list=$connection->sheets[1]['cells'];
	echo '<pre>';
	
	$mymenuid=0;
	$mybrendid=0;
	
	for($i=1;$i<sizeof($list);$i++){
		$name=ltrim(rtrim($list[$i][1]));
		if(sizeof($list[$i])==1){
			
			$id=rand(111111,99999999);
			
			if(queryresult("select id from menu where name='$name' or dopname like '%$name%' and dopname!=''","id")){
				echo '- <b>Категория:</b> '.$name.'<br>';
				$mymenuid=queryresult("select id from menu where name='$name' or dopname like '%$name%' and dopname!=''","id");
			}
			elseif(queryresult("select id from brend where name='$name' or dopname like '%$name%' and dopname!=''","id")){
				echo '- - <b>Бренд:</b> '.$name.'<br>';
				$mybrendid=queryresult("select id from brend where name='$name' or dopname like '%$name%' and dopname!=''","id");
			}
			else{
				$mymenuid=0;
				$mybrendid=0;
				
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
		elseif($list[$i][2]!=''){
			$name=ltrim(rtrim($list[$i][2]));
			$max=0;
			$max=strpos($name,',');
			$max_sko=strpos($name,'(');
			$max_kva=strpos($name,'[');
			$max_tza=strpos($name,';');
			
			$test=1;
			
			if($max_sko>10 && $max>$max_sko || $max==0 && $max_sko>0){$max=$max_sko;$test=2;}
			if($max>0 && $max_kva>0 && $max>$max_kva){$max=$max_kva;$test=3;}
			if($max>0 && $max_tza>0 && $max>$max_tza){$max=$max_tza;$test=4;}
			
			
			
			
			if($max){$name=substr($name,0,$max);}
			else{$name=$name;}
			
			if($mymenuid && $mybrendid){
				if(!queryresult("select id from products where name='$name'",'id')){
					if(!$_POST['testcategory']){
						echo '- - '.$mymenuid.' - '.$mybrendid.' - Товар: '.$name.'<br>';
					}
					if($_POST['addautomate']){
						mysql_query("insert into products(name,status,wmotmenuid,brendid) values('$name','1','$mymenuid','$mybrendid')");
					}
				}
			}else{
				echo '- - '.$mymenuid.' - '.$mybrendid.' - Товар: '.$name.'<br>';
				//echo "x ";
			}
		}
		
		
	}
}
?>