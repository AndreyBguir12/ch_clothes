<?php if($mainObj):?>
<div id="accordion">
<h3>Описание</h3>
<? endif;?>
<div class="ui-widget">
<form id="editForm">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <th scope="row">Наименование:</th>
      <td><input name="fldName" type="text" value="<?= $mainObj?$mainObj->name:"";?>" id="fldName" /></td>
    </tr>
    <tr>
      <th scope="row">Описание:</th>
      <td><textarea name="fldDescription" rows="5" id="fldDescription"><?= $mainObj?$mainObj->description:"";?></textarea></td>
    </tr>
    <tr>
      <th scope="row">Подкатегория:</th>
      <td><?= form_dropdown('fldParent',$listSub,$mainObj?$mainObj->parent:1,'id="fldParent"');?></td>
    </tr>
    <tr>
      <th scope="row">Пол:</th>
      <td><?= form_dropdown('fldUnit',$listUnit,$mainObj?$mainObj->unit:1,'id="fldUnit"');?></td>
    </tr>
    <tr>
      <th scope="row">Цена:</th>
      <td><input name="fldPrice" type="text" value="<?= $mainObj?$mainObj->price:"";?>" id="fldPrice" class="spinner" /></td>
    </tr>
  </table>
  <input name="fldImage" id="fldImage" type="hidden" value="<?= $mainObj?$mainObj->image:"";?>" />
</form>
<button id="buttonSave">Сохранить</button>
<? if ($mainObj):?>
<button id="buttonDelete">Удалить</button>
<? endif;?>
</div>
<h3>Изображение</h3>
<div>
<?php if($mainObj):?>
<img src="/public/images/<?= $mainObj->image;?>" />
<?php endif;?>
<br />
<button id="buttonImg">Выбрать</button>
</div>
<?php if($mainObj):?>
<h3>Характеристики</h3>
<div>
<button id="buttonNew">Добавить</button>
<?php
if($listArr):
	$this->table->set_template(array(
		'table_open'		=>'<table width="100%" id="mainTable">',
		'heading_row_start'	=>'<tr class="ui-widget-header">',
		'row_start'			=>'<tr class="ui-widget-content" style="cursor: pointer">',
		'row_alt_start'		=>'<tr class="ui-state-highlight" style="cursor: pointer">'
	));
	$this->table->set_heading('#','Характеристика','Значение');
	foreach($listArr as $n=>$v):
		$this->table->add_row(
			$v->specification,
			$v->specName,
			$v->value
		);
	endforeach;
	echo $this->table->generate();
endif;
?>
</div>
<h3>Размеры</h3>
<div>
<button id="buttonSize">Добавить</button>
<?php
if($listPrSize):
	$this->table->set_template(array(
		'table_open'		=>'<table width="100%" id="mainTableS">',
		'heading_row_start'	=>'<tr class="ui-widget-header">',
		'row_start'			=>'<tr class="ui-widget-content" style="cursor: pointer">',
		'row_alt_start'		=>'<tr class="ui-state-highlight" style="cursor: pointer">'
	));
	$this->table->set_heading('#','Размер','Количество');
	foreach($listPrSize as $n=>$v):
		$this->table->add_row(
			$v->size,
			$v->sizeName,
			$v->quantity
		);
	endforeach;
	echo $this->table->generate();
endif;
?>
</div>
</div>
<div id="dialog-form" title="Характеристика">
  <form>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><?= form_dropdown('fldSpecification',$listSpec,1,'id="fldSpecification" style="width: 315px;"');?></td>
      </tr>
      <tr>
        <td><input type="text" name="fldSpecValue" id="fldSpecValue" style="width: 310px" /></td>
      </tr>
    </table>
  </form>
</div>
<div id="dialog-size" title="Размер">
  <form>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><?= form_dropdown('fldSize',$listSize,1,'id="fldSize" style="width: 315px;"');?></td>
      </tr>
      <tr>
        <td><input type="text" name="fldQuantity" id="fldQuantity" style="width: 285px" /></td>
      </tr>
    </table>
  </form>
