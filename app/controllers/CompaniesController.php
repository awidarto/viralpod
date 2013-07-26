<?php

class CompaniesController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());

		//$this->crumb = new Breadcrumb();
		//$this->crumb->add(strtolower($this->controller_name),ucfirst($this->controller_name));

		$this->model = new Company();

	}

	public function getIndex()
	{

		$this->heads = array(
			array('Name',array('search'=>true,'sort'=>true)),
			array('Email',array('search'=>true,'sort'=>true)),
			array('Website',array('search'=>true,'sort'=>true)),
			array('Expertise',array('search'=>true,'sort'=>true)),
            array('Category',array('search'=>true,'sort'=>true)),
			array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
			array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
		);

		return parent::getIndex();

	}

	public function postIndex()
	{
		$this->model = LMongo::collection('companies');

		$this->fields = array(
			array('companyName',array('kind'=>'text','query'=>'like','pos'=>'both','callback'=>'makeDetail','show'=>true,'attr'=>array('class'=>'expander'))),
			array('email',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('website',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('expertise',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('mainCategory',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
		);

		return parent::postIndex();
	}

    public function makeActions($data)
    {
        $detail = '<a href="'.URL::to('companies/detail/'.$data['_id']).'"><i class="icon-eye-open"></i>Detail</a>';
        $delete = '<span class="del" id="'.$data['_id'].'" ><i class="icon-trash"></i>Delete</span>';
        $edit = '<a href="'.URL::to('companies/edit/'.$data['_id']).'"><i class="icon-edit"></i>Update</a>';
        $products = '<a href="'.URL::to('companies/products/'.$data['_id']).'"><i class="icon-list-alt"></i>Products</a>';

        $actions = $detail.'<br />'.$edit.'<br />'.$delete.'<br />'.$products;
        return $actions;
    }

    public function makeDetail($data)
    {
        return '<a href="'.URL::to('companies/detail/'.$data['_id']).'">'.$data['companyName'].'</a>';
    }


    public function getDetail($id)
    {
        $company = $this->model->find($id);

        return View::make('companies.detail')
            ->with('company',$company);
    }

    public function getProducts($id)
    {
        $company = $this->model->find($id);

        $this->heads = array(
            array('Product',array('search'=>true,'sort'=>true)),
            array('Images',array('search'=>false,'sort'=>false)),
            array('Brand',array('search'=>true,'sort'=>true)),
            array('Collection',array('search'=>true,'sort'=>true)),
            array('Trade Name',array('search'=>true,'sort'=>true)),
            array('Model No.',array('search'=>true,'sort'=>true)),
            array('Main Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_main_categories'))),
            array('Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_product_categories'))),
            array('Tags',array('search'=>true,'sort'=>true)),
            array('HTags',array('search'=>true,'sort'=>true)),
            array('Price',array('search'=>true,'sort'=>true)),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        $this->ajaxsource = 'companies/products/'.$id;

        $this->addurl = 'companies/addproduct/'.$id;

        $this->rowdetail = null;

        $this->delurl = null;

        $this->newbutton = null;

        $this->title = $company['companyName'].'\'s Products';

        return $this->pageGenerator();
    }

    public function postProducts()
    {

        $this->model = LMongo::collection('products');

        $this->fields = array(
            array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','callback'=>'pics','show'=>true)),
            array('brandName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
            array('collectionName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('tradeName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('modelNo',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('mainCategory',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('productCategory',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('visibleTags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('hiddenTags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('priceUSD',array('kind'=>'currency','query'=>'like','pos'=>'both','show'=>true)),
            array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
        );

        return $this->tableResponder();
    }

    public function pics($data)
    {
        $name = HTML::link('products/view/'.$data['_id'],$data['productName']);
        if(isset($data['thumbnail_url']) && count($data['thumbnail_url'])){
            $display = HTML::image($data['thumbnail_url'][0].'?'.time(), $data['filename'][0], array('style'=>'min-width:100px;','id' => $data['_id']));
            return $display.'<br /><span class="img-more" id="'.$data['_id'].'">more images</span>';
        }else{
            return $name;
        }
    }


}