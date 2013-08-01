<?php

class MembersController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());

        $this->crumb->append('Home','left',true);
        $this->crumb->append(strtolower($this->controller_name));

		$this->model = new Member();

	}

	public function getIndex()
	{

		$this->heads = array(
			array('Name',array('search'=>true,'sort'=>true)),
			array('Email',array('search'=>true,'sort'=>true)),
			array('Company',array('search'=>true,'sort'=>true)),
			array('Designation',array('search'=>true,'sort'=>true)),
			array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
			array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
		);

		return parent::getIndex();

	}

	public function postIndex()
	{
		$this->model = LMongo::collection('users');

		$this->fields = array(
			array('fullname',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
			array('username',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('company',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('designation',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
		);

		return parent::postIndex();
	}

    public function makeActions($data)
    {
        $delete = '<span class="del" id="'.$data['_id'].'" ><i class="icon-trash"></i>Delete</span>';
        $edit = '<a href="'.URL::to('members/edit/'.$data['_id']).'"><i class="icon-edit"></i>Update</a>';
        $addcompany = '<a href="'.URL::to('companies/add/'.$data['_id']).'"><i class="icon-edit"></i>Add Company</a>';

        $actions = $edit.'<br />'.$delete.'<br />'.$addcompany;
        return $actions;
    }

}