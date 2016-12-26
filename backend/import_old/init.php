<?
session_start();
header("Content-Type: text/html; charset=utf-8");

define('A2', true);
define('A2_CNFG', true);


include("../a2_config.php");
$db=mysql_connect($db_host,$db_username,$db_password) or die('Mysql cant connect to server!');
mysql_select_db($db_name,$db) or die('Mysql cant select DB!');
mysql_query("SET NAMES 'utf8'");



include("../a2_functions.php");
include("../parts/tpl_functions.a2.php");


$gtconfig=setconfig();
$dater=date("Y-m-d");  
$timer=date("H:i:s");
$sizeofget=sizeof($_GET);



set_time_limit(0);


if(isset($_GET['changebrendcash'])){
	mysql_query("update tempfolder set brendid=".intval($_GET['brid'])." where id=".$_GET['changebrendcash']);
}
elseif(isset($_GET['addbrend'])){
	$name=mysql_real_escape_string(urldecode(str_replace('--PLUS--','+',$_GET['addbrend'])));


	if(!queryresult("select id from brend where name='$name'",'id')){
		mysql_query("insert into brend(name,status,secretkey) values('$name','1','$name')") or die(mysql_error());
	}
	exit();
}
elseif(isset($_GET['savetogroups'])){
	$pid=intval($_GET['pid']);
	$groupname=mysql_real_escape_string(urldecode(str_replace('--PLUS--','+',$_GET['savetogroups'])));
	if($groupname=='')exit();
	if(!$pid)exit();
	
	$groupid=queryresult("select id from products_modification where name='$groupname'",'id');
	
	if(!$groupid){
		mysql_query("insert into products_modification(modifications,name) values('$pid','$groupname')");
		$groupid=queryresult("select id from products_modification where name='$groupname'",'id');
	}
	else{
		$mods=queryresult("select modifications from products_modification where id=".$groupid,'modifications');
		$old=explode(',',$mods);
		if(!in_array($pid,$old)){
			array_push($old,$pid);
			$newarray=implode(',',$old);
			mysql_query("update products_modification set modifications='$newarray' where id=".$groupid);
			
			mysql_query("update products set modification=1 where id=".$pid);
		}
	}
	mysql_query("update products set modificationid=$groupid where id=".$pid);
	exit();
}
elseif(isset($_GET['todopname'])){
	$pid=intval($_GET['pid']);
	$groupname=mysql_real_escape_string(str_replace('--PLUS--','+',urldecode($_GET['todopname'])));
	$groupnamex=mysql_real_escape_string(str_replace('--PLUS--','+',urldecode($_GET['todopnamex'])));
	if($groupname=='')exit();
	if($groupnamex=='')exit();
	if($pid=='')exit();
	


	$groupid=queryresult("select id from products where name='$groupnamex'",'id');
	$dopname=queryresult("select name from products where id=$pid",'name');
	
	if(!$groupid){
		mysql_query("update products set name='$groupnamex' where id=$pid");
		$groupid=$pid;
	}
	elseif($pid!=$groupid){
		mysql_query("update productdopnames set productid=$groupid where productid=$pid");
		mysql_query("update products_compare set productid=$groupid where productid=$pid");
		mysql_query("update comentary set productid=$groupid where productid=$pid");
		mysql_query("update product_fotos set productid=$groupid where productid=$pid");
		mysql_query("update product_prices set productid=$groupid where productid=$pid");
		mysql_query("delete from products where id=$pid");
	}
	
	if($dopname!=$groupname){
		if(!queryresult("select id from productdopnames where productid=$groupid and name='$dopname'",'id')){

$main=($pid==$groupid)?1:0;

			mysql_query("insert into productdopnames(productid,dopname,ident,`main`) 
values('$groupid','$dopname','$pid','$main')");
		}
	}
	
	exit();
}
elseif(isset($_GET['addfoto'])){
	$pid=intval($_GET['pid']);
	if(!queryresult("select id from product_fotos where productid=$pid and image='".urldecode($_GET['addfoto'])."'",'id')){
		mysql_query("insert into product_fotos(productid,image,status) values('$pid','".urldecode($_GET['addfoto'])."','1')") or die(mysql_error());
		mysql_query("update products set imageok=1 where id=$pid");
	}
	exit();
}
elseif(isset($_GET['changemenuidall'])){
	$pid=intval($_GET['pid']);
	mysql_query("update products set wmotmenuid=".intval($_GET['changemenuidall'])." where id=$pid");
	exit();
}
elseif(isset($_GET['brchangemenuidall'])){
	$pid=intval($_GET['pid']);
	mysql_query("update products set brendid=".intval($_GET['brchangemenuidall'])." where id=$pid");
	exit();
}
elseif(isset($_GET['addcategory'])){
	if(!queryresult("select id from menu where name='".urldecode($_GET['addcategory'])."'",'id')){
		$mid=intval($_GET['mid']);
		$tip=intval($_GET['tip']);
		mysql_query("insert into menu(name,status,wmotmenuid,tip) values('".urldecode($_GET['addcategory'])."','1','$mid','$tip')") or die(mysql_error());
	}
	exit();
}
elseif(isset($_GET['addblacklist'])){
	$name=str_replace('--PLUS--','+',urldecode($_GET['addblacklist']));
	
	echo $name;

	if(!queryresult("select id from menublacklist where name='$name'",'id')){
		mysql_query("insert into menublacklist(name) values('$name')");
	}

	exit();
}
elseif(isset($_GET['addcategoryas'])){
	$mid=intval($_GET['mid']);
	$name=urldecode(str_replace('--PLUS--','+',$_GET['addcategoryas']));

	$name=str_replace('`',"''",$name);

	if(!queryresult("select id from menudopnames where wmotmenuid=$mid and name='$name'",'id')){
		mysql_query("insert into menudopnames(wmotmenuid,name) values('$mid','$name')");
	}

	exit();
}
/*добавление в список игнора*/
elseif(isset($_GET['addignorlist'])){
	$mid=intval($_GET['mid']);
	$magazin_id= intval($_GET['magazin_id']);
	$name=urldecode(str_replace('--PLUS--','+',$_GET['addignorlist']));
	$name=ltrim(rtrim(str_replace('`',"''",$name)));
	$keywords=str_replace('`',"''",$_GET['keywords']);
	if(!queryresult("select id from parser_division_exclusion where category_name='$name'")){
		mysql_query("insert into parser_division_exclusion(magazin_id,category_name,division_name_ex,category_id) values('$magazin_id','$name','$keywords','$mid')")or die(mysql_error());
	}
	else {
		$updArray=Array();
		$division_name_ex='';
		$updArray=queryresult("select id,division_name_ex from parser_division_exclusion where category_name='$name'");
		$division_name_ex=$updArray['division_name_ex'].','.$keywords;
		mysql_query("Update parser_division_exclusion set division_name_ex='".$division_name_ex."' where id=".$updArray['id']) or die(mysql_error());
	}
	
	exit();
}

/*добавление в parser_division*/
elseif(isset($_GET['addparsdivision'])){
	$mid=intval($_GET['mid']);
	$magazin_id= intval($_GET['magazin_id']);
	$name=urldecode(str_replace('--PLUS--','+',$_GET['addparsdivision']));
	$name=ltrim(rtrim(str_replace('`',"''",$name)));
	$keywords=str_replace('`',"''",$_GET['keywords']);
	
	if(!queryresult("select id from parser_division where category_id=$mid and category_name='$name' and division_name='$keywords'",'id')){
		mysql_query("insert into parser_division(magazin_id,category_name,division_name,category_id) values('$magazin_id','$name','$keywords','$mid')");
	}

	exit();
}
/*добавление в parser_prev*/
elseif(isset($_GET['addparserprev'])){
	$mid=intval($_GET['mid']);
	$shop_id=intval($_GET['shop_id']);
	$name=urldecode(str_replace('--PLUS--','+',$_GET['addparserprev']));
	$name=ltrim(rtrim(str_replace('`',"''",$name)));
	$prev_name=str_replace('`',"''",urldecode(str_replace('--PLUS--','+',$_GET['prev_name'])));
	$last_name=str_replace('`',"''",urldecode(str_replace('--PLUS--','+',$_GET['last_name'])));
	
	if(!queryresult("select id from parser_prev where shop_id='$shop_id' and category_id=$mid and name='$name' and prev_name='$prev_name' and last_name='$last_name'",'id')){
		mysql_query("insert into parser_prev(shop_id,prev_name,name,last_name,category_id) values('$shop_id','$prev_name','$name','$last_name','$mid')");
	}

	exit();
}

/*-----------------------------------*/


elseif(isset($_GET['mid'])){
	$mid=intval($_GET['mid']);
	$data=querytoarray("select * from menu where wmotmenuid=$mid and status=1 order by name");
	if($data['rows']){
		echo '<option value="0">Выберите категорию</option>';
	}
	for($i=0;$i<$data['rows'];$i++){
		echo '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'('.queryresult("select count(*) as total from menu where status=1 and wmotmenuid=".$data[$i]['id'],'total').')</option>';
	}
	exit();
}
elseif(isset($_GET['update_slepok'])){
	$update_slepok=intval($_GET['update_slepok']);
	
	mysql_query("UPDATE parser_magazin SET compare='". base64_decode($_POST['compare']) ."' where magazin_id=$update_slepok");

	exit();
}

a2tpl_header();
?>
<script type="text/javascript" src="<?=$config['aw_path']?>js/jquery.js"></script>
<script>
function update_slepok(shop_id,compare){
	$.ajax({
        type: "POST", 
        url: "init.php?update_slepok="+encodeURIComponent(shop_id)+"&r="+Math.floor(Math.random()*5000),
		data: { compare: compare },
        beforeSend: function() {
			
        },
        success: function( data ) {

        }
    });
}
function addbrend(name,id){
	alert(name);
	$.ajax({
        type: "GET", 
        url: "init.php?addbrend="+encodeURIComponent(name)+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $('#addbrendid'+id).html('<img src="dizain/loading.gif">');
			$('#categoryblokno'+id).html('');
        },
        success: function( data ) {

            $('#addbrendid'+id).html('');
        }
    });
}
function changebrendcash(id,bid){
	
	$.ajax({
        type: "GET", 
        url: "init.php?changebrendcash="+id+"&brid="+bid+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function(){},
        success: function(data){}
    });
}

