<script type="text/javascript" src="/<?php echo TMP_DIR; ?>admin/view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="/<?php echo TMP_DIR; ?>admin/view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="/<?php echo TMP_DIR; ?>admin/view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

<link href="/<?php echo TMP_DIR; ?>admin/view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="/<?php echo TMP_DIR; ?>admin/view/javascript/summernote/summernote.js"></script>
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

$table = 'alias_description';
$main_key = 'id';

$is_best = 0;
if(isset($_POST['is_best'])) $is_best = 1;
$domain_is_best = 0;
if(isset($_POST['domain_is_best'])) $domain_is_best = 1;
		
if(isset($_GET['form_save'])){
	
	if(isset($_POST['add']) OR $_POST['seo_id'] < 1){
		
		$sql = 'INSERT INTO '.DB_PREFIX.$table.' SET
							`name` = "'.htmlspecialchars($_POST['name'], ENT_QUOTES).'",
							`name_sush` = "'.htmlspecialchars($_POST['name_sush'], ENT_QUOTES).'",
							`name_rod` = "'.htmlspecialchars($_POST['name_rod'], ENT_QUOTES).'",
							`name_several` = "'.htmlspecialchars($_POST['name_several'], ENT_QUOTES).'",
							`title` = "'.htmlspecialchars($_POST['title'], ENT_QUOTES).'",
							`title_h1` = "'.htmlspecialchars($_POST['title_h1'], ENT_QUOTES).'",
							`url` = "'.$_POST['url'].'",
							`category_id` = "'.$_POST['category_id'].'",
							`section_id` = "'.$_POST['section_id'].'",
							`is_best` = "'.$is_best.'",
							`text1` = "'.htmlspecialchars($_POST['text1'], ENT_QUOTES).'",
							`text2` = "'.htmlspecialchars($_POST['text2'], ENT_QUOTES).'",
							`date_edited` = "'.date('Y-m-d H:i:s').'"
						';	
		
		$mysqli->query($sql) or die($sql);
		$seo_id = $mysqli->insert_id;
		
		$sql = 'INSERT INTO '.DB_PREFIX.$table.'_domain SET
							`id` = "'.$seo_id.'",
							`title` = "'.htmlspecialchars($_POST['domain_title'], ENT_QUOTES).'",
							`title_h1` = "'.htmlspecialchars($_POST['domain_title_h1'], ENT_QUOTES).'",
							`is_best` = "'.$domain_is_best.'",
							`text1` = "'.htmlspecialchars($_POST['domain_text1'], ENT_QUOTES).'",
							`text2` = "'.htmlspecialchars($_POST['domain_text2'], ENT_QUOTES).'"
						';	
		
		$mysqli->query($sql) or die($sql);

	}else{
	
		$sql = 'UPDATE '.DB_PREFIX.$table.' SET
							`name` = "'.htmlspecialchars($_POST['name'], ENT_QUOTES).'",
							`name_sush` = "'.htmlspecialchars($_POST['name_sush'], ENT_QUOTES).'",
							`name_rod` = "'.htmlspecialchars($_POST['name_rod'], ENT_QUOTES).'",
							`name_several` = "'.htmlspecialchars($_POST['name_several'], ENT_QUOTES).'",
							`title` = "'.htmlspecialchars($_POST['title'], ENT_QUOTES).'",
							`title_h1` = "'.htmlspecialchars($_POST['title_h1'], ENT_QUOTES).'",
							`url` = "'.$_POST['url'].'",
							`category_id` = "'.(int)$_POST['category_id'].'",
							`section_id` = "'.(int)$_POST['section_id'].'",
							`is_best` = "'.(int)$is_best.'",
							`text1` = "'.htmlspecialchars($_POST['text1'], ENT_QUOTES).'",
							`text2` = "'.htmlspecialchars($_POST['text2'], ENT_QUOTES).'",
							`date_edited` = "'.date('Y-m-d H:i:s').'"
				WHERE id = "'.(int)$_POST['seo_id'].'"
						';	
		$mysqli->query($sql) or die($sql);
		$seo_id = (int)$_POST['seo_id'];
		
		$sql = 'DELETE FROM '.DB_PREFIX.$table.'_domain WHERE `id` = "'.$seo_id.'"';
		$mysqli->query($sql) or die($sql);
		
		$sql = 'INSERT INTO '.DB_PREFIX.$table.'_domain SET
							`id` = "'.$seo_id.'",
							`title` = "'.htmlspecialchars($_POST['domain_title'], ENT_QUOTES).'",
							`title_h1` = "'.htmlspecialchars($_POST['domain_title_h1'], ENT_QUOTES).'",
							`is_best` = "'.$domain_is_best.'",
							`text1` = "'.htmlspecialchars($_POST['domain_text1'], ENT_QUOTES).'",
							`text2` = "'.htmlspecialchars($_POST['domain_text2'], ENT_QUOTES).'"
						';	
		$mysqli->query($sql) or die('<br>sadliflkasjdfhlkj  '.$sql);

	}
	
	?>
	<script>
		$(document).ready(function(){
			location.href = "/<?php echo TMP_DIR; ?>backend/index.php?route=seo/seo.index.php&seoedit=<?php echo $seo_id; ?>";	
		});
	</script>
	<?php
	return true;
	//header('Location: /backend/index.php?route=seo/seo.index.php&seoedit='.$seo_id);
}


