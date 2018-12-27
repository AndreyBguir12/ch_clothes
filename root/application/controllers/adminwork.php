<?php
class Adminwork extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged'))redirect('/admin','refresh');
		$this->userId=$this->session->userdata('userId');
		$this->load->model('adminworks');
		$this->catalog=$this->adminworks->get_catalog();
	}
	
	function index()
	{
		$this->bids();
	}
	
	function bids()
	{
		$this->load->view('admin/template',array(
			'title'=>'Заказы',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/bidList',array(
				'listArr'=>$this->adminworks->get_bids()
			),true)
		));
	}
	
	function bidForm($bid)
	{
		$listArr=$this->adminworks->get_bid_products($bid);
		$mainObj=$this->adminworks->get_by_id('bids',$bid);
		if($listArr&&$mainObj):
			$this->load->view('admin/template',array(
				'title'=>'Заказ',
				'operations'=>false,
				'mainContent'=>$this->load->view('admin/bidForm',array(
					'listArr'=>$listArr,
					'mainObj'=>$mainObj,
					'listStatus'=>$this->adminworks->get_list('status_bids')
				),true)
			));
		else:
			redirect('/adminwork/bids','refresh');
		endif;
	}

	function bidUpdate()
	{
		$id=$this->input->post('fldId');
		$res=$this->adminworks->update('bids',$id,array(
			'status'=>$this->input->post('fldStatus')
		));
		if(!$res):
			echo 'Ошибка сохранения';
		else:
			echo 'Сохранено';
		endif;
	}

	function catalog($sub)
	{
		$subObj=$this->adminworks->get_sub($sub);
		$catObj=$this->adminworks->get_cat($subObj->parent);
		$this->load->view('admin/template',array(
			'title'=>'Каталог/'.$catObj->name.'/'.$subObj->name,
			'operations'=>array(
				'Добавить категорию'=>'/adminwork/catForm/-1',
				'Изменить категорию'=>'/adminwork/catForm/'.$catObj->id,
				'Добавить подкатегорию'=>'/adminwork/subForm/-1',
				'Изменить подкатегорию'=>'/adminwork/subForm/'.$sub,
				'Добавить товар'=>'/adminwork/productForm/-1'
			),
			'mainContent'=>$this->load->view('admin/catalog',array(
				'listArr'=>$this->adminworks->get_products($subObj->id)
			),true)
		));
	}
	
	function productForm($id)
	{
		$this->load->view('admin/template',array(
			'title'=>'Товар',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/productForm',array(
				'mainObj'=>$this->adminworks->get_by_id('products',$id),
				'listUnit'=>$this->adminworks->get_list('units'),
				'listSub'=>$this->adminworks->get_list('subcategories'),
				'listArr'=>$this->adminworks->get_product_spec($id),
				'listSpec'=>$this->adminworks->get_list('specifications'),
				'listSize'=>$this->adminworks->get_list('sizes'),
				'listPrSize'=>$this->adminworks->get_product_size($id)
			),true)
		));
	}

	function productImg()
	{
		$this->load->library('upload',array(
			'upload_path'=>'./public/images',
			'allowed_types'=>'jpg|png|jpeg|gif',
			'max_size'=>0,
			'encrypt_name'=>TRUE,
			'overwrite'=>TRUE
		));
		if(!$this->upload->do_upload('uploadImg')):
			echo 'Ошибка загрузки';
		else:
			$arr=$this->upload->data();
			echo $arr['file_name'];
		endif;
	}
	
	function productUpdate()
	{
		$id=$this->input->post('fldId');
		if($id == -1):
			$res=$this->adminworks->insert('products',array(
				'name'=>$this->input->post('fldName'),
				'description'=>$this->input->post('fldDescription'),
				'parent'=>$this->input->post('fldParent'),
				'unit'=>$this->input->post('fldUnit'),
				'price'=>$this->input->post('fldPrice'),
				'image'=>$this->input->post('fldImage')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Добавлено';
			endif;
		else:
			$res=$this->adminworks->update('products',$id,array(
				'name'=>$this->input->post('fldName'),
				'description'=>$this->input->post('fldDescription'),
				'parent'=>$this->input->post('fldParent'),
				'unit'=>$this->input->post('fldUnit'),
				'price'=>$this->input->post('fldPrice'),
				'image'=>$this->input->post('fldImage')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Сохранено';
			endif;
		endif;		
	}
	
	function productDelete()
	{
		$id=$this->input->post('fldId');
		$refArr=$this->adminworks->get_where('bid_products', array('product'=>$id));
		if(!$refArr):
			if($this->adminworks->delete('products',array('id'=>$id))):
				echo 'Продукт удален';
			else:
				echo 'Ошибка удаления';
			endif;
		else:
			echo 'Нельзя удалить продукт, на который оформлены заказы!';
		endif;
	}
	
	function categories()
	{
		$this->load->view('admin/template',array(
			'title'=>'Категории',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/catList',array(
				'listArr'=>$this->adminworks->get_all('categories')
			),true)
		));
	}
	
	function catForm($cat)
	{
		$this->load->view('admin/template',array(
			'title'=>'Категория',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/catForm',array(
				'mainObj'=>$this->adminworks->get_by_id('categories',$cat)
			),true)
		));		
	}

	function catUpdate()
	{
		$id=$this->input->post('fldId');
		if($id == -1):
			$res=$this->adminworks->insert('categories',array(
				'name'=>$this->input->post('fldName')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Добавлено';
			endif;
		else:
			$res=$this->adminworks->update('categories',$id,array(
				'name'=>$this->input->post('fldName')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Сохранено';
			endif;
		endif;		
	}

	function catDelete()
	{
		$id=$this->input->post('fldId');
		$refArr=$this->adminworks->get_where('subcategories', array('parent'=>$id));
		if(!$refArr):
			if($this->adminworks->delete('categories',array('id'=>$id))):
				echo 'Категория удалена';
			else:
				echo 'Ошибка удаления';
			endif;
		else:
			echo 'Нельзя удалить категорию, в которой есть подкатегории!';
		endif;
	}

	function subcategories()
	{
		$this->load->view('admin/template',array(
			'title'=>'Подкатегории',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/subList',array(
				'listArr'=>$this->adminworks->get_all('subcategories'),
				'listCategory'=>$this->adminworks->get_list('categories')
			),true)
		));
	}
	
	function subForm($sub)
	{
		$this->load->view('admin/template',array(
			'title'=>'Подкатегория',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/subForm',array(
				'mainObj'=>$this->adminworks->get_by_id('subcategories',$sub),
				'listCategory'=>$this->adminworks->get_list('categories')
			),true)
		));
	}

	function subUpdate()
	{
		$id=$this->input->post('fldId');
		if($id == -1):
			$res=$this->adminworks->insert('subcategories',array(
				'name'=>$this->input->post('fldName'),
				'parent'=>$this->input->post('fldParent')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Добавлено';
			endif;
		else:
			$res=$this->adminworks->update('subcategories',$id,array(
				'name'=>$this->input->post('fldName'),
				'parent'=>$this->input->post('fldParent')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Сохранено';
			endif;
		endif;		
	}

	function subDelete()
	{
		$id=$this->input->post('fldId');
		$refArr=$this->adminworks->get_where('products', array('parent'=>$id));
		if(!$refArr):
			if($this->adminworks->delete('subcategories',array('id'=>$id))):
				echo 'Подкатегория удалена';
			else:
				echo 'Ошибка удаления';
			endif;
		else:
			echo 'Нельзя удалить подкатегорию, в которой есть товары!';
		endif;
	}

	function productSpecUpdate()
	{
		$product=$this->input->post('fldProduct');
		$specification=$this->input->post('fldSpecification');
		$specValue=$this->input->post('fldSpecValue');
		$this->adminworks->delete('product_specifications',array(
			'product'=>$product,
			'specification'=>$specification
		));
		$res=$this->adminworks->insert('product_specifications',array(
			'product'=>$product,
			'specification'=>$specification,
			'value'=>$specValue
		));
		if(!$res):
			echo 'Ошибка сохранения';
		else:
			echo 'Сохранено';
		endif;		
	}
	
	function specifications()
	{
		$this->load->view('admin/template',array(
			'title'=>'Характеристики',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/specificationList',array(
				'listArr'=>$this->adminworks->get_all('specifications')
			),true)
		));
	}

	function specificationUpdate()
	{
		$id=$this->input->post('fldId');
		if($id == -1):
			$res=$this->adminworks->insert('specifications',array(
				'name'=>$this->input->post('fldName')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Добавлено';
			endif;
		else:
			$res=$this->adminworks->update('specifications',$id,array(
				'name'=>$this->input->post('fldName')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Сохранено';
			endif;
		endif;		
	}

	function productSizeUpdate()
	{
		$product=$this->input->post('fldProduct');
		$size=$this->input->post('fldSize');
		$quantity=$this->input->post('fldQuantity');
		$this->adminworks->delete('product_sizes',array(
			'product'=>$product,
			'size'=>$size
		));
		$res=$this->adminworks->insert('product_sizes',array(
			'product'=>$product,
			'size'=>$size,
			'quantity'=>$quantity
		));
		if(!$res):
			echo 'Ошибка сохранения';
		else:
			echo 'Сохранено';
		endif;		
	}
	
	function sizes()
	{
		$this->load->view('admin/template',array(
			'title'=>'Размеры',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/sizeList',array(
				'listArr'=>$this->adminworks->get_all('sizes')
			),true)
		));
	}
	
	function sizeForm($size)
	{
		$this->load->view('admin/template',array(
			'title'=>'Размер',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/sizeForm',array(
				'mainObj'=>$this->adminworks->get_by_id('sizes',$size)
			),true)
		));		
	}

	function sizeUpdate()
	{
		$id=$this->input->post('fldId');
		if($id == -1):
			$res=$this->adminworks->insert('sizes',array(
				'name'=>$this->input->post('fldName')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Добавлено';
			endif;
		else:
			$res=$this->adminworks->update('sizes',$id,array(
				'name'=>$this->input->post('fldName')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Сохранено';
			endif;
		endif;		
	}

	function sizeDelete()
	{
		$id=$this->input->post('fldId');
		$refArr_1=$this->adminworks->get_where('product_sizes', array('size'=>$id));
		$refArr_2=$this->adminworks->get_where('bid_products', array('size'=>$id));
		if(!$refArr_1&&!$refArr_2):
			if($this->adminworks->delete('categories',array('id'=>$id))):
				echo 'Размер удален';
			else:
				echo 'Ошибка удаления';
			endif;
		else:
			echo 'Нельзя удалить размер, на которой есть ссылки!';
		endif;
	}

	function pages()
	{
		$this->load->view('admin/template',array(
			'title'=>'Страницы',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/pageList',array(
				'listArr'=>$this->adminworks->get_all('pages')
			),true)
		));
	}

	function pageForm($sub)
	{
		$this->load->view('admin/template',array(
			'title'=>'Страница',
			'operations'=>false,
			'mainContent'=>$this->load->view('admin/pageForm',array(
				'mainObj'=>$this->adminworks->get_by_id('pages',$sub)
			),true)
		));
	}

	function pageUpdate()
	{
		$id=$this->input->post('fldId');
		if($id == -1):
			$res=$this->adminworks->insert('pages',array(
				'name'=>$this->input->post('fldName'),
				'content'=>$this->input->post('fldContent')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Добавлено';
			endif;
		else:
			$res=$this->adminworks->update('pages',$id,array(
				'name'=>$this->input->post('fldName'),
				'content'=>$this->input->post('fldContent')
			));
			if(!$res):
				echo 'Ошибка сохранения';
			else:
				echo 'Сохранено';
			endif;
		endif;		
	}

	function pageDelete()
	{
		$id=$this->input->post('fldId');
		if($this->adminworks->delete('pages',array('id'=>$id))):
			echo 'Страница удалена';
		else:
			echo 'Ошибка удаления';
		endif;
	}

}