<?
session_start();

define('A2', true);
define('A2_CNFG', true);
include("../init.a2.php");
set_time_limit(0);

if($_GET['addbrend']){
	if(!queryresult("select id from brend where name='".$_GET['addbrend']."'",'id')){
		mysql_query("insert into brend(name,status,secretkey) values('".$_GET['addbrend']."','1','".$_GET['addbrend']."')") or die(mysql_error());
	}
	exit();
}
elseif($_GET['addfoto']){
	$pid=intval($_GET['pid']);
	if(!queryresult("select id from product_fotos where productid=$pid and image='".urldecode($_GET['addfoto'])."'",'id')){
		mysql_query("insert into product_fotos(productid,image,status) values('$pid','".urldecode($_GET['addfoto'])."','1')") or die(mysql_error());
		mysql_query("update products set imageok=1 where id=$pid");
	}
	exit();
}
elseif($_GET['addcategory']){
	if(!queryresult("select id from menu where name='".$_GET['addcategory']."'",'id')){
		$mid=intval($_GET['mid']);
		$tip=intval($_GET['tip']);
		mysql_query("insert into menu(name,status,wmotmenuid,tip) values('".$_GET['addcategory']."','1','$mid','$tip')") or die(mysql_error());
	}
	exit();
}
elseif($_GET['addcategoryas']){
	if(!queryresult("select id from menu where dopname like '%".$_GET['addcategoryas']."%'",'id')){
		$mid=intval($_GET['mid']);
		
		$alldopname=explode(',',queryresult("select dopname from menu where id=$mid",'dopname'));
		array_push($alldopname,$_GET['addcategoryas']);	
		$newdopname=implode(',',$alldopname);
		
		mysql_query("update menu set dopname='$newdopname' where id=$mid") or die(mysql_error());
	}
	exit();
}
elseif($_GET['mid']){
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

a2tpl_header();
?>
<script type="text/javascript" src="<?=$config['aw_path']?>js/jquery.js"></script>
<script>
function addbrend(name,id){
	
	$.ajax({
        type: "GET", 
        url: "init.php?addbrend="+name+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $('#addbrendid'+id).html('<img src="dizain/loading.gif">');
			$('#categoryblokno'+id).html('');
        },
        success: function( data ) {
            $('#addbrendid'+id).html('');
        }
    });
}

function addfoto(img){
	
	$.ajax({
        type: "GET", 
        url: "init.php?addfoto="+encodeURI($(img).attr('src'))+"&pid="+$(img).attr('pid')+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $(img).attr('src','<img src="dizain/loading.gif">');
        },
        success: function( data ) {
           $(img).hide();
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
        url: "init.php?addcategoryas="+name+"&mid="+mid+"&tip="+tip+"&r="+Math.floor(Math.random()*5000),
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
        url: "init.php?addcategory="+name+"&mid="+mid+"&tip="+tip+"&r="+Math.floor(Math.random()*5000),
        beforeSend: function() {
            $('#categoryblokno'+id).html('<img src="dizain/loading.gif">');
			$('#addbrendid'+id).html('');
        },
        success: function( data ) {
            $('#categoryblokno'+id).html('');
        }
    });
}
</script>