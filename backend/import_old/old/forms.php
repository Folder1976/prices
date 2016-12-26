<form action="" method="post" enctype="multipart/form-data">
<table>
<input type="hidden" name="importlist" value="1">
	<tr>
    	<td>Тип файла:</td> <td><select name="importtype">
    	<option <? if(!$_POST['importtype']){echo 'selected="selected"';} ?> value="">Выберите тип файла</option>
        <option <? if($_POST['importtype']=='RiolitSistem'){echo 'selected="selected"';} ?> value="RiolitSistem">RiolitSistem</option>
        <option <? if($_POST['importtype']=='shopit.md'){echo 'selected="selected"';} ?> value="shopit.md">shopit.md</option>
        <option <? if($_POST['importtype']=='NeuronPriceList'){echo 'selected="selected"';} ?> value="NeuronPriceList">NeuronPriceList</option>
        <option <? if($_POST['importtype']=='DOXYTERRA'){echo 'selected="selected"';} ?> value="DOXYTERRA">DOXYTERRA</option>
        
    </select></td></tr>
    <tr><td>Выберите файл: <td><input type="file" name="import" value="<?=$_FILES['import']?>"></td></tr>
    <tr><td rowspan="2">Настройки</td><td><input type="checkbox" name="testcategory" <? if($_POST['testcategory']){echo 'checked';} ?>>Тестирование категорий/Скрыть товары</td></tr>
    <tr><td><input type="checkbox" name="addautomate" <? if($_POST['addautomate']){echo 'checked';} ?>>Добавить определенные товары в базу и скрыть их</td></tr>
    <tr><td><input type="submit" value="Импортировать"></td>
</table>
</form>