function addfoto(img){
	$('.products').each(function(index, element) {
		if($(this).attr('checked')==true){
			$.ajax({
				type: "GET", 
				url: "init.php?addfoto="+encodeURIComponent($(img).attr('src'))+"&pid="+$(this).val()+"&r="+Math.floor(Math.random()*5000),
				beforeSend: function() {
					
				},
				success: function( data ) {
				   $(img).hide();
				}
			});	
		}
    });
}

function saveasoneproducts(){
	$('.products').each(function(index, element) {
		if($(this).attr('checked')==true){
			$.ajax({
				type: "GET", 
				url: "init.php?todopname="+encodeURIComponent($('#searchindatabaseint').val())+"&todopnamex="+encodeURIComponent($('#searchindatabaseintx').val())+"&pid="+$(this).val()+"&r="+Math.floor(Math.random()*5000),
				beforeSend: function() {
					
				},
				success: function( data ) {
				
				}
			});	
		}
    });
	
	alert("Выбранные товары совмещены и отмечены как один товар! Нажмите поиск");
}

function savetogroups(){
	$('.products').each(function(index, element) {
		if($(this).attr('checked')==true){
			$.ajax({
				type: "GET", 
				url: "init.php?savetogroups="+encodeURIComponent($('#searchindatabaseint').val())+"&pid="+$(this).val()+"&r="+Math.floor(Math.random()*5000),
				beforeSend: function() {
					
				},
				success: function( data ) {
					
				}
			});	
		}
    });
	
	alert("Выбранные товары объеденены в одну группу!");
}

