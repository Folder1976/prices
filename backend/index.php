<?php

mb_internal_encoding("UTF-8");

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


//Загонем сессию по пользователю
include('../config.php');
include('config.php');
session_start();

if(!isset($_SESSION['default'])){
	header('Location: /'.TMP_DIR.'admin');
    die();
}

if(!isset($_SESSION['default']['user_id']) AND (int)$_SESSION['default']['user_id'] < 1){
    header('Location: /'.TMP_DIR.'admin');
    die();
}
	header("Content-Type: text/html; charset=UTF-8");
	
    include_once('class/users.class.php');
	$Users = new Users($mysqli, DB_PREFIX);


header("Content-Type: text/html; charset=UTF-8");
?>


<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/css/backend.css?v1">
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/css/main_menu.css">
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/css/ui/style.css">
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/css/new_style.css">
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/jquery.js"></script>
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/ui/jquery-ui.js"></script>
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/log.js"></script>
<script>
    var tmp_dir = "<?php echo TMP_DIR; ?>";
</script>



<!-- SmartMenus core CSS (required) -->
<link href="/<?php echo TMP_DIR;?>backend/libs/main_menu/src/css/sm-core-css.css" rel="stylesheet" type="text/css" />
<!-- "sm-simple" menu theme (optional, you can use your own CSS, too) -->
<link href="/<?php echo TMP_DIR;?>backend/libs/main_menu/src/css/sm-simple/sm-simple.css" rel="stylesheet" type="text/css" />
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- jQuery -->
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/libs/main_menu/src/libs/jquery/jquery.js"></script>
<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/libs/main_menu/src/jquery.smartmenus.js"></script>


<!-- SmartMenus jQuery init -->
<script type="text/javascript">
	$(function() {
		console.log('load menu');
		$('#main-menu').smartmenus({
			mainMenuSubOffsetX: -1,
			subMenusSubOffsetX: 10,
			subMenusSubOffsetY: 0
		});
	});
</script>

<?php $user_menus = $Users->getUserMainMenu((int)$_SESSION['default']['user_id']); ?>    
<?php $user_sub_menus = $Users->getUserSubMenu((int)$_SESSION['default']['user_id']); ?>    
<?php $functions = array(); ?>
<nav id="main-nav" role="navigation">
	<ul id="main-menu" class="sm sm-simple">
		<!--li class="ui-state-disabled">Aberdeen</li-->
	<?php foreach($user_menus AS $group_index => $user_menu){ ?>
		<?php if(isset($user_menu['name'])){ ?>
			<li><a href="javascript:"><?php echo $user_menu['name']; ?></a>
			<?php if(isset($user_menu['menu']) AND count($user_menu['menu']) > 0){ ?>
				<ul>
					<?php foreach($user_menu['menu'] AS $index => $menu){ ?>
						<?php if($menu['is_show'] == 1 ){ ?>
							<li><a href="/<?php echo TMP_DIR;?>backend/index.php?route=<?php echo $menu['dir'].'/'.$menu['file']; ?>"><?php echo $menu['name']; ?></a>
								<?php if(isset($user_sub_menus[$index])){ ?>
									<ul>
										<?php foreach($user_sub_menus[$index] AS $sub_index => $sub_menu){ ?>
											<?php if(isset($sub_menu['is_show']) AND $sub_menu['is_show'] == 1 ){ ?>
												<li><a href="/<?php echo TMP_DIR;?>backend/index.php?route=<?php echo $sub_menu['dir'].'/'.$sub_menu['file']; ?>"><?php echo $sub_menu['name']; ?></a></li>
												<?php $functions[$sub_menu['dir'].'/'.$sub_menu['file']] = 1; ?>
											<?php } ?>
										<?php } ?>
									</ul>
								<?php } ?>
							</li>
							
						<?php } ?>
						<?php $functions[$menu['dir'].'/'.$menu['file']] = 1; ?>
						
					<?php } ?>
				</ul>
			<?php } ?>
		<?php } ?>
		</li>
	<?php } ?>
	<li style="background-color: #95FF91;">
		<a href="/<?php echo TMP_DIR;?>admin">Админка опенкарт</a>
	</li>
</ul>
</nav>


<!--ul class="main_menu">
    <li><a href="/backend/index.php?route=import">Импорт товаров (ручной режим)</a></li>
    <li><a href="/backend/index.php?route=importcron">Импорт товаров (Настройка cron)</a></li>
    <li><a href="/backend/" style="color: green;">Вернуться в старое меню</a></li>
</ul-->
<div style="clear: both;"></div>
<style>
 
	html, body {
        height: 100%;
        width: 100%;
        overflow: auto;
        }
	
</style>



<?php

//if(isset($_GET[]))
if(isset($_GET['route'])){
    	
	if(isset($functions[$_GET['route']])){
		include($_GET['route']);
	}
	/*
    if($_GET['route'] == 'import'){
        include('import/import_magazin_product.php');
    }

    if($_GET['route'] == 'importcron'){
        include('import/import_cron_main.php');
    }
    
    if($_GET['route'] == 'moderation'){
        include('moderation/product.moderation.php');
    }
    */

}

?>