<?php
class Catalogs extends CI_Model {

	function get_catalog()
	{
        $query=$this->db->get('categories');
		$arr=$query->result();
		foreach($arr as $n=>$v):
        	$query1=$this->db->get_where('subcategories',array('parent'=>$v->id));
			$arr1=$query1->result();
			if(count($arr1)>0):
				$v->sub=$arr1;
			else:
				$v->sub=array();
			endif;
		endforeach;
		return $arr;
	}
	
	function get_products($parent)
	{
		$query=$this->db->query(
			'SELECT products.id, products.name, products.price, products.image, LEFT(products.description, 200) AS info
			FROM products
			WHERE (products.parent=?)',
			array($parent)
		);
		$arr=$query->result();
		return $arr;
	}

	function get_product_size($product)
	{
		$query=$this->db->query(
			'SELECT product_sizes.product, sizes.name AS sizeName, product_sizes.size, product_sizes.quantity
			FROM sizes INNER JOIN product_sizes ON sizes.id = product_sizes.size
			WHERE (product_sizes.product=?)',
			array($product)
		);
		$arr=array();
		foreach($query->result() as $row):
			if($row->quantity > 0):
				$arr[$row->size]=$row->sizeName;
			endif;
		endforeach;
		if(count($arr)>0):
			return $arr;
		else:
			return false;
		endif;
	}

	function get_cat($cat)
	{
       	$query=$this->db->get_where('categories',array('id'=>$cat));
		$arr=$query->result();
		return $arr[0];
	}

	function get_sub($sub)
	{
       	$query=$this->db->get_where('subcategories',array('id'=>$sub));
		$arr=$query->result();
		return $arr[0];
	}
	
	function get_product_spec($product)
	{
		$query=$this->db->query(
			'SELECT product_specifications.product, specifications.name AS specName, product_specifications.specification, product_specifications.value
			FROM specifications INNER JOIN product_specifications ON specifications.id = product_specifications.specification
			WHERE (product_specifications.product=?)',
			array($product)
		);
		$arr=$query->result();
		return $arr;
	}
	
	function get_cart_products($cartArr)
	{
		if(count($cartArr)>0):
			$res=array();
			foreach($cartArr as $n=>$v):
				$productObj=$this->get_by_id('products',$v['product']);
				$sizeObj=$this->get_by_id('sizes',$v['size']);
				if($productObj):
					$productObj->cartQuantity=$v['quantity'];
					$productObj->sizeName=$sizeObj->name;
					$productObj->size=$v['size'];
					$res[]=$productObj;
				endif;
			endforeach;
			return $res;
		else:
			return false;
		endif;
	}
	
	function insert_bid($name,$address,$phone,$email,$cartArr)
	{
		if($this->db->insert('bids',array(
				'dates'=>date("Y-m-d"),
				'name'=>$name,
				'address'=>$address,
				'phone'=>$phone,
				'email'=>$email,
				'status'=>1
			))):
			$bidId=$this->db->insert_id();
			foreach($cartArr as $n=>$v):
				$productObj=$this->get_by_id('products',$v['product']);
				$this->insert('bid_products',array(
					'bid'=>$bidId,
					'product'=>$productObj->id,
					'quantity'=>$v['quantity'],
					'price'=>$productObj->price
				));
			endforeach;
			return true;
		else:
			return false;
		endif;
	}
	
	function get_all($table)
	{
        $query=$this->db->get($table);
		$arr=$query->result();
		if(count($arr)>0):
			return $arr;
		else:
			return false;
		endif;
	}

	function get_by_id($table,$id)
	{
        $query=$this->db->get_where($table,array('id'=>$id));
		$arr=$query->result();
		if(count($arr)>0):
			return $arr[0];
		else:
			return false;
		endif;
	}
	
	function get_list($table)
	{
		$query=$this->db->get($table);
		$arr=array();
		foreach($query->result() as $row):
			$arr[$row->id]=$row->name;
		endforeach;
		return $arr;
	}

    function get_where($table,$arr)
    {
        $query=$this->db->get_where($table,$arr);
		$arr=$query->result();
		if(count($arr)>0):
			return $arr;
		else:
			return false;
		endif;
    }

	function insert($table,$arr)
	{
        if($this->db->insert($table,$arr)):
			return true;
		else:
			return false;
		endif;
	}	
}