function changemenuidall(id){
	$('.products').each(function(index, element) {
		if($(this).attr('checked')==true){
			var pid=$(this).val();
			$.ajax({
				type: "GET", 
				url: "init.php?changemenuidall="+id+"&pid="+pid+"&r="+Math.floor(Math.random()*5000),
				beforeSend: function() {
					
				},
				success: function( data ) {
					selected_state(pid,id);
				}
			});	
		}
    });
}

function brchangemenuidall(id){
	$('.products').each(function(index, element) {
		if($(this).attr('checked')==true){
			var pid=$(this).val();
			$.ajax({
				type: "GET", 
				url: "init.php?brchangemenuidall="+id+"&pid="+pid+"&r="+Math.floor(Math.random()*5000),
				beforeSend: function() {
					
				},
				success: function( data ) {
					selected_state(pid,id);
				}
			});	
		}
    });
}

function selected_state(id,sel){
    $("#menuidselectno"+id+" option").each(function(){
        if($(this).val() == sel){
            $(this).attr("selected","selected");
            return false;
        }
    });
}

function setnewlist(id,tip,mid){
	$.ajax({
        type: "GET", 
        url: "init.php?mid="+mid+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            
        },
        success: function( data ) {
            $('#set_subcategory'+tip+'_'+id).html(data);
			
			if(tip==2){
				 $('#set_subcategory3_'+id).html('');
				 $('#set_subcategory4_'+id).html('');
			}
			else if(tip==1){
				 $('#set_subcategory2_'+id).html('');
				 $('#set_subcategory3_'+id).html('');
				 $('#set_subcategory4_'+id).html('');
			}
        }
    });
}

