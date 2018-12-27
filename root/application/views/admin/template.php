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
  	<h1>Интернет-магазин</h1>
    <h3>детской одежды</h3>
  </div>
  <div class="menu">
    <ul id="mainMenu">
	  <li><a href="/adminwork/bids"><span class="ui-icon ui-icon-cart"></span>Заказы</a></li>
      <?php if($operations):?>
      <li><span class="ui-icon ui-icon-wrench"></span>Операции
        <ul>
        <?php foreach($operations as $n=>$v):?>
          <li><a href="<?= $v;?>"><?= $n;?></a></li>
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
            <li><a href="/adminwork/catalog/<?= $v1->id;?>"><?= $v1->name;?></a></li>
            <?php endforeach;?>
          </ul>
        </li>
          <?php endif;
		endforeach;
      endif;?>
      <li></li>
      <li><a href="/adminwork/categories"><span class="ui-icon ui-icon-folder-collapsed"></span>Категории</a></li>
      <li><a href="/adminwork/subcategories"><span class="ui-icon ui-icon-folder-open"></span>Подкатегории</a></li>
      <li><a href="/adminwork/productForm/-1"><span class="ui-icon ui-icon-circle-plus"></span>Добавить товар</a></li>
      <li></li>
	  <li><a href="/adminwork/specifications"><span class="ui-icon ui-icon-tag"></span>Характеристики</a></li>
	  <li><a href="/adminwork/sizes"><span class="ui-icon ui-icon-tag"></span>Размеры</a></li>
	  <li><a href="/adminwork/pages"><span class="ui-icon ui-icon-document"></span>Страницы</a></li>
      <li><a href="/admin/logout"><span class="ui-icon ui-icon-arrowthick-1-e"></span>Выход</a></li>
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