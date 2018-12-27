<?php
class Catalog extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('catalogs');
		$this->catalog=$this->catalogs->get_catalog();
		$this->pages=$this->catalogs->get_list('pages');
		//
		if(!$this->session->userdata('cartArr')):
			$this->session->set_userdata(array('cartArr'=>array()));
		endif;
		$this->cart=$this->session->userdata('cartArr');
	}
	
	function index()
	{
		$this->products(1);
	}

	function products($sub)
	{
		$subObj=$this->catalogs->get_sub($sub);
		$catObj=$this->catalogs->get_cat($subObj->parent);
		$this->load->view('client/template',array(
			'title'=>'Каталог/'.$catObj->name.'/'.$subObj->name,
			'mainContent'=>$this->load->view('client/catalog',array(
				'listArr'=>$this->catalogs->get_products($subObj->id)
			),true)
		));
	}
	
	function product($id)
	{
		$mainObj=$this->catalogs->get_by_id('products',$id);
		if($mainObj):
			$this->load->view('client/template',array(
				'title'=>$mainObj->name,
				'mainContent'=>$this->load->view('client/productForm',array(
					'mainObj'=>$this->catalogs->get_by_id('products',$id),
					'listSize'=>$this->catalogs->get_product_size($id),
					'listArr'=>$this->catalogs->get_product_spec($id)
				),true)
			));
		else:
			redirect('/catalog','refresh');
		endif;
	}
	
	function cart()
	{
		$this->load->view('client/template',array(
			'title'=>'Корзина',
			'mainContent'=>$this->load->view('client/cartForm',array(
				'listArr'=>$this->catalogs->get_cart_products($this->cart)
			),true)
		));
	}
	
	function cartUpdate()
	{
		$product=intval($this->input->post('fldId'));
		$size=intval($this->input->post('fldSize'));
		$quantity=intval($this->input->post('fldQuantity'));
		if($quantity>0):
			$flag=true;
			foreach($this->cart as $n=>$v):
				if($v['product']==$product):
					$this->cart[$n]['quantity']=$quantity;
					$this->cart[$n]['size']=$size;
					$flag=false;
				endif;
			endforeach;
			if($flag):
				$this->cart[]=array(
					'product'=>$product,
					'size'=>$size,
					'quantity'=>$quantity
				);
			endif;
			$this->session->set_userdata(array('cartArr'=>$this->cart));
		elseif($quantity==0):
			foreach($this->cart as $n=>$v):
				if($v['product']==$product):
					unset($this->cart[$n]);
					break;
				endif;
			endforeach;
			$this->session->set_userdata(array('cartArr'=>$this->cart));
		endif;
		echo count($this->cart);
	}
	
	function cartClear()
	{
		$this->cart=array();
		$this->session->set_userdata(array('cartArr'=>$this->cart));
		redirect('/catalog/cart','refresh');
	}
	
	function cartToBid()
	{
		if(count($this->cart)>0):
			$this->catalogs->insert_bid(
				$this->input->post('fldName'),
				$this->input->post('fldAddress'),
				$this->input->post('fldPhone'),
				$this->input->post('fldEmail'),
				$this->cart
			);
		endif;
		$this->cart=array();
		$this->session->set_userdata(array('cartArr'=>$this->cart));
		redirect('/catalog/cart','refresh');
	}
	
	function pages($page)
	{
		$mainObj=$this->catalogs->get_by_id('pages',$page);
		if($mainObj):
			$this->load->view('client/template',array(
				'title'=>$mainObj->name,
				'mainContent'=>$mainObj->content
			));
		else:
			redirect('/catalog','refresh');
		endif;
	}
}