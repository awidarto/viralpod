<?php

class ProductsController extends AdminController {

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
			array('Name',array('search'=>true,'sort'=>true)),
			array('Product Code',array('search'=>true,'sort'=>true)),
			array('Permalink',array('search'=>true,'sort'=>true)),
			array('Description',array('search'=>true,'sort'=>true)),
			array('Section',array('search'=>true,'sort'=>true,'select'=>Config::get('shoplite.search_sections'))),
			//array('Category',array('search'=>true,'sort'=>true,'select'=>Config::get('content.news.categories'))),
			//array('Category',array('search'=>true,'sort'=>true)),
			//array('Tags',array('search'=>true,'sort'=>true)),
			array('Currency',array('search'=>true,'sort'=>true)),
			array('Retail Price',array('search'=>true,'sort'=>true)),
			array('Sale Price',array('search'=>true,'sort'=>true)),
			//array('Effective From',array('search'=>true,'sort'=>true)),
			//array('Effective Until',array('search'=>true,'sort'=>true)),
			array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
			array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
			//array('Productsequence',array('search'=>true,'sort'=>true))
		);

		return parent::getIndex();

	}

	public function postIndex()
	{
		$this->fields = array(
			array('name',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'callback'=>'namePic','attr'=>array('class'=>'expander'))),
			array('productcode',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('permalink',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('description',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('section',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			//array('category',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			//array('tags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('priceCurrency',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('retailPrice',array('kind'=>'currency','query'=>'like','pos'=>'both','show'=>true)),
			array('salePrice',array('kind'=>'currency','query'=>'like','pos'=>'both','show'=>true)),
			//array('effectiveFrom',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			//array('effectiveUntil',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			//array('productsequence',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true))
		);

		return parent::postIndex();
	}

	public function makeActions($data){
		$delete = '<a class="action icon-"><i>&#xe001;</i><span class="del" id="'.$data['_id'].'" >Delete</span>';
		$edit =	'<a class="icon-"  href="'.URL::to('products/edit/'.$data['_id']).'"><i>&#xe164;</i><span>Update Product</span>';

		$actions = $edit.$delete;
		return $actions;
	}

	public function namePic($data){
		$name = HTML::link('products/view/'.$data['_id'],$data['name']);
		$display = HTML::image(URL::to('/').'/storage/products/'.$data['_id'].'/sm_pic0'.$data['defaultpic'].'.jpg?'.time(), 'sm_pic01.jpg', array('id' => $data['_id']));
		return $display.'<br />'.$name;
	}


}
