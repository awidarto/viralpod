<?php

class ProjectsController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());

        $this->crumb->append('Home','left',true);
        $this->crumb->append(strtolower($this->controller_name));

		$this->model = new Product();

	}


	public function getIndex()
	{

		$this->heads = array(
			array('Project Name',array('search'=>true,'sort'=>true)),
			array('Product Used',array('search'=>true,'sort'=>true)),
			array('Project Application',array('search'=>true,'sort'=>true)),
			array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
			array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
		);

		return parent::getIndex();

	}

	public function postIndex()
	{
		$this->model = LMongo::collection('products');

		$this->fields = array(
			array('projectName',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
			array('productUsed',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('projectApplication',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
		);

		return parent::postIndex();
	}

	public function postAdd($data = null)
	{

		$this->validator = array(
		    'projectName' => 'required'
	    );

		return parent::postAdd($data);
	}

	public function postEdit($id,$data = null)
	{
		$this->validator = array(
            'projectName' => 'required'
	    );

		return parent::postEdit($id,$data);
	}

	public function makeActions($data)
	{
		$delete = '<span class="del" id="'.$data['_id'].'" ><i class="icon-trash"></i>Delete</span>';
		$edit =	'<a href="'.URL::to('projects/edit/'.$data['_id']).'"><i class="icon-edit"></i>Update</a>';

		$actions = $edit.'<br />'.$delete;
		return $actions;
	}

	public function namePic($data)
	{
		$name = HTML::link('products/view/'.$data['_id'],$data['name']);
		$display = HTML::image(URL::to('/').'/storage/products/'.$data['_id'].'/sm_pic0'.$data['defaultpic'].'.jpg?'.time(), 'sm_pic01.jpg', array('id' => $data['_id']));
		return $display.'<br />'.$name;
	}


}
