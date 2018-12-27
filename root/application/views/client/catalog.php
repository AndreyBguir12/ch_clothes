<?php
if($listArr):
  foreach($listArr as $n=>$v):
?>
<div class="product-cat" productId="<?= $v->id;?>">
  <div class="product-img"><img src="/public/images/<?= $v->image;?>" class="img-cat" /></div>
  <div class="product-info">
    <h3><?= $v->name;?></h3>
    <p><?= $v->info;?>...</p>
    <p class="product-price">Цена: <?= $v->price;?></p>
  </div>
</div>
<?php
  endforeach;
endif;
?>
<script>
$(function() {

	$(".product-cat").on('click',function() {
		window.location.replace('<?= site_url("/catalog/product");?>' + '/' + $(this).attr("productId"));
	});

});	
</script>