function addcategoryas(name,id){
	var mid=0;
	var tip=0;
	
	if($('#set_subcategory4_'+id).find("option:selected").val()){
		mid=$('#set_subcategory4_'+id).find("option:selected").val();
		tip=4;
		if(mid=='0'){
			tip=3;
			mid=$('#set_subcategory3_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory3_'+id).find("option:selected").val()){
		mid=$('#set_subcategory3_'+id).find("option:selected").val();
		tip=3;
		if(mid=='0'){tip=2;
			mid=$('#set_subcategory2_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory2_'+id).find("option:selected").val()){
		mid=$('#set_subcategory2_'+id).find("option:selected").val();
		tip=2;
		if(mid==0){tip=1;
			mid=$('#set_subcategory1_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory1_'+id).find("option:selected").val()){
		mid=$('#set_subcategory1_'+id).find("option:selected").val();
		tip=1;
		
		if(mid==0){
			mid=$('#set_subcategory0_'+id).find("option:selected").val();
			if(mid==0){tip=0;}
			else{tip=1;}
		}
	}
	else if($('#set_subcategory0_'+id).find("option:selected").val()){
		mid=$('#set_subcategory0_'+id).find("option:selected").val();
		tip=0;
	}
	
	$.ajax({
        type: "GET", 
        url: "init.php?addcategoryas="+encodeURIComponent(name)+"&mid="+mid+"&tip="+tip+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $('#categoryblokno'+id).html('<img src="dizain/loading.gif">');
			$('#addbrendid'+id).html('');
        },
        success: function( data ) {
            $('#categoryblokno'+id).html('');
        }
    });
}

function addcategory(name,id){
	var mid=0;
	var tip=0;
	
	if($('#set_subcategory4_'+id).find("option:selected").val()){
		mid=$('#set_subcategory4_'+id).find("option:selected").val();
		tip=4;
		if(mid=='0'){
			tip=3;
			mid=$('#set_subcategory3_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory3_'+id).find("option:selected").val()){
		mid=$('#set_subcategory3_'+id).find("option:selected").val();
		tip=3;
		if(mid=='0'){tip=2;
			mid=$('#set_subcategory2_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory2_'+id).find("option:selected").val()){
		mid=$('#set_subcategory2_'+id).find("option:selected").val();
		tip=2;
		if(mid==0){tip=1;
			mid=$('#set_subcategory1_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory1_'+id).find("option:selected").val()){
		mid=$('#set_subcategory1_'+id).find("option:selected").val();
		tip=1;
		
		if(mid==0){
			mid=$('#set_subcategory0_'+id).find("option:selected").val();
			if(mid==0){tip=0;}
			else{tip=1;}
		}
	}
	else if($('#set_subcategory0_'+id).find("option:selected").val()){
		mid=$('#set_subcategory0_'+id).find("option:selected").val();
		tip=0;
	}
	
	
	$.ajax({
        type: "GET", 
        url: "init.php?addcategory="+encodeURIComponent(name)+"&mid="+mid+"&tip="+tip+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $('#categoryblokno'+id).html('<img src="dizain/loading.gif">');
			$('#addbrendid'+id).html('');
        },
        success: function( data ) {
            $('#categoryblokno'+id).html('');
        }
    });
}
function addignorlist(magazin_id,name,id){
	var mid=0;
	var keywors='';
	keywords=$('#ignor_key_'+id).val();
	
	
	
	if (keywords=='') {alert('Укажите ключевые слова!!!'); exit();}
		
	if($('#set_subcategory4_'+id).find("option:selected").val()){
		mid=$('#set_subcategory4_'+id).find("option:selected").val();
		
		if(mid==0){
			
			mid=$('#set_subcategory3_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory3_'+id).find("option:selected").val()){
		mid=$('#set_subcategory3_'+id).find("option:selected").val();
		
		if(mid==0){
			mid=$('#set_subcategory2_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory2_'+id).find("option:selected").val()){
		mid=$('#set_subcategory2_'+id).find("option:selected").val();
		
		if(mid==0){
			mid=$('#set_subcategory1_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory1_'+id).find("option:selected").val()){
		mid=$('#set_subcategory1_'+id).find("option:selected").val();
		
		
		if(mid==0){
			mid=$('#set_subcategory0_'+id).find("option:selected").val();
			
		}
	}
	else if($('#set_subcategory0_'+id).find("option:selected").val()){
		mid=$('#set_subcategory0_'+id).find("option:selected").val();

	}

	$.ajax({
        type: "GET", 
        url: "init.php?addignorlist="+encodeURIComponent(name)+"&magazin_id="+magazin_id+"&mid="+mid+"&keywords="+keywords,
        beforeSend: function() {
            $('#categoryblokno'+id).html('<img src="dizain/loading.gif">');
			$('#addbrendid'+id).html('');
        },
        success: function( data ) {
            $('#categoryblokno'+id).html(' - добавлен в исключения');
        }
    });
	
}

function addblacklist(name, id){
	$.ajax({
        type: "GET", 
        url: "init.php?addblacklist="+name+"&id="+id+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $('#categoryblokno'+id).html('<img src="dizain/loading.gif">');
			$('#addbrendid'+id).html('');
        },
        success: function( data ) {
            $('#categoryblokno'+id).html('');
        }
    });
}

function addparserprev(shop_id,name,id){
	var mid=0;
	var prev_name='';
	var next_name='';
	if ($('#panel_row_'+id).prevAll('.panel_row:first').find('.error2').find('.category_name').html()){
		prev_name=$('#panel_row_'+id).prevAll('.panel_row:first').find('.error2').find('.category_name').html();		
	}
	
	if ($('#panel_row_'+id).nextAll('.panel_row:first').find('.error2').find('.category_name').html()){
		next_name=$('#panel_row_'+id).nextAll('.panel_row:first').find('.error2').find('.category_name').html();		
	}
	
	
	if($('#set_subcategory4_'+id).find("option:selected").val()){
		mid=$('#set_subcategory4_'+id).find("option:selected").val();
		
		if(mid==0){
			
			mid=$('#set_subcategory3_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory3_'+id).find("option:selected").val()){
		mid=$('#set_subcategory3_'+id).find("option:selected").val();
		
		if(mid==0){
			mid=$('#set_subcategory2_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory2_'+id).find("option:selected").val()){
		mid=$('#set_subcategory2_'+id).find("option:selected").val();
		
		if(mid==0){
			mid=$('#set_subcategory1_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory1_'+id).find("option:selected").val()){
		mid=$('#set_subcategory1_'+id).find("option:selected").val();
		
		
		if(mid==0){
			mid=$('#set_subcategory0_'+id).find("option:selected").val();
			
		}
	}
	else if($('#set_subcategory0_'+id).find("option:selected").val()){
		mid=$('#set_subcategory0_'+id).find("option:selected").val();
	}
	
	if (mid==0) {alert('Укажите категорию!!!'); exit();}
	
	$.ajax({
		type:"GET",
		url: "init.php?addparserprev="+name+"&shop_id="+shop_id+"&prev_name="+prev_name+"&last_name="+next_name+"&mid="+mid+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $('#categoryblokno'+id).html('<img src="dizain/loading.gif">');
			$('#addbrendid'+id).html('');
        },
        success: function( data ) {
            $('#categoryblokno'+id).html(' - добавлен в parser_prev');
        }
	})
}

function addparsdivision(magazin_id,name,id){
	var mid=0;
	var keywors='';
	keywords=$('#ignor_key_'+id).val();
	
	
	
	if (keywords=='') {alert('Укажите ключевые слова!!!'); exit();}
		
	if($('#set_subcategory4_'+id).find("option:selected").val()){
		mid=$('#set_subcategory4_'+id).find("option:selected").val();
		
		if(mid==0){
			
			mid=$('#set_subcategory3_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory3_'+id).find("option:selected").val()){
		mid=$('#set_subcategory3_'+id).find("option:selected").val();
		
		if(mid==0){
			mid=$('#set_subcategory2_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory2_'+id).find("option:selected").val()){
		mid=$('#set_subcategory2_'+id).find("option:selected").val();
		
		if(mid==0){
			mid=$('#set_subcategory1_'+id).find("option:selected").val();
		}
	}
	else if($('#set_subcategory1_'+id).find("option:selected").val()){
		mid=$('#set_subcategory1_'+id).find("option:selected").val();
		
		
		if(mid==0){
			mid=$('#set_subcategory0_'+id).find("option:selected").val();
			
		}
	}
	else if($('#set_subcategory0_'+id).find("option:selected").val()){
		mid=$('#set_subcategory0_'+id).find("option:selected").val();

	}
	if (mid==0) {alert('Укажите категорию!!!'); exit();}
	$.ajax({
        type: "GET", 
        url: "init.php?addparsdivision="+encodeURIComponent(name)+"&magazin_id="+magazin_id+"&mid="+mid+"&keywords="+keywords,
        beforeSend: function() {
            $('#categoryblokno'+id).html('<img src="dizain/loading.gif">');
			$('#addbrendid'+id).html('');
        },
        success: function( data ) {
            $('#categoryblokno'+id).html('  добавлен в parser_division');
        }
    });
	
}
function checkboxClick(id, elem){
	if ($(".checkboxImport"+id).length > 0) {
		if ($(elem).is(":checked")) {
			$(".checkboxImport"+id+", .checkboxImportMain"+id).attr("checked", "checked").prop("checked", true);
		}
		else {
			$(".checkboxImport"+id+", .checkboxImportMain"+id).attr("checked", "").prop("checked", false);
		}
	}
}
/*
$(document).ready(function(){
	$(document).on("click", ".checkboxImport", function(){
		console.log(1);
	});
});*/
</script>
<a href="cron_updatecounters.php">RECOUNT PRODUCTS</a> <===>
<a href="groups.php">ADD GROUPS</a> <===>
<a href="groupbrends.php">BREND GROUPS</a> <===>
<a href="import_chars.php">IMPORT CHARASTERISTICS</a> <===>
<a href="import_images.php">IMPORT IMAGES</a> <===>
<a href="m.ua.php">IMPORT CHARASTERISTICS</a> <===>
<a href="parser_products.php">IMPORT PRODUCTS</a> <===> 
<a href="parser_setup.php">IMPORT SETUP</a>
