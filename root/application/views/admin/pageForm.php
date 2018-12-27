<div class="ui-widget">
<form id="editForm">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <th scope="row">Наименование:</th>
      <td><input name="fldName" type="text" value="<?= $mainObj?$mainObj->name:"";?>" id="fldName" /></td>
    </tr>
    <tr>
      <td colspan="2"><textarea name="fldContent" rows="5" id="fldContent"><?= $mainObj?$mainObj->content:"";?></textarea></td>
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
			url: '<?= site_url("adminwork/pageUpdate");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj?$mainObj->id:-1;?>,
				fldName: $("#fldName").val(),
				fldContent: tinyMCE.get("fldContent").getContent()
			}
		}).responseText;
		alert(resHtml);
		window.location.replace('<?= site_url("adminwork/pages");?>');
	});

	<? if ($mainObj):?>
	$("#buttonDelete").button({
		icons: { primary: 'ui-icon-trash', secondary: null }
	});
	$("#buttonDelete").click(function(event) {
		var resHtml = $.ajax({
			url: '<?= site_url("adminwork/pageDelete");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj->id;?>
			}
		}).responseText;
		alert(resHtml);
		window.location.replace('<?= site_url("adminwork/pages");?>');
	});
	<? endif;?>

});
</script>
<script type="text/javascript" src="/public/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode: "exact",
		elements: "fldContent",
		theme: "modern",
		skin: "lightgray",
		language: "ru"
	});
</script>