<div class="ui-widget">
<form id="editForm">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <th scope="row"><?= $mainObj->id;?></th>
      <td><?= $mainObj->dates;?></td>
    </tr>
    <tr>
      <th scope="row">Имя:</th>
      <td><?= $mainObj->name;?></td>
    </tr>
    <tr>
      <th scope="row">Адрес:</th>
      <td><?= $mainObj->address;?></td>
    </tr>
    <tr>
      <th scope="row">Телефон:</th>
      <td><?= $mainObj->phone;?></td>
    </tr>
    <tr>
      <th scope="row">Эл.почта:</th>
      <td><?= $mainObj->email;?></td>
    </tr>
    <tr>
      <th scope="row">Статус:</th>
      <td><?= form_dropdown('fldStatus',$listStatus,$mainObj->status,'id="fldStatus" style="width: 300px"');?> </td>
    </tr>
  </table>
</form>
</div>
<div class="ui-widget">
<?php
if($listArr):
	$this->table->set_template(array(
		'table_open'		=>'<table width="100%" id="mainTable">',
		'heading_row_start'	=>'<tr class="ui-widget-header">',
		'row_start'			=>'<tr class="ui-widget-content" style="cursor: pointer">',
		'row_alt_start'		=>'<tr class="ui-state-highlight" style="cursor: pointer">'
	));
	$this->table->set_heading('#','Товар','Размер','Кол-во','Цена','Сумма');
	$bidSumm=0;
	foreach($listArr as $n=>$v):
		$this->table->add_row(
			$v->product,
			$v->productName,
			$v->sizeName,
			$v->quantity,
			$v->price,
			$v->summ
		);
		$bidSumm+=$v->summ;
	endforeach;
	$this->table->add_row('','Итого','','','',$bidSumm);
	echo $this->table->generate();
endif;
?>
</div>
<button id="buttonSave">Сохранить</button>
<script>
$(function() {

	$("#buttonSave").button({
		icons: { primary: 'ui-icon-disk', secondary: null }
	});
	$("#buttonSave").click(function(event) {
		var resHtml = $.ajax({
			url: '<?= site_url("adminwork/bidUpdate");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj->id;?>,
				fldStatus: $("#fldStatus").val()
			}
		}).responseText;
		alert(resHtml);
		if(resHtml == "Ошибка сохранения") alert(resHtml);
		else window.location.replace('<?= site_url("adminwork/bids");?>');
	});

	$("#fldStatus").selectmenu();

});
</script>