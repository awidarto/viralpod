<?php

class CompaniesController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());

        $this->beforeFilter('auth', array('on'=>'get', 'only'=>array('getIndex','getAdd','getEdit','getDetail') ));

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

        $productheads = array(
            array('Product',array('search'=>true,'sort'=>true)),
            //array('Images',array('search'=>false,'sort'=>false)),
            array('Brand',array('search'=>true,'sort'=>true)),
            array('Collection',array('search'=>true,'sort'=>true)),
            array('Trade Name',array('search'=>true,'sort'=>true)),
            array('Model No.',array('search'=>true,'sort'=>true)),
            array('Main Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_main_categories'))),
            array('Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_product_categories'))),
            //array('Tags',array('search'=>true,'sort'=>true)),
            //array('HTags',array('search'=>true,'sort'=>true)),
            array('Price',array('search'=>true,'sort'=>true)),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        $offheads = array(
            array('Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_office_categories'))),
            array('Location',array('search'=>true,'sort'=>true)),
            array('Country',array('search'=>true,'sort'=>true,'select'=>Config::get('country.countries'))),
            array('City',array('search'=>true,'sort'=>true)),
            array('Email',array('search'=>true,'sort'=>true)),
            array('Phone',array('search'=>true,'sort'=>true)),
            array('Fax',array('search'=>true,'sort'=>true)),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        $agentheads = array(
            array('Category',array('search'=>true,'sort'=>true,'select'=>Config::get('se.search_agent_categories'))),
            array('Location',array('search'=>true,'sort'=>true)),
            array('Country',array('search'=>true,'sort'=>true,'select'=>Config::get('country.countries'))),
            array('City',array('search'=>true,'sort'=>true)),
            array('Region Covered',array('search'=>true,'sort'=>true,'select'=>Config::get('region.search_regions'))),
            array('Country Covered',array('search'=>true,'sort'=>true,'select'=>Config::get('country.countries'))),
            array('Specific Local Region',array('search'=>true,'sort'=>true)),
            array('Email',array('search'=>true,'sort'=>true)),
            array('Phone',array('search'=>true,'sort'=>true)),
            array('Fax',array('search'=>true,'sort'=>true)),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        $eventheads = array(
            array('Title',array('search'=>true,'sort'=>true )),
            array('Description',array('search'=>true,'sort'=>true)),
            array('Owner',array('search'=>true,'sort'=>true)),
            array('Start',array('search'=>true,'sort'=>true,'date'=>true)),
            array('End',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Opening Hours',array('search'=>true,'sort'=>true)),
            array('Tags',array('search'=>true,'sort'=>true)),
            array('HTags',array('search'=>true,'sort'=>true)),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        $projectheads = array(
            array('Name',array('search'=>true,'sort'=>true )),
            array('Application',array('search'=>true,'sort'=>true)),
            array('Product Used',array('search'=>true,'sort'=>true)),
            array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
            array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
        );

        $select_all = Former::checkbox()->name('Select All')->check(false)->id('select_all');

        //product head
        $productheads = $this->completeHeads($productheads);
        //office head
        $offheads = $this->completeHeads($offheads);
        //agent head
        $agentheads = $this->completeHeads($agentheads);

        $eventheads = $this->completeHeads($eventheads);

        $projectheads = $this->completeHeads($projectheads);

        return View::make('companies.detail')
            ->with('ajaxsource',URL::to('companies/products/'.$id ) )
            ->with('disablesort','0,1' )
            ->with('ajaxdel',URL::to('products/del') )

            ->with('productheads',$productheads)
            ->with('officeheads',$offheads)
            ->with('agentheads',$agentheads)
            ->with('eventheads',$eventheads)
            ->with('projectheads',$projectheads)

            ->with('crumb',$this->crumb)
            ->with('company',$company);
    }

    public function getProducts($id)
    {
        $company = $this->model->find($id);

        $this->heads = array(
            array('Product',array('search'=>true,'sort'=>true)),
            //array('Images',array('search'=>false,'sort'=>false)),
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

    public function postProducts($company)
    {

        $this->model = LMongo::collection('products');

        $this->model->where('companyId',$company);

        $this->fields = array(
            //array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
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

    public function postProjects($company)
    {

        $this->model = LMongo::collection('project');

        $this->model->where('companyId',$company);

        $this->fields = array(
            //array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('projectName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
            array('projectApplication',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('productUsed',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
        );

        return $this->tableResponder();
    }

    public function postEvents($company)
    {

        $this->model = LMongo::collection('events');

        $this->model->where('companyId',$company);

        $this->fields = array(
            //array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('eventTitle',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('eventDescription',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
            array('eventOwner',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('startDate',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('endDate',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('openingHours',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('visibleTags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('hiddenTags',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
        );

        return $this->tableResponder();
    }

    public function postOffices($company)
    {

        $this->model = LMongo::collection('offices');

        $this->model->where('companyId',$company);

        $this->fields = array(
            //array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('officeCategory',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('location',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
            array('country',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('city',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('email',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('phone',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('fax',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
        );

        return $this->tableResponder();
    }

    public function postAgents($company)
    {

        $this->model = LMongo::collection('distributors');

        $this->model->where('companyId',$company);

        $this->fields = array(
            //array('productName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
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
            return $name.'<br />'.$display.'<br /><span class="img-more" id="'.$data['_id'].'">more images</span>';
        }else{
            return $name;
        }
    }

    public function postDistributors($company)
    {

        $this->model = LMongo::collection('distributors');

        $this->model->where('companyId',$company);

        $this->fields = array(
            array('agentCategory',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('location',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
            array('country',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('city',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('region',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('countryCoveredAgent',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('specificLocalRegionAgent',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('email',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('phone',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('fax',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
            array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
        );

        return $this->tableResponder();
    }

    public function getAddoffice($id)
    {
        return View::make('companies.addoffice')
            ->with('companyId',$id)
            ->with('ajaxpost','companies/addoffice');
    }

    public function postAddoffice()
    {

        $data = Input::get();

        $validator = array(
            'companyId' => 'required',
            'email'=> 'required'
        );

        $validation = Validator::make($input = $data, $validator);

        if($validation->fails()){

            return Response::json(array('status'=>'INVALID'));

        }else{

            unset($data['csrf_token']);

            $data['createdDate'] = new MongoDate();
            $data['lastUpdate'] = new MongoDate();

            $model = LMongo::collection('offices');

            if($obj = $model->insert($data)){

                //Event::fire('product.createformadmin',array($obj['_id'],$passwordRandom,$obj['conventionPaymentStatus']));
                return Response::json(array('status'=>'OK'));
            }else{
                return Response::json(array('status'=>'SAVEFAILED'));
            }


        }

    }

    public function getAddagent($id)
    {
        return View::make('companies.adddistributor')
            ->with('companyId',$id)
            ->with('ajaxpost','companies/addagent');
    }

    public function postAddagent()
    {

        $data = Input::get();

        $validator = array(
            'companyId' => 'required',
            'email'=> 'required'
        );

        $validation = Validator::make($input = $data, $validator);

        if($validation->fails()){

            return Response::json(array('status'=>'INVALID'));

        }else{

            unset($data['csrf_token']);

            $data['createdDate'] = new MongoDate();
            $data['lastUpdate'] = new MongoDate();

            $model = LMongo::collection('distributors');

            if($obj = $model->insert($data)){

                //Event::fire('product.createformadmin',array($obj['_id'],$passwordRandom,$obj['conventionPaymentStatus']));
                return Response::json(array('status'=>'OK'));
            }else{
                return Response::json(array('status'=>'SAVEFAILED'));
            }


        }

    }

    public function getAddproduct($id)
    {
        return View::make('companies.addproduct')
            ->with('companyId',$id)
            ->with('ajaxpost','companies/addproduct');
    }

    public function postAddproduct()
    {

        $data = Input::get();

        $validator = array(
            'companyId' => 'required'
        );

        $validation = Validator::make($input = $data, $validator);

        if($validation->fails()){

            return Response::json(array('status'=>'INVALID'));

        }else{

            unset($data['csrf_token']);

            $data['createdDate'] = new MongoDate();
            $data['lastUpdate'] = new MongoDate();

            $model = LMongo::collection('products');

            if($obj = $model->insert($data)){

                //Event::fire('product.createformadmin',array($obj['_id'],$passwordRandom,$obj['conventionPaymentStatus']));
                return Response::json(array('status'=>'OK'));
            }else{
                return Response::json(array('status'=>'SAVEFAILED'));
            }


        }

    }


    public function getAddevent($id)
    {
        return View::make('companies.addevent')
            ->with('companyId',$id)
            ->with('ajaxpost','companies/addevent');
    }

    public function postAddevent()
    {

        $data = Input::get();

        $validator = array(
            'companyId' => 'required'
        );

        $validation = Validator::make($input = $data, $validator);

        if($validation->fails()){

            return Response::json(array('status'=>'INVALID'));

        }else{

            unset($data['csrf_token']);

            $data['createdDate'] = new MongoDate();
            $data['lastUpdate'] = new MongoDate();

            $model = LMongo::collection('events');

            if($obj = $model->insert($data)){

                //Event::fire('product.createformadmin',array($obj['_id'],$passwordRandom,$obj['conventionPaymentStatus']));
                return Response::json(array('status'=>'OK'));
            }else{
                return Response::json(array('status'=>'SAVEFAILED'));
            }


        }

    }


    public function getAddproject($id)
    {
        return View::make('companies.addproject')
            ->with('companyId',$id)
            ->with('ajaxpost','companies/addproject');
    }

    public function postAddproject()
    {

        $data = Input::get();

        $validator = array(
            'companyId' => 'required'
        );

        $validation = Validator::make($input = $data, $validator);

        if($validation->fails()){

            return Response::json(array('status'=>'INVALID'));

        }else{

            unset($data['csrf_token']);

            $data['createdDate'] = new MongoDate();
            $data['lastUpdate'] = new MongoDate();

            $model = LMongo::collection('projects');

            if($obj = $model->insert($data)){

                //Event::fire('product.createformadmin',array($obj['_id'],$passwordRandom,$obj['conventionPaymentStatus']));
                return Response::json(array('status'=>'OK'));
            }else{
                return Response::json(array('status'=>'SAVEFAILED'));
            }


        }

    }


}