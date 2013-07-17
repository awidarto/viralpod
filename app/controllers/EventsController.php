<?php

class EventsController extends AdminController {

	public function __construct()
	{
		parent::__construct();

		$this->controller_name = str_replace('Controller', '', get_class());

		//$this->crumb = new Breadcrumb();
		//$this->crumb->add(strtolower($this->controller_name),ucfirst($this->controller_name));

		$this->model = new Events();

	}


	public function getIndex()
	{

		$this->heads = array(
			array('Event Title',array('search'=>true,'sort'=>true)),
			array('Description',array('search'=>true,'sort'=>true)),
            array('Event Owner',array('search'=>true,'sort'=>true)),
			array('Start Date',array('search'=>true,'sort'=>true)),
			array('End Date',array('search'=>true,'sort'=>true)),
			array('Opening Hours',array('search'=>true,'sort'=>true)),
			array('Created',array('search'=>true,'sort'=>true,'date'=>true)),
			array('Last Update',array('search'=>true,'sort'=>true,'date'=>true)),
		);

		return parent::getIndex();

	}

	public function postIndex()
	{
		$this->model = LMongo::collection('events');

		$this->fields = array(
			array('eventTitle',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true,'attr'=>array('class'=>'expander'))),
			array('eventDescription',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
            array('eventOwner',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('startDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('endDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('openingHours',array('kind'=>'text','query'=>'like','pos'=>'both','show'=>true)),
			array('createdDate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
			array('lastUpdate',array('kind'=>'date','query'=>'like','pos'=>'both','show'=>true)),
		);

		return parent::postIndex();
	}

	public function postAdd($data = null)
	{

		$this->validator = array(
		    'eventTitle' => 'required',
		    'eventDescription'=> 'required'
	    );

        $data = Input::get();

        $data['startDate'] = new MongoDate(strtotime($data['startDate']));
        $data['endDate'] = new MongoDate(strtotime($data['endDate']));

		return parent::postAdd($data);
	}

	public function postEdit($id,$data = null)
	{
		$this->validator = array(
            'eventTitle' => 'required',
            'eventDescription'=> 'required'
	    );

		return parent::postEdit($id,$data);
	}

	public function makeActions($data)
	{
        $delete = '<span class="del" id="'.$data['_id'].'" ><i class="icon-trash"></i>Delete</span>';
        $edit = '<a href="'.URL::to('events/edit/'.$data['_id']).'"><i class="icon-edit"></i>Update</a>';

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
