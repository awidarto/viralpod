<?php

class CompaniesController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());

        //$this->crumb->append($this->controller_name);
        $this->crumb->append('Home','left',true);
		$this->crumb->append(strtolower($this->controller_name));

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

    public function postAdd($data = null)
    {
        $data = Input::get();

        $users = LMongo::collection('users');

        if( $user = $users->where('username',$data['username'])->first() ){

            unset($data['password']);
            unset($data['repass']);

        }else{
            $newuser['fullname'] = $data['fullname'];
            $newuser['username'] = $data['username'];
            $newuser['designation'] = $data['designation'];
            $newuser['company'] = $data['companyName'];
            $newuser['password'] = Hash::make($data['password']);

            unset($data['password']);
            unset($data['repass']);


            if($in = $users->insert($newuser)){
                $data['userid'] = $in->__toString();
            }
        }

        return parent::postAdd($data);
    }

    public function postEdit($id,$data = null)
    {

        $data = Input::get();

        $validator = array(
            'companyName' => 'required',
            'mainCategory'=> 'required'
        );

        if($data['password'] != ''){
            $validator['password'] = 'same:repass';
        }

        $this->validator = $validator;

        $users = LMongo::collection('users');

        if( $data['userid'] == '' ||
            $data['oldusername'] == '' ||
            $data['username'] != $data['oldusername'] ) // new account holder
        {

            if( $user = $users->where('username',$data['username'])->first() ){ // can not use existing username

                unset($data['password']);
                unset($data['repass']);

            }else{
                $newuser['fullname'] = $data['fullname'];
                $newuser['username'] = $data['username'];
                $newuser['designation'] = $data['designation'];
                $newuser['company'] = $data['companyName'];
                $newuser['password'] = Hash::make($data['password']);

                unset($data['password']);
                unset($data['repass']);

                if($in = $users->insert($newuser)){
                    $data['userid'] = $in->__toString();
                }
            }

        }else if($data['userid'] != '' && ($data['username'] == $data['oldusername']) ){

            $userdata['fullname'] = $data['fullname'];
            $userdata['designation'] = $data['designation'];
            $userdata['company'] = $data['companyName'];

            if($data['password'] != ''){
                $userdata['password'] = Hash::make($data['password']);
            }

            unset($data['password']);
            unset($data['repass']);

            $in = $users->where('username',$data['username'])->update($userdata);
        }

        return parent::postEdit($id,$data);
    }

    public function getDetail($id)
    {

        $company = $this->model->find($id);

        $this->crumb->append($company['_id']->__toString(),'right',false,$company['companyName']);

        $pheads = array(
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

        $select_all = Former::checkbox()->name('Select All')->check(false)->id('select_all');

        array_unshift($pheads, array($select_all,array('search'=>false,'sort'=>false)));
        array_unshift($pheads, array('#',array('search'=>false,'sort'=>false)));

        // add action column
        array_push($pheads,
            array('Actions',array('search'=>false,'sort'=>false,'clear'=>true))
        );

        return View::make('companies.detail')
            ->with('ajaxsource','products' )
            ->with('disablesort','0,1' )
            ->with('ajaxdel',URL::to('products/del') )
            ->with('heads',$pheads)
            ->with('crumb',$this->crumb)
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