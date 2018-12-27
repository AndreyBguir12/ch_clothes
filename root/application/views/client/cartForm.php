<?php if($listArr):
	$this->table->set_template(array(
		'table_open'		=>'<table width="100%" id="mainTable">',
		'heading_row_start'	=>'<tr class="ui-widget-header">',
		'row_start'			=>'<tr class="ui-widget-content" style="cursor: pointer">',
		'row_alt_start'		=>'<tr class="ui-state-highlight" style="cursor: pointer">'
	));
	$this->table->set_heading('#','#','Товар','Размер','Цена','Количество','Сумма');
	$bidSumm=0;
	foreach($listArr as $n=>$v):
		$summ=$v->price*$v->cartQuantity;
		$this->table->add_row(
			$v->id,
			$v->size,
			$v->name,
			$v->sizeName,
			number_format($v->price,2,'.',''),
			$v->cartQuantity,
			number_format($summ,2,'.','')
		);
		$bidSumm+=$summ;
	endforeach;
?>
<div id="accordion">
<h3>Товары на сумму: <?= number_format($bidSumm,2,'.','');?></h3>
<div>
<?= $this->table->generate();?>
<button id="buttonClear">Очистить</button>
</div>
<h3>Сформировать заказ</h3>
<div class="ui-widget">
<form id="editForm" action="/catalog/cartToBid" method="post">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <th scope="row">Имя:</th>
      <td><input type="text" name="fldName" id="fldName" value="" /></td>
    </tr>
    <tr>
      <th scope="row">Адрес:</th>
      <td><input type="text" name="fldAddress" id="fldAddress" value="" /></td>
    </tr>
    <tr>
      <th scope="row">Телефон:</th>
      <td><input type="text" name="fldPhone" id="fldPhone" value="" /></td>
    </tr>
    <tr>
      <th scope="row">Эл.почта:</th>
      <td><input type="text" name="fldEmail" id="fldEmail" value="" /></td>
    </tr>
  </table>
</form>
<button id="buttonSave">Сохранить</button>
</div>
</div>
<div id="dialogCart" title="Изменить товар">
	<h3 id="productName"></h3>
    <label for="fldQuantity">Количество:</label>
    <input type="text" name="fldQuantity" id="fldQuantity" />
    <input type="hidden" name="fldId" id="fldId" />
    <input type="hidden" name="fldSize" id="fldSize" />
</div>
<script>
$(function() {

	$("#accordion").accordion({
		heightStyle: "content"
	});

	$("#buttonClear").button({
		icons: { primary: 'ui-icon-trash', secondary: null }
	});
	$("#buttonClear").click(function(event) {
		window.location.replace('<?= site_url("/catalog/cartClear");?>');
	});

	$("#buttonSave").button({
		icons: { primary: 'ui-icon-disk', secondary: null }
	});
	$("#buttonSave").click(function(event) {
		$("#editForm").submit();
	});
	
	$("#mainTable td").on('click',function() {
		$("#productName").html($(this).parent().children().next().next().html());
		$("#fldId").val($(this).parent().children().html());
		$("#fldSize").val($(this).parent().children().next().html());
		$("#fldQuantity").val($(this).parent().children().next().next().next().next().next().html());
		dialog.dialog("open");
	});
	
	var dialog = $("#dialogCart").dialog({
		width: 300,
		autoOpen: false,
		resizable: false,
		draggable: false,
		modal: true,
		buttons: [
			{
				text: "Ok",
				click: function() {
					var resHtml = $.ajax({
						url: '<?= site_url("catalog/cartUpdate");?>',
						async: false,
						type: "POST",
						data: {
							fldId: $("#fldId").val(),
							fldSize: $("#fldSize").val(),
							fldQuantity: $("#fldQuantity").val()
						}
					}).responseText;
					window.location.replace('<?= site_url("/catalog/cart");?>');
				}
			},
			{
				text: "Отмена",
				click: function() {
					$(this).dialog("close");
				}
			}
		]
	});

	$("#fldQuantity").spinner({
		min: 0,
		max: 10
	});
	
});	
</script>
<?php else:?>
<p style="product-skald">Корзина пуста!</p>
<?php endif;?>
