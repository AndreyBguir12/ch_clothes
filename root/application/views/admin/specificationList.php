<button id="buttonNew">Добавить</button>
<?php
if($listArr):
	$this->table->set_template(array(
		'table_open'		=>'<table width="100%" id="mainTable">',
		'heading_row_start'	=>'<tr class="ui-widget-header">',
		'row_start'			=>'<tr class="ui-widget-content" style="cursor: pointer">',
		'row_alt_start'		=>'<tr class="ui-state-highlight" style="cursor: pointer">'
	));
	$this->table->set_heading('#','Наименование');
	foreach($listArr as $n=>$v):
		$this->table->add_row(
			$v->id,
			$v->name
		);
	endforeach;
	echo $this->table->generate();
endif;
?>
<div id="dialog-form" title="Добавить характеристику">
  <form>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><input type="text" name="fldName" id="fldName" style="width: 310px" /></td>
      </tr>
    </table>
  <input type="hidden" name="fldId" id="fldId" />
  </form>
</div>
<script>
$(function() {
	var dialog = $("#dialog-form").dialog({
		autoOpen: false,
		modal: true,
		height: 175,
		width: 350,
		buttons: [
			{
				text: 'Сохранить',
				click: function() {
					var resHtml = $.ajax({
						url: '<?= site_url("adminwork/specificationUpdate");?>',
						async: false,
						type: "POST",
						data: {
							fldId: $("#fldId").val(),
							fldName: $("#fldName").val()
						}
					}).responseText;
					alert(resHtml);
					window.location.replace('<?= site_url("adminwork/specifications");?>');
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
		$("#fldId").val("-1");
		$("#fldName").val("");
		dialog.dialog("open");
	});
	
	$("#mainTable td").on('click',function() {
		$("#fldId").val($(this).parent().children().html());
		$("#fldName").val($(this).parent().children().next().html());
		dialog.dialog("open");
	});
});	
</script>