?>
<title>СЕО</title>
<div style="margin: 20px;">
	<h2>СЕО Категорий</h2>

	Выбрать категорию для работы <a href="javascript:;" class="select_category" data-target="list">[дерево]</a></label>
	<br>Список привязок описаний <a href="javascript:;" id="all_alias_list">[список по ЧПУ]</a></label>
</div>



<div class="description-list table_body">
<?php if(isset($_GET['seoedit'])){ ?>
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/css/elfinder.full.css">
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/css/theme.css">
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/js/elfinder.min.js"></script>
<script src="/<?php echo TMP_DIR; ?>backend/js/elFinder-master/js/i18n/elfinder.ru.js"></script>

<?php
	
	echo 'Редактируем СЕО';

	$sql = 'SELECT * FROM '.DB_PREFIX.$table.'  WHERE id = "'.(int)$_GET['seoedit'].'"';
	$r = $mysqli->query($sql) or die($sql);
	
	$sql = 'SELECT * FROM '.DB_PREFIX.$table.'_domain  WHERE id = "'.(int)$_GET['seoedit'].'"';
	$r1 = $mysqli->query($sql) or die($sql);
	$row_domain = array();
	if($r1->num_rows){
		$row_domain = $r1->fetch_assoc();
		$data['domain_title'] = $row_domain['title'];
		$data['domain_title_h1'] = $row_domain['title_h1'];
		$data['domain_is_best'] = $row_domain['is_best'];
		$data['domain_text1'] = $row_domain['text1'];
		$data['domain_text2'] = $row_domain['text2'];
	}else{
		$data['domain_title'] = '';
		$data['domain_title_h1'] = '';
		$data['domain_is_best'] = '';
		$data['domain_text1'] = '';
		$data['domain_text2'] = '';
	}
	
	
	if($r->num_rows){
		$row = $r->fetch_assoc();
		$data['id'] = $row['id'];
		$data['name'] = $row['name'];
		$data['name_sush'] = $row['name_sush'];
		$data['name_rod'] = $row['name_rod'];
		$data['name_several'] = $row['name_several'];
		$data['title'] = $row['title'];
		$data['title_h1'] = $row['title_h1'];
		$data['url'] = $row['url'];
		$data['category_id'] = $category_id = $row['category_id'];
		$data['section_id'] = $row['section_id'];
		$data['is_best'] = $row['is_best'];
		$data['text1'] = $row['text1'];
		$data['text2'] = $row['text2'];

		$sql = "SELECT DISTINCT *,
								(SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;')
										FROM " . DB_PREFIX . "category_path cp
										LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id)
										WHERE cp.category_id = c.category_id GROUP BY cp.category_id) AS path,
								(SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias
										WHERE query = 'category_id=" . (int)$category_id . "') AS keyword
								FROM " . DB_PREFIX . "category c
										LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id)
		
										WHERE c.category_id = '" . (int)$row['category_id'] . "'";
		
	
		$r_c = $mysqli->query($sql);
		
		$data['category_name'] = 'нет';
		$data['category_url'] = 'нет';
		if($r_c->num_rows){
			$row = $r_c->fetch_assoc();
			$data['category_name'] = $row['path'];
			$data['category_url'] = $row['keyword'];
		}
		
	}else{
		$data['id'] = '';
		$data['name'] = '';
		$data['name_sush'] = '';
		$data['name_rod'] = '';
		$data['name_several'] = '';
		$data['title'] = '';
		$data['title_h1'] = '';
		$data['url'] = '';
		$data['category_id'] = '';
		$data['section_id'] = '';
		$data['is_best'] = '';
		$data['text1'] = '';
		$data['text2'] = '';
		$data['category_name'] = '';
		$data['category_url'] = '';
	
	}
	?>
	<style>
		.description-list{
			width: 100%;
			text-align: center;
		}
		.text input{
			width: 100%;
		}
		li.active{
			background-color: #527200;
		}
		.nav-tabs li{
			display: inline; /* Отображать как строчный элемент */
			margin-right: 5px; /* Отступ слева */
			border: 1px solid #000; /* Рамка вокруг текста */
			padding: 3px; /* Поля вокруг текста */
		}
	</style>

