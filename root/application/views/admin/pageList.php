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
<script>
$(function() {

	$("#buttonNew").button({
		icons: { primary: 'ui-icon-circle-plus', secondary: null }
	});
	$("#buttonNew").click(function(event) {
		window.location.replace('<?= site_url("/adminwork/pageForm");?>' + '/-1');
	});
	
	$("#mainTable td").on('click',function() {
		window.location.replace('<?= site_url("/adminwork/pageForm");?>' + '/' + $(this).parent().children().html());
	});

});	
</script>