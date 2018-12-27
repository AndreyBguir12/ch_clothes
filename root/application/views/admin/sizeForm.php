<div class="ui-widget">
<form id="editForm">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <th scope="row">Наименование:</th>
      <td><input name="fldName" type="text" value="<?= $mainObj?$mainObj->name:"";?>" id="fldName" /></td>
    </tr>
  </table>
</form>
<button id="buttonSave">Сохранить</button>
<? if ($mainObj):?>
<button id="buttonDelete">Удалить</button>
<? endif;?>
</div>
<script>
$(function() {

	$("#buttonSave").button({
		icons: { primary: 'ui-icon-disk', secondary: null }
	});
	$("#buttonSave").click(function(event) {
		var resHtml = $.ajax({
			url: '<?= site_url("adminwork/sizeUpdate");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj?$mainObj->id:-1;?>,
				fldName: $("#fldName").val()
			}
		}).responseText;
		alert(resHtml);
		if(resHtml == "Ошибка сохранения") alert(resHtml);
		else window.location.replace('<?= site_url("adminwork/sizes");?>');
	});

	<? if ($mainObj):?>
	$("#buttonDelete").button({
		icons: { primary: 'ui-icon-trash', secondary: null }
	});
	$("#buttonDelete").click(function(event) {
		var resHtml = $.ajax({
			url: '<?= site_url("adminwork/sizeDelete");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj->id;?>
			}
		}).responseText;
		alert(resHtml);
		window.location.replace('<?= site_url("adminwork/sizes");?>');
	});
	<? endif;?>

});
</script>