<form action="/<?php echo TMP_DIR; ?>backend/index.php?route=seo/seo.index.php&form_save" method="post">
<div class="panel-body">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#main_seo" data-toggle="tab">Основное</a></li>
		<li><a href="#domain_seo" data-toggle="tab">Для СубДоменов</a></li>
	</ul>
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->	
	<div class="tab-content">
		<div class="tab-pane active" id="main_seo"><h2>СЕО для Основного сайта</h2>
      
		<div class="main_seo tab-pane">
		<form action="/<?php echo TMP_DIR; ?>backend/index.php?route=seo/seo.index.php&form_save" method="post">
			<input type="submit" name="add" value="Добавить" style="padding: 10px;margin-right: 20px;">
			<?php if($_GET['seoedit'] > 0){ ?>
				<input type="submit" name="save" value="Сохранить" style="padding: 10px;">
			<?php } ?>
		<table class="text" style="width: 90%;margin-left: 20px;margin-top: 10px;">
			<tr>
				<th style="width: 100px;">Поле</th>
				<th style="width: 50%;">Значение</th>
				<th style="width: 100px;">Длина</th>
				<th>Фильтры</th>
			</tr>
			
			<tr>
				<td>URL</td>
				<td><input type="text" name="url" id="url" value="<?php echo $data['url']; ?>" placeholder="ЧПУ на которое будет применено описание"></td>
				<td></td>
				<td rowspan="13" style="vertical-align: top;">
					<ul><b>Памятка по кодам</b>
						<li>@min_price@ - Минимальная цена</li>
						<li>@products_count@ - Количество продуктов</li>
						<li>@shops_count@ - Количество магазинов</li>
						<li>@design_count@ - Количество дизайнеров</li>
						<li>@prev_year@ - Предыдущий год</li>
						<li>@now_year@ - Текущий год</li>
						<li>@next_year@ - Следующий год</li>
						<li>@dinamic_year@ - Динамический диапазон 2016-2016</li>
						<li>@city@ - Город [именительный] (<i>Москва</i>)</li>
						<li>@sity_to@ - Город [дательный] (<i>В Москву</i>)</li>
						<li>@city_on@ - Город [предложный](<i>По Москве</i>)</li>
                		<li>@city_rod@ - Город [родительный](<i>Чего? Москвы</i>)</li>
						<li></li>
						<li>@block_name@ - Существительный (<i>белая блузка</i>)</li>
						<li>@block_name_rod@ - Родительный (<i>белую блузку</i>)</li>
						<li>@block_name_several@ - Множина (<i>белые блузки</i>)</li>
              
                
					</ul>
					
					<div class="tabs">
					<ul class="tab-links" id="filters_tabs">
						<li class="active"><a href="#tab1">Tab #1</a></li>
						<li><a href="#tab2">Tab #2</a></li>
					</ul>
				 
					<div class="tab-content" id="tab_content">
						<div id="tab1" class="tab active">
							<p>Tab #1 content goes here!</p>
							<p>Donec pulvinar neque sed semper lacinia. Curabitur lacinia ullamcorper nibh; quis imperdiet velit eleifend ac. Donec blandit mauris eget aliquet lacinia! Donec pulvinar massa interdum risus ornare mollis.</p>
						</div>
						<div id="tab2" class="tab">
							<p>Tab #2 content goes here!</p>
							<p>Donec pulvinar neque sed semper lacinia. Curabitur lacinia ullamcorper nibh; quis imperdiet velit eleifend ac. Donec blandit mauris eget aliquet lacinia! Donec pulvinar massa interdum risus ornare mollis.</p>
						</div>
					</div>
				</div>	
				</td>
				
			</tr>
			<tr>
				<td>Категория</td>
				<td>
					<input type="hidden" name="seo_id" id="seo_id" value="<?php echo $data['id']; ?>" placeholder="Категория">
					<input type="hidden" name="category_id" id="category_id" value="<?php echo $data['category_id']; ?>" placeholder="Категория">
					<input type="hidden" name="category_url" id="category_url" value="<?php echo $data['category_url']; ?>">
					<input type="text" name="category_name" id="category_name" value="<?php echo $data['category_name']; ?>"  placeholder="Категорию выбирать в дереве!" style="width: 60%;"> <a href="javascript:;" class="select_category" data-target="category">[дерево]</a>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Название</td>
				<td><input type="text" name="name" id="name" class="calculation" value="<?php echo $data['name']; ?>" placeholder="Название"></td>
				<td id="calculation_name"><b><?php echo mb_strlen($data['name'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td>Тайтл</td>
				<td><input type="text" name="title" id="title" class="calculation" value="<?php echo $data['title']; ?>" placeholder="Тайтл"></td>
				<td id="calculation_title"><b><?php echo mb_strlen($data['title'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td>Тайтл(view)</td>
				<td id="title_view"></td>
				<td id="calculation_title_view"><b><?php echo mb_strlen($data['title'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td>Тайтл H1</td>
				<td><input type="text" name="title_h1" id="title_h1" class="calculation" value="<?php echo $data['title_h1']; ?>" placeholder="Тайтл H1"></td>
				<td id="calculation_title_h1"><b><?php echo mb_strlen($data['title_h1'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td>Секция</td>
				<td><input type="text" name="section_id" id="section_id" value="<?php echo $data['section_id']; ?>" placeholder="Секция"></td>
				<td id="calculation_section_id"></td>
			</tr>
			<tr>
				<td>Лучший</td>
				<td align="left"><input type="checkbox" name="is_best" id="is_best" <?php if($data['is_best'] == 1) echo ' checked '; ?> style="width: 20px;"></td>
				<td id="calculation_is_best"></td>
			</tr>
		
		<!-- -------------- -->	
			<tr>
				<td>@block_name@ (белая блузка)</td>
				<td><input type="text" name="name_sush" id="name_sush" class="calculation" value="<?php echo $data['name_sush']; ?>" placeholder="@block_name@ (белая блузка)"></td>
				<td id="calculation_name_sush"><b><?php echo mb_strlen($data['name_sush'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td>@block_name_rod@ (белую блузку)</td>
				<td><input type="text" name="name_rod" id="name_rod" class="calculation" value="<?php echo $data['name_rod']; ?>" placeholder="@block_name_rod@ (белую блузку)"></td>
				<td id="calculation_name_rod"><b><?php echo mb_strlen($data['name_rod'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td>@block_name_several@ (белые блузки)</td>
				<td><input type="text" name="name_several" id="name_several" class="calculation" value="<?php echo $data['name_several']; ?>" placeholder="@block_name_several@ (белые блузки)"></td>
				<td id="calculation_name_several"><b><?php echo mb_strlen($data['name_several'], 'UTF-8'); ?> c.</b></td>
			</tr>
		<!-- -------------- -->
		
			<tr>
				<td style="vertical-align: top;">Meta-Description</td>
				<td>
					<!--button class="save_text" style="color:green;width: 150px;height: 30px;">Сохранить описание</button><br-->
					<textarea style="width: 100%; height: 200px;" id="text1" class="calculation_text product_names main_text_textarea" name="text1"><?php echo htmlspecialchars_decode($data['text1'], ENT_QUOTES); ?></textarea>
				</td>
				<td id="calculation_text1"><b><?php echo mb_strlen($data['text1'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td style="vertical-align: top;">Description [Описание на странице]</td>
				<td>
					<!--button class="save_text" style="color:green;width: 150px;height: 30px;">Сохранить описание</button><br-->
					<textarea style="width: 100%; height: 400px;" id="text2" class="calculation_text product_names main_text_textarea" name="text2"><?php echo htmlspecialchars_decode($data['text2'], ENT_QUOTES); ?></textarea>
				</td>
				<td id="calculation_text2"><b><?php echo mb_strlen($data['text2'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
</div>

<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
		<div class="tab-content">
			  </div>
			</div>
           <div class="tab-pane" id="domain_seo"><h2 style="color:blue;">СЕО для Суб доменов</h2>
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->	
		<div class="domain_seo tab-pane">

			<input type="submit" name="add" value="Добавить" style="padding: 10px;margin-right: 20px;">
			<?php if($_GET['seoedit'] > 0){ ?>
				<input type="submit" name="save" value="Сохранить" style="padding: 10px;">
			<?php } ?>
		<table class="text" style="width: 90%;margin-left: 20px;margin-top: 10px;">
			<tr>
				<th style="width: 100px;">Поле</th>
				<th style="width: 50%;">Значение</th>
				<th style="width: 100px;">Длина</th>
				<th>Фильтры</th>
			</tr>
			
			<tr>
				<td><font color="blue">SubDomain</font> Тайтл</td>
				<td><input type="text" name="domain_title" id="domain_title" class="calculation" value="<?php echo $data['domain_title']; ?>" placeholder="Тайтл"></td>
				<td id="calculation_title"><b><?php echo mb_strlen($data['title'], 'UTF-8'); ?> c.</b></td>
				<td rowspan="10" style="vertical-align: top;">
 <ul>Памятка по кодам
                    <li>* <b>@min_price@</b> - Минимальная цена</li>
                    <li>* <b>@products_count@</b> - Количество продуктов</li>
                    <li>* <b>@shops_count@</b> - Количество магазинов</li>
                    <li>* <b>@design_count@</b> - Количество дизайнеров</li>
                    <li>* <b>@prev_year@</b> - Предыдущий год</li>
                    <li>* <b>@now_year@</b> - Текущий год</li>
                    <li>* <b>@next_year@</b> - Следующий год</li>
                    <li>* <b>@dinamic_year@</b> - Динамический диапазон 2016-2016</li>
                    <li>* <b>@city@</b> - Город [именительный] (<i>Москва</i>)</li>
                    <li>* <b>@sity_to@</b> - Город [дательный] (<i>В Москву</i>)</li>
                    <li>* <b>@city_on@</b> - Город [предложный](<i>По Москве</i>)</li>
                    <li>* <b>@city_rod@</b> - Город [родительный](<i>Чего? Москвы</i>)</li>
                    <li></li>
                    <li>* <b>@Region@</b> - ***</li>
                    <li>* <b>@poRegionu@</b> - ***</li>
                    <li>* <b>@ChegoRegiona@</b> - ***</li>
                    <li>* <b>@People@</b> - ***</li>
                    <li>* <b>@LitlleCity@</b> - ***</li>
                    <li>* <b>@KodGoroda@</b> - ***</li>
                    <li>* <b>@Population@</b> - ***</li>
                     <li></li>
                    <li>* <b>@DateandTime@</b> - дата и время - текущее автоматом</li>
                     <li></li>
                    <li>* <b>@block_name@</b> - Существительный (<i>белая блузка</i>)</li>
                    <li>* <b>@block_name_rod@</b> - Родительный (<i>белую блузку</i>)</li>
                    <li>* <b>@block_name_several@</b> - Множина (<i>белые блузки</i>)</li>
                  </ul>
		
				</td>
				
			</tr>
			
			<tr>
				<td><font color="blue">SubDomain</font> Тайтл(view)</td>
				<td id="title_view"></td>
				<td id="calculation_title_view"><b><?php echo mb_strlen($data['domain_title'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td><font color="blue">SubDomain</font> Тайтл H1</td>
				<td><input type="text" name="domain_title_h1" id="domain_title_h1" class="calculation" value="<?php echo $data['domain_title_h1']; ?>" placeholder="Тайтл H1"></td>
				<td id="calculation_title_h1"><b><?php echo mb_strlen($data['domain_title_h1'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td><font color="blue">SubDomain</font> Лучший</td>
				<td align="left"><input type="checkbox" name="domain_is_best" id="domain_is_best" <?php if($data['domain_is_best'] == 1) echo ' checked '; ?> style="width: 20px;"></td>
				<td id="calculation_is_best"></td>
			</tr>
			<tr>
				<td style="vertical-align: top;"><font color="blue">SubDomain</font> Meta-Description</td>
				<td>
					<textarea style="width: 100%; height: 200px;" id="domain_text1" class="calculation_text product_names main_text_textarea" name="domain_text1"><?php echo htmlspecialchars_decode($data['domain_text1'], ENT_QUOTES); ?></textarea>
				</td>
				<td id="calculation_text1"><b><?php echo mb_strlen($data['domain_text1'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td style="vertical-align: top;"><font color="blue">SubDomain</font> Description [Описание на странице]</td>
				<td>
					<textarea style="width: 100%; height: 400px;" id="domain_text2" class="calculation_text product_names main_text_textarea" name="domain_text2"><?php echo htmlspecialchars_decode($data['domain_text2'], ENT_QUOTES); ?></textarea>
				</td>
				<td id="calculation_text2"><b><?php echo mb_strlen($data['domain_text2'], 'UTF-8'); ?> c.</b></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		
</div>
			<div class="tab-content">
			</div>
		</div>
	</div>
</div>
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
<!-- ============================================================================================================== -->
</form>

	<?php 
	
	//var text = tinyMCE.get('main_text_textarea').getContent();
	
} ?>
</div>




<script>
	
	
		
	$(document).on('keypress change', '.calculation', function(){
		
		var id = $(this).attr('id');
		var text_len = $(this).val().length;
		
		calculation(id, text_len);
		
		if (id == 'title') {
            
			var text = $(this).val();
			
			text = text.replace('@min_price@', '748');
			text = text.replace('@products_count@', '10748');
			text = text.replace('@shops_count@', '29');
			text = text.replace('@design_count@', '45');
			text = text.replace('@prev_year@', '2015');
			text = text.replace('@now_year@', '2016');
			text = text.replace('@next_year@', '2017');
			text = text.replace('@dinamic_year@', '2016 - 2017');
				
			text_len = text.length; 
			$('#title_view').html(text);
			calculation('title_view', text_len);
        }
		
	});
	
	function calculation(id, text_len) {
        
		$('#calculation_'+id).html('<b>' + (text_len + 1) + ' c.</b>');
    }
	
	$(document).ready(function(){
		$('#category_id').trigger('change');
		$('#title').trigger('change');
		
		jQuery(document).on('click', '.tabs .tab-links a', function(e)  {
			var currentAttrValue = jQuery(this).attr('href');
	 
			// Show/Hide Tabs
			jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
	 
			// Change/remove current tab to active
			jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	 
			e.preventDefault();
		});
	});
	
	$(document).on('change', '.filters', function(){
		
		var alias = '';
		
		$('.filters').each(function( index, value ) {
				
			if ($(this).prop('checked')) {
				tmp = $(this).attr('id');
				tmp = tmp.split('_');
				
				alias = alias + tmp[0] + '-';
			}
				
		});
		
		alias = alias + $('#category_url').val();
		
		$('#url').val(alias);
		
	});
	
	
	$(document).on('change', '#category_id', function(){
		
			var id = $(this).val();
			var url = $('#url').val();
			
		  jQuery.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/seo/ajax/get_info.php",
			dataType: "json",
			data: "category_id="+id+"&url="+url+"&key=get_category_filters",
			beforeSend: function(){
			},
			success: function(msg){
				
				//Фильтры
				jQuery("#filters_tabs").empty();
				jQuery("#tab_content").empty();
				var count = 1;
				var tmp = '';
			
			console.log(msg);
			
			/*
				jQuery(".header").append(' [');
				jQuery.each(msg.size, function( index, value ) {
					jQuery(".header").append(value+', ');
				});
				jQuery(".header").append(']');
			*/
			
				jQuery.each(msg.filters, function( index, value ) {
					tmp = '';
					//Добавляем закладки
					if (count == 1) {
                        jQuery("#filters_tabs").append( '<li class="active"><a href="#tab'+count+'">'+index+'</a></li>');
                    }else{
						jQuery("#filters_tabs").append( '<li><a href="#tab'+count+'">'+index+'</a></li>');
					}
					
					//Добавляем контент закладки
					if (count == 1) {
                        tmp = tmp + '<div id="tab'+count+'" class="tab active">';
                    }else{
						tmp = tmp + '<div id="tab'+count+'" class="tab">';
					}
						
					jQuery.each(value, function( index1, value1 ) {
						if (value1['isset'] == 1) {
                            tmp = tmp + '<input type="checkbox" style="width:20px;" class="filters" name="'+value1.filtername+'_'+index1+'" id="'+value1.filtername+'_'+index1+'" checked>'+value1['name']+'<br>';
                        }else{
							tmp = tmp + '<input type="checkbox" style="width:20px;" class="filters" name="'+value1.filtername+'_'+index1+'" id="'+value1.filtername+'_'+index1+'">'+value1['name']+'<br>';
						}
						
					});
					tmp = tmp + '</div>';
					
					jQuery("#tab_content").append( tmp );
					
					count = count + 1;
						
				});
			}	
		});
		
	});
	
	$(document).on('change', '#category', function(){
		
		var id = $(this).val();
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/seo/ajax/get_info.php",
			dataType: "json",
			data: "id="+id+"&key=get_category_list",
			beforeSend: function(){
			},
			success: function(msg){
				
				//console.log( msg );
				var out = '<table class="text"><tr><th>#</th><th>ЧПУ</th><th>Название</th><th>Тайтл</th><th></th></tr>';
				var out = out + '<tr><th colspan="5"><a href="/<?php echo TMP_DIR; ?>backend/index.php?route=seo/seo.index.php&seoedit=0" target="_blank">Создать новый</a></th></tr>';
				
				$.each(msg, function( index_g, value_g ) {
					
					out = out + '<tr style="background: orange;"><td>'+index_g+'</td><td colspan="4"><b>'+value_g.group_name+'</b></td></tr>';
					$.each(value_g.list, function( index, value ) {
					
						out = out + '<tr id="'+index+'"><td>'+index+'</td><td><a href="/<?php echo TMP_DIR; ?>backend/index.php?route=seo/seo.index.php&seoedit='+index+'" target="_blank">'+value.url+'</a></td><td>'+value.name+'</td><td>'+value.title+'</td><td><a href="javascript:" class="dell" id="dell_'+index+'" data-id="'+index+'"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a></td></tr>';
					
					});	
				});
				out = out + '</table>';
				
				$('.description-list').html(out);
				
			}
		});
		
	});
	
	$(document).on('click', '#all_alias_list', function(){
		
		var id = $(this).val();
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/seo/ajax/get_info.php",
			dataType: "json",
			data: "id="+id+"&key=get_all_category_list",
			beforeSend: function(){
			},
			success: function(msg){
				
				console.log( msg );
				var out = '<table class="text"><tr><th>#</th><th>ЧПУ</th><th>Название</th><th>Тайтл</th><th></th></tr>';
				var out = out + '<tr><th colspan="5"><a href="/<?php echo TMP_DIR; ?>backend/index.php?route=seo/seo.index.php&seoedit=0" target="_blank">Создать новый</a></th></tr>';
				
				$.each(msg, function( index_g, value_g ) {
					
					out = out + '<tr style="background: orange;"><td>'+index_g+'</td><td colspan="4"><b>'+value_g.group_name+'</b></td></tr>';
					$.each(value_g.list, function( index, value ) {
					
						out = out + '<tr id="'+index+'"><td>'+index+'</td><td><a href="/<?php echo TMP_DIR; ?>backend/index.php?route=seo/seo.index.php&seoedit='+index+'" target="_blank">'+value.url+'</a></td><td>'+value.name+'</td><td>'+value.title+'</td><td><a href="javascript:" class="dell" id="dell_'+index+'" data-id="'+index+'"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a></td></tr>';
					
					});	
				});
				out = out + '</table>';
				
				$('.description-list').html(out);
				
			}
		});
		
	});
	
	jQuery(document).on('click','.dell', function(){
        var id = jQuery(this).data('id');
        var table = "<?php echo $table; ?>";//jQuery('#table').val();
        
        if (confirm('Вы действительно желаете удалить фильтр?')){
            jQuery.ajax({
                type: "POST",
                url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
                dataType: "text",
                data: "id="+id+"&table="+table+"&mainkey=<?php echo $main_key;?>&key=dell",
                beforeSend: function(){
                },
                success: function(msg){
                    console.log( msg );
                    jQuery('#'+id).hide();
                }
            });
        }
    });
	
	$('#text1').summernote({
		height: 200,
		width: 700
	});
	$('#text2').summernote({
		height: 500,
		width: 700
	});

	$('#domain_text1').summernote({
		height: 200,
		width: 700
	});
	$('#domain_text2').summernote({
		height: 500,
		width: 700
	});

/*	
	function elFinderBrowser (field_name, url, type, win) {
            
			tinymce.activeEditor.windowManager.open({
              file: '/admin/elFinder-master/elfinder.html',// use an absolute path!
              title: 'elFinder 2.0',
              width: 900,  
              height: 450,
              resizable: 'yes'
            }, {
              setUrl: function (url) {
                win.document.getElementById(field_name).value = 'elFinder-master/'+url;
              }
            });
            return false;
    }
  
            
  
	tinymce.init({
			selector: "textarea#text1",
			height: 200,
			
	});
	tinymce.init({
			selector: "textarea#text2",
			height: 500,
	});
	

	tinymce.init({
			selector: "textarea",
			
	        file_browser_callback : elFinderBrowser,
			plugins: [
			  "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
			  "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			  "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
			],
		  
			toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
			toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
			//toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",
		  
			menubar: false,
			toolbar_items_size: 'small',
		  
			style_formats: [{
			  title: 'Bold text',
			  inline: 'b'
			}, {
			  title: 'Red text',
			  inline: 'span',
			  styles: {
				color: '#ff0000'
			  }
			}, {
			  title: 'Red header',
			  block: 'h1',
			  styles: {
				color: '#ff0000'
			  }
			}, {
			  title: 'Example 1',
			  inline: 'span',
			  classes: 'example1'
			}, {
			  title: 'Example 2',
			  inline: 'span',
			  classes: 'example2'
			}, {
			  title: 'Table styles'
			}, {
			  title: 'Table row 1',
			  selector: 'tr',
			  classes: 'tablerow1'
			}],
		  
			templates: [{
			  title: 'Test template 1',
			  content: 'Test 1'
			}, {
			  title: 'Test template 2',
			  content: 'Test 2'
			}],
			content_css: [
			  '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
			  '//www.tinymce.com/css/codepen.min.css'
			]
	});
  */
</script>
</script>

<!-- ======================================================================== -->
<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/libs/category_tree/type-for-get.css">
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/libs/category_tree/script-for-get.js"></script>
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/seo/category_tree.js"></script>
<input type="hidden" id="select_cetegory_target" value="">		
<script>
	$(document).on('click', '.select_category', function(){
		$('#select_cetegory_target').val($(this).data('target'));
		var id = $(this).data('id');
		$('#target_categ_id').val(id);
		$('#target_categ_name').val($('#categ_name'+id).html());
		$('#container').show();
		$('#container_back').show();
	});
	$(document).on('click', '.close_tree', function(){
		$('#container').hide();
		$('#container_back').hide();
	});
	$(document).on('click', '#container_back', function(){
		$('#container').hide();
		$('#container_back').hide();
	});
</script>
	<input type="hidden" value="" id="category" class="selected_category">
	<div id="container_back"></div>
	<style>
		#container_back{width: 100%;height: 100%;z-index:11000;opacity: 0.7;display: none;position: fixed;background-color: gray;top:0;left:0;}
		#container{z-index:11001;}
	</style>
	
<?php
$Types = array();
$Types[0] = array("id"=>0,"name"=>"Главная");
//=======================================================================
	$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name, A.keyword
					FROM `'.DB_PREFIX.'category` C
					LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
					LEFT JOIN `'.DB_PREFIX.'url_alias` A ON A.query = CONCAT("category_id=",CD.category_id)
					WHERE parent_id = "0" ORDER BY name ASC;';
	//echo '<br>'.$sql;
	$rs = $mysqli->query($sql) or die ("Get product type list ".mysqli_error($mysqli));
	
	$body = "
			<input type='hidden' id=\"target_categ_id\" value='0'>
			<input type='hidden' id=\"target_categ_name\" value=''>
			<div id=\"container\" class = \"product-type-tree\">
				<h4>Выбрать категорию <span class='close_tree'>[закрыть]</span></h4><ul  id=\"celebTree\">
		";
	while ($Type = $rs->fetch_assoc()) {

	if($Type['parent_id'] == 0){
		
		//Посчитаем сколько есть описаний
		$sql = 'SELECT count(id) AS total FROM `'.DB_PREFIX.'alias_description` WHERE url LIKE "%'.$Type['keyword'].'";';
		$ra = $mysqli->query($sql) or die ("Get product type list ".mysqli_error($mysqli));
		$total = 0;
		if($ra->num_rows){
			$row = $ra->fetch_assoc();
			$total = $row['total'];
		}
		
		$body .=  "<li><span id=\"span_".$Type['id']."\"> <a class = \"tree category_id_".$Type['id']."\" href=\"javascript:\" id=\"".$Type['id']."\">".$Type['name']." [".$total."]</a>";
		$body .= "</span>".readTree($Type['id'],$mysqli);
		$body .= "</li>";
	}
	$Types[$Type['id']]['id'] = $Type['id'];
	$Types[$Type['id']]['name'] = $Type['name'];
	}
	$body .= "</ul>
		</li></ul></div>";

	echo $body;
				
  //Рекурсия=================================================================
function readTree($parent,$mysqli){
	$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name, A.keyword
				FROM `'.DB_PREFIX.'category` C
				LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
				LEFT JOIN `'.DB_PREFIX.'url_alias` A ON A.query = CONCAT("category_id=",CD.category_id)
				WHERE parent_id = "'.$parent.'" ORDER BY name ASC;';
		
	$rs1[$parent] = mysqli_query( $mysqli, $sql) or die ("Get product type list");

	$body = "";

	while ($Type = mysqli_fetch_assoc($rs1[$parent])) {

		//Посчитаем сколько есть описаний
		$sql = 'SELECT count(id) AS total FROM `'.DB_PREFIX.'alias_description` WHERE url LIKE "%'.$Type['keyword'].'";';
		
		$ra = $mysqli->query($sql) or die ("Get product type list ".mysqli_error($mysqli));
		$total = 0;
		if($ra->num_rows){
			$row = $ra->fetch_assoc();
			$total = $row['total'];
		}
	 
		$body .=  "<li><span id=\"span_".$Type['id']."\"><a class = \"tree category_id_".$Type['id']."\" href=\"javascript:\" id=\"".$Type['id']."\">".$Type['name']." [".$total."]</a>";
		$body .= "</span>".readTree($Type['id'],$mysqli);
		$body .= "</li>";
	}
	if($body != "") $body = "<ul>$body</ul>";
	return $body;

}
?>
<style>
	/*----- Tabs -----*/
.tabs {
    width:100%;
    display:inline-block;
}
 
    /*----- Tab Links -----*/
    /* Clearfix */
    .tab-links:after {
        display:block;
        clear:both;
        content:'';
    }
 
    .tab-links li {
        margin:0px 5px;
        float:left;
        list-style:none;
    }
 
        .tab-links a {
            padding:5px 10px;
            display:inline-block;
            border-radius:1px 1px 0px 0px;
            background:#7FB5DA;
            font-size:16px;
            font-weight:600;
            color:#4c4c4c;
            transition:all linear 0.15s;
        }
 
        .tab-links a:hover {
            background:#727272;
            text-decoration:none;
        }
 
    li.active a, li.active a:hover {
        background:#FFFFFF;
        color:#4c4c4c;
    }
 
    /*----- Content of Tabs -----*/
    .tab-content {
        padding:15px;
        border-radius:3px;
        box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
        background:#fff;
    }
 
        .tab {
            display:none;
        }
 
        .tab.active {
            display:block;
        }
	
		
	#actionmessage{
		display: none;
	}
	
</style>
<script>
	$(document).ready(function(){
		$('#span_1').parent('li').children('ul').show();
		$('#span_2').parent('li').children('ul').show();
		$('#span_498').parent('li').children('ul').show();
	});
	


</script>
	   