<?php
if($listArr):
	$this->table->set_template(array(
		'table_open'		=>'<table width="100%" id="mainTable">',
		'heading_row_start'	=>'<tr class="ui-widget-header">',
		'row_start'			=>'<tr class="ui-widget-content" style="cursor: pointer">',
		'row_alt_start'		=>'<tr class="ui-state-highlight" style="cursor: pointer">'
	));
	$this->table->set_heading('#','Дата','Сумма','Статус');
	foreach($listArr as $n=>$v):
		$this->table->add_row(
			$v->id,
			$v->dates,
			$v->bidSumm,
			$v->statusName
		);
	endforeach;
	echo $this->table->generate();
endif;
?>
<script>
$(function() {

	$("#mainTable td").on('click',function() {
		window.location.replace('<?= site_url("/adminwork/bidForm");?>' + '/' + $(this).parent().children().html());
	});

});	
</script>