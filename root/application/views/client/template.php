<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?= $title;?></title>
	<link href="/public/style.css" rel="stylesheet" type="text/css" />
	<link href="/public/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet" />
	<script src="/public/jquery.js"></script>
	<script src="/public/jquery-ui-1.11.4/jquery-ui.js"></script>
	<script src="/public/ajaxupload.3.5.js"></script>
	<script>
		$(function() {
			$("#mainMenu").menu({
				items: "> :not(.ui-widget-header)"
			});
		});
	</script>
</head>

<body>

<div class="container">
  <div class="header">
    <br /><br />
  	<h1>Интернет-магазин</h1>
    <h3>детской одежды</h3>
  </div>
  <div class="menu">
    <ul id="mainMenu">
	  <li><a href="/catalog/cart"><span class="ui-icon ui-icon-cart"></span>Корзина&nbsp;(товаров:&nbsp;<span id="cartCnt" style="color:#e17009;"><?= count($this->cart);?></span>)</a></li>
      <?php if(count($this->pages)>0):?>
      <li><span class="ui-icon ui-icon-document"></span>Информация
        <ul>
        <?php foreach($this->pages as $n=>$v):?>
          <li><a href="/catalog/pages/<?= $n;?>"><?= $v;?></a></li>
        <?php endforeach;?>
        </ul>
      </li>
      <?php endif;?>
      <li class="ui-widget-header">Каталог</li>
      <?php if(count($this->catalog)>0):
	    foreach($this->catalog as $n=>$v):
		  if(count($v->sub)>0):?>
		<li><?= $v->name;?>
          <ul>
	        <?php foreach($v->sub as $n1=>$v1):?>
            <li><a href="/catalog/products/<?= $v1->id;?>"><?= $v1->name;?></a></li>
            <?php endforeach;?>
          </ul>
        </li>
          <?php endif;
		endforeach;
      endif;?>
	</ul>
  </div>
  <div class="content">
    <h2><?= $title;?></h2>
	<?= $mainContent;?>
  </div>
  <br class="clearfloat" />
  <div class="footer">
    <p>Интернет-магазин детской одежды &copy; 2018</p>
  </div>
</div>
</body>
</html>