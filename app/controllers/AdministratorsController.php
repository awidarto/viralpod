<?php

class AdministratorsController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());

		//$this->crumb = new Breadcrumb();
		//$this->crumb->add(strtolower($this->controller_name),ucfirst($this->controller_name));

		$this->model = new Admin();

	}

	public function getIndex()
	{

		$this->heads = array(
			array('Name',array('search'=>true,'sort'=>true)),
			array('Email',array('search'=>true,'sort'=>true)),
			array('Mobile',array('search'=>true,'sort'=>true)),
			array('Role',array('search'=>true,'sort'=>true)),
			array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
			array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
		);

		return parent::getIndex();

	}

	public function postIndex()
	{
		$this->model = LMongo::collection('admins');

		$this->fields = array(
			array('fullname',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
			array('username',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('mobile',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('role',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
		);

		return parent::postIndex();
	}

    public function postAdd($data = null)
    {

        $this->validator = array(
            'fullname' => 'required',
            'username'=> 'required|email',
            'password'=> 'required|same:repeatpassword'
        );

        return parent::postAdd($data);
    }

    public function postEdit($id,$data = null)
    {
        $this->validator = array(
            'fullname' => 'required'
        );

        return parent::postEdit($id,$data);
    }

    public function makeActions($data)
    {
        $delete = '<span class="del" id="'.$data['_id'].'" ><i class="icon-trash"></i>Delete</span>';
        $edit = '<a href="'.URL::to('administrators/edit/'.$data['_id']).'"><i class="icon-edit"></i>Update</a>';

        $actions = $edit.'<br />'.$delete;
        return $actions;
    }



}