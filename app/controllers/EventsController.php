<?php

class EventsController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());
		
		//$this->crumb = new Breadcrumb();
		//$this->crumb->add(strtolower($this->controller_name),ucfirst($this->controller_name));

		$this->model = new Product();

	}


	public function getIndex()
	{

		$this->heads = array(
			array('Brand',array('search'=>true,'sort'=>true)),
			array('Collection',array('search'=>true,'sort'=>true)),
			array('Trade Name',array('search'=>true,'sort'=>true)),
			array('Product',array('search'=>true,'sort'=>true)),
			array('Model No.',array('search'=>true,'sort'=>true)),
			array('Main Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_main_categories'))),
			array('Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_product_categories'))),
			array('Tags',array('search'=>true,'sort'=>true)),
			array('HTags',array('search'=>true,'sort'=>true)),
			array('Price',array('search'=>true,'sort'=>true)),
			array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
			array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
		);

		return parent::getIndex();

	}

	public function postIndex()
	{
		$this->model = LMongo::collection('products');

		$this->fields = array(
			array('brandName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
			array('collectionName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('tradeName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('modelNo',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('mainCategory',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('productCategory',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('visibleTags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('hiddenTags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('priceUSD',array('kind'=>'currency','query'=>'like','pos'=>'both','show'=>true)),
			array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
		);

		return parent::postIndex();
	}

	public function postAdd($data = null)
	{

		$this->validator = array(
		    'brandName' => array('Brand Name','required'),
		    'productName'=> 'required'
	    );

		return parent::postAdd($data);
	}

	public function postEdit($id,$data = null)
	{
		$this->validator = array(
		    'brandName' => 'required',
		    'productName'=> 'required'
	    );

		return parent::postEdit($id,$data);
	}

	public function makeActions($data)
	{
		$delete = '<a class="action icon-"><i>&#xe001;</i><span class="del" id="'.$data['_id'].'" >Delete</span>';
		$edit =	'<a class="icon-"  href="'.URL::to('products/edit/'.$data['_id']).'"><i>&#xe164;</i><span>Update Product</span>';

		$actions = $edit.$delete;
		return $actions;
	}

	public function namePic($data)
	{
		$name = HTML::link('products/view/'.$data['_id'],$data['name']);
		$display = HTML::image(URL::to('/').'/storage/products/'.$data['_id'].'/sm_pic0'.$data['defaultpic'].'.jpg?'.time(), 'sm_pic01.jpg', array('id' => $data['_id']));
		return $display.'<br />'.$name;
	}


}
