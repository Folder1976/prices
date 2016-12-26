<input type="hidden" class="shop_id" value="0">

<div class='moduletitle'>{*$fvConfig->getModuleName($module)*}</div>
<div style="max-width: 1375px;">
<div class="table_body">
	
	<!-- Заголовок -->
	<div class="top_header">
		<h1 style="margin-bottom: 10px;" class="header">Импорт товаров</h1>
	</div>
	{php}
		$shops = json_decode($_SESSION['shops'], true);
		
	{/php}
	
	<div class="navigation">
		
		<!--form name="import_file" method="post" enctype="multipart/form-data"-->
	
			<!-- Фаил -->
			<div class="top_select">
				<div class="select_top shop">
					<label class="select_lable">Магазин</label>
					<select class="select" name="shop" id="shop">
						<option value="0">Выбрать...</option>
						{php}
							foreach($shops as $index => $value){
								echo '<option value="'.$index.'">'.$value['name'].'</option>';
							}
						{/php}
					</select>
				</div>
			</div>
	
			<div class="top_select">
				<div class="select_top shop">
					<label class="select_lable">Фаил</label>
					<!--input type="file" name="file" style="width:300px;"-->
					<input type="file" multiple="multiple" accept=".txt,image/*">
						
						<div class="ajax-respond"></div>
					
				</div>
			</div>
	
			<!-- Кнопка Импорт -->
			<div class="top_key top_brack_blok">
				<a href="#" class="submit button">Загрузить файлы</a>
				<!--input type="submit" class="key_brack" value="Импортировать"-->
			</div>
		<!--/form-->
		
	</div>
</div>
</div>

{literal}
<script>
	
	// Переменная куда будут располагаться данные файлов
	var files;
	 
	// Вешаем функцию на событие
	// Получим данные файлов и добавим их в переменную
	jQuery('input[type=file]').change(function(){
		files = this.files;
		//console.log(files);
	});

	// Вешаем функцию ан событие click и отправляем AJAX запрос с данными файлов
	jQuery('.submit.button').click(function( event ){
		event.stopPropagation(); // Остановка происходящего
		event.preventDefault();  // Полная остановка происходящего
	 
		// Создадим данные формы и добавим в них данные файлов из files
	 	var data = new FormData();
		jQuery.each( files, function( key, value ){
			data.append( key, value );
		});
	 
	 console.log(data);
	 
		// Отправляем запрос
		jQuery.ajax({
			url: "/backend/ajax/ajax_upload_file.php",
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'text',
			processData: false, // Не обрабатываем файлы (Don't process the files)
			contentType: false, // Так jQuery скажет серверу что это строковой запрос
			success: function( respond){
	 
				console.log(respond);
			}
		});
	 
	});
</script>

<style>
	.top_select{
		float: left;
		padding: 10px;
		border: solid 1px #aacfe4;
		margin-right: 10px;
	}
	.top_key{
		float: left;
		padding: 10px;
		border: solid 1px #aacfe4;
		margin-right: 10px;
	}
</style>
{/literal}
	
	
	{php}
	
	//echo "<pre>";  print_r(var_dump( $_FILES )); echo "</pre>";
	
	
	{/php}
