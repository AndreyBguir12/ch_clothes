<div>
  <?php if($listSize):?>
  <p>
    <label for="fldQuantity">Количество:</label>
    <input type="text" name="fldQuantity" id="fldQuantity" value="1" size="3" />
    <label for="fldSize">Размер:</label>    
    <?= form_dropdown('fldSize',$listSize,1,'id="fldSize"');?>
    <button id="buttonSave">В корзину</button>
    <label for="fldPrice">Цена:</label>
    <input type="text" name="fldPrice" id="fldPrice" readonly style="border:0; color:#e17009; font-weight:bold; background: none; width: 200px;" value="<?= $mainObj->price;?>" />
  </p>
  <?php else:?>
  <p style="color:#e17009; font-weight:bold;">
  	К сожалению, данный товар закончился...
  </p>
  <?php endif;?>
</div>
<div class="mt-16">
	<?php $img=$mainObj->image;
    if(strlen($img)>0):?>
        <div>
            <img src="/public/images/<?= $mainObj->image;?>" />
        </div>
    <?php endif;?>
    <h3 class="mt-16">Описание</h3>
    <div class="ui-widget">
	    <?= $mainObj->description;?>
    </div>
    <h3 class="mt-16">Характеристики</h3>
    <div>
		<?php
        if($listArr):
            $this->table->set_template(array(
                'table_open'		=>'<table width="100%" id="mainTable">',
                'heading_row_start'	=>'<tr class="ui-widget-header">',
                'row_start'			=>'<tr class="ui-widget-content">',
                'row_alt_start'		=>'<tr class="ui-state-highlight">'
            ));
            foreach($listArr as $n=>$v):
                $this->table->add_row(
                    $v->specName,
                    $v->value
                );
            endforeach;
            echo $this->table->generate();
        endif;
        ?>
    </div>
</div>
<script>
$(function() {

	$("#fldQuantity").spinner({
		min: 1,
		max: 999
	});

	$("#buttonSave").button({
		icons: { primary: 'ui-icon-cart', secondary: null }
	});
	$("#buttonSave").click(function(event) {
		var resHtml = $.ajax({
			url: '<?= site_url("catalog/cartUpdate");?>',
			async: false,
			type: "POST",
			data: {
				fldId: <?= $mainObj->id;?>,
				fldSize: $("#fldSize").val(),
				fldQuantity: $("#fldQuantity").val()
			}
		}).responseText;
		$("#cartCnt").html(resHtml);
	});
	
});
</script>