</div>
<? endif;?>
<script>
$(function() {

<?php if($mainObj):?>
	$("#accordion").accordion({
		heightStyle: "content"
	});

	$("#buttonDelete").button({
		icons: { primary: 'ui-icon-trash', secondary: null }
	});
	$("#buttonDelete").click(function(event) {
		var resHtml = $.ajax({
			url: '<?= site_url("adminwork/productDelete");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj->id;?>
			}
		}).responseText;
		alert(resHtml);
		window.location.replace('<?= site_url("adminwork/catalog");?>' + '/' + <?= $mainObj->parent;?>);
	});
	
	var dialog = $("#dialog-form").dialog({
		autoOpen: false,
		modal: true,
		height: 200,
		width: 350,
		buttons: [
			{
				text: 'Сохранить',
				click: function() {
					var resHtml = $.ajax({
						url: '<?= site_url("adminwork/productSpecUpdate");?>',
						async: false,
						type: "POST",
						data: {
							fldProduct: <?= $mainObj->id;?>,
							fldSpecification: $("#fldSpecification").val(),
							fldSpecValue: $("#fldSpecValue").val()
						}
					}).responseText;
					alert(resHtml);
					window.location.replace('<?= site_url("adminwork/productForm");?>' + '/' + <?= $mainObj->id;?>);
				}
			},
			{
				text: 'Отмена',
				click: function() {
					dialog.dialog("close");
				}
			}
		]
	});

	$("#buttonNew").button({
		icons: { primary: 'ui-icon-circle-plus', secondary: null }
	});
	$("#buttonNew").click(function(event) {
		$("#fldSpecification").val("1");
		$("#fldSpecValue").val("");
		dialog.dialog("open");
	});
	
	$("#mainTable td").on('click',function() {
		$("#fldSpecification").val($(this).parent().children().html());
		$("#fldSpecValue").val($(this).parent().children().next().next().html());
		dialog.dialog("open");
	});

	$("#fldQuantity").spinner({
		min: 0,
		max: 999
	});

	var dialogS = $("#dialog-size").dialog({
		autoOpen: false,
		modal: true,
		height: 200,
		width: 350,
		buttons: [
			{
				text: 'Сохранить',
				click: function() {
					var resHtml = $.ajax({
						url: '<?= site_url("adminwork/productSizeUpdate");?>',
						async: false,
						type: "POST",
						data: {
							fldProduct: <?= $mainObj->id;?>,
							fldSize: $("#fldSize").val(),
							fldQuantity: $("#fldQuantity").val()
						}
					}).responseText;
					alert(resHtml);
					window.location.replace('<?= site_url("adminwork/productForm");?>' + '/' + <?= $mainObj->id;?>);
				}
			},
			{
				text: 'Отмена',
				click: function() {
					dialogS.dialog("close");
				}
			}
		]
	});


	$("#buttonSize").button({
		icons: { primary: 'ui-icon-circle-plus', secondary: null }
	});
	$("#buttonSize").click(function(event) {
		$("#fldSize").val("1");
		$("#fldQuantity").val("1");
		dialogS.dialog("open");
	});
	
	$("#mainTableS td").on('click',function() {
		$("#fldSize").val($(this).parent().children().html());
		$("#fldQuantity").val($(this).parent().children().next().next().html());
		dialogS.dialog("open");
	});

<?php endif;?>

	$("#buttonSave").button({
		icons: { primary: 'ui-icon-disk', secondary: null }
	});
	$("#buttonSave").click(function(event) {
		var resHtml = $.ajax({
			url: '<?= site_url("adminwork/productUpdate");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj?$mainObj->id:-1;?>,
				fldName: $("#fldName").val(),
				fldDescription: $("#fldDescription").val(),
				fldParent: $("#fldParent").val(),
				fldUnit: $("#fldUnit").val(),
				fldPrice: $("#fldPrice").val(),
				fldImage: $("#fldImage").val()
			}
		}).responseText;
		alert(resHtml);
		if(resHtml == "Ошибка сохранения") alert(resHtml);
		else window.location.replace('<?= site_url("adminwork/catalog");?>' + '/' + <?= $mainObj?$mainObj->parent:1;?>);
	});

	var buttonImg=$("#buttonImg");
	buttonImg.button({
		icons: { primary: 'ui-icon-image', secondary: null }
	});
	new AjaxUpload(buttonImg, {
		action: '<?= site_url("adminwork/productImg");?>',
		name: 'uploadImg',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
				operationStatus.text('Только JPG, PNG or GIF файлы могут быть загружены!');
				return false;
			}
		},
		onComplete: function (file, response) {
			$("#fldImage").val(response);
		}
	});
	
	$("#fldParent").selectmenu();
	$("#fldUnit").selectmenu();
	$("#fldPrice").spinner({
		min: 0,
		numberFormat: "n",
		step: 0.01
	});

});
</script>