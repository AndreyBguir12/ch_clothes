<?php
class Adminworks extends CI_Model {

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
			'SELECT products.id, products.name, products.price, units.name AS unitName
			FROM units INNER JOIN products ON units.id = products.unit
			WHERE (products.parent=?)',
			array($parent)
		);
		$arr=$query->result();
		return $arr;
	}
	
	function get_bids()
	{
		$query=$this->db->query(
			'SELECT bids.id, bids.dates, queryBidSumm.bidSumm, status_bids.name AS statusName
			FROM status_bids INNER JOIN (
				bids INNER JOIN (
					SELECT bid_products.bid, Sum(bid_products.quantity*bid_products.price) AS bidSumm
					FROM bid_products
					GROUP BY bid_products.bid
				) AS queryBidSumm ON bids.id = queryBidSumm.bid
			) ON status_bids.id = bids.status'
		);
		$arr=$query->result();
		return $arr;
	}
	
	function get_bid_products($bid)
	{
		$query=$this->db->query(
			'SELECT bid_products.product, products.name AS productName, sizes.name AS sizeName, bid_products.quantity, bid_products.price, (bid_products.quantity*bid_products.price) AS summ
			FROM sizes INNER JOIN (
				products INNER JOIN bid_products ON products.id = bid_products.product
			) ON sizes.id = bid_products.size
			WHERE (bid_products.bid=?)',
			array($bid)
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
		$arr=$query->result();
		return $arr;
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

	function get_list_where($table,$arr)
	{
        $query=$this->db->get_where($table,$arr);
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

	function update($table,$id,$arr)
    {
		$this->db->where('id',$id);
        return $this->db->update($table,$arr);
    }
	
	function delete($table,$arr)
	{
		$this->db->where($arr);
        return $this->db->delete($table);
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