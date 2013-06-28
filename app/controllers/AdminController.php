<?php

class AdminController extends Controller {

	public $crumb;

	public $model;

	public $heads;

	public $fields;

	public $collection;

	public $controller_name;

	public $form;

	public $form_framework = 'TwitterBootstrap';

	public $form_class = 'form-horizontal';

	public $validator = array();

	public $actions = '';

	public $form_add = 'new';

	public $form_edit = 'edit';

	public $view_object = 'view';

	public $title = '';


	public function __construct(){

		date_default_timezone_set('Asia/Jakarta');

		Former::framework($this->form_framework);

	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}


	public function getIndex(){

		//$action_selection = Former::select( Config::get('kickstart.actionselection'))->name('action');

		$heads = $this->heads;

		$select_all = Former::checkbox('select_all')->check(false)->id('select_all');

		// add selector and sequence columns
		array_unshift($heads, array($select_all,array('search'=>false,'sort'=>false)));
		array_unshift($heads, array('#',array('search'=>false,'sort'=>false)));

		// add action column
		array_push($heads,
			array('Actions',array('search'=>false,'sort'=>false,'clear'=>true))
		);

		$disablesort = array();

		for($s = 0; $s < count($heads);$s++){
			if($heads[$s][1]['sort'] == false){
				$disablesort[] = $s;
			}
		}

		$disablesort = implode(',',$disablesort);

		return View::make('tables.simple')
			->with('title',$this->title)
			->with('newbutton', Str::singular($this->controller_name))
			->with('disablesort',$disablesort)
			->with('addurl',strtolower($this->controller_name).'/add')
			->with('ajaxsource',URL::to(strtolower($this->controller_name)))
			->with('ajaxdel',URL::to(strtolower($this->controller_name).'/del'))
			->with('crumb',$this->crumb)
			->with('heads',$heads)
			->nest('row',strtolower($this->controller_name).'.rowdetail');


	}


	public function postIndex()
	{

		$fields = $this->fields;

		array_unshift($fields, array('select',array('kind'=>false)));
		array_unshift($fields, array('seq',array('kind'=>false)));

		$pagestart = Input::get('iDisplayStart');
		$pagelength = Input::get('iDisplayLength');

		$limit = array($pagelength, $pagestart);

		$defsort = 1;
		$defdir = -1;

		$idx = 0;
		$q = array();

		$hilite = array();
		$hilite_replace = array();

		$model = $this->model;

		$count_all = $model->count();

		for($i = 0;$i < count($fields);$i++){
			$idx = $i;
			//print_r($fields[$i]);
			$field = $fields[$i][0];
			$type = $fields[$i][1]['kind'];

			$qval = '';

			if(Input::get('sSearch_'.$i))
			{
				if( $type == 'text'){
					if($fields[$i][1]['query'] == 'like'){
						$pos = $fields[$i][1]['pos'];
						if($pos == 'both'){
							$qval = new MongoRegex('/'.Input::get('sSearch_'.$idx).'/i');
						}else if($pos == 'before'){
							$qval = new MongoRegex('/^'.Input::get('sSearch_'.$idx).'/i');
						}else if($pos == 'after'){
							$qval = new MongoRegex('/'.Input::get('sSearch_'.$idx).'$/i');
						}
					}else{
						$qval = Input::get('sSearch_'.$idx);
					}
				}elseif($type == 'numeric' || $type == 'currency'){
					$str = Input::get('sSearch_'.$idx);

					$sign = null;

					if(strpos($str, "<=") !== false){
						$sign = '$lte';
					}elseif(strpos($str, ">=") !== false){
						$sign = '$gte';
					}elseif(strpos($str, ">") !== false){
						$sign = '$gt';
					}elseif(stripos($str, "<") !== false){
						$sign = '$lt';
					}

					//print $sign;

					$str = trim(str_replace(array('<','>','='), '', $str));

					if(is_null($sign)){
						$qval = new MongoInt32($str);
					}else{
						$str = new MongoInt32($str);
						$qval = array($sign=>$str);
					}
				}elseif($type == 'date'){
					$datestring = Input::get('sSearch_'.$idx);

					if (($timestamp = strtotime($datestring)) === false) {
					} else {
						$daystart = new MongoDate(strtotime($datestring.' 00:00:00'));
						$dayend = new MongoDate(strtotime($datestring.' 23:59:59'));

						$qval = array($field =>array('$gte'=>$daystart,'$lte'=>$dayend));
					    //echo "$str == " . date('l dS \o\f F Y h:i:s A', $timestamp);
					}
					$qval = array('$gte'=>$daystart,'$lte'=>$dayend);
					//$qval = Input::get('sSearch_'.$idx);
				}elseif($type == 'datetime'){
					$datestring = Input::get('sSearch_'.$idx);
					$qval = new MongoDate(strtotime($datestring));
				}

				$model->where($field,$qval);
				
				$q[$field] = $qval;

			}

		}

		//print_r($q);


		/* first column is always sequence number, so must be omitted */
		$fidx = Input::get('iSortCol_0') - 1;

		$fidx = ($fidx == -1 )?0:$fidx;

		$sort_col = $fields[$fidx][0];
		$sort_dir = Input::get('sSortDir_0');

		/*
		if(count($q) > 0){
			$results = $model->skip( $pagestart )->take( $pagelength )->orderBy($sort_col, $sort_dir )->get();
			$count_display_all = $model->count();
		}else{
			$results = $model->find(array(),array(),array($sort_col=>$sort_dir),$limit);
			$count_display_all = $model->count();
		}
		*/

		$results = $model->skip( $pagestart )->take( $pagelength )->orderBy($sort_col, $sort_dir )->get();
		$count_display_all = $model->count();

		//print_r($results);

		$aadata = array();

		$form = $this->form;

		$counter = 1 + $pagestart;

		foreach ($results as $doc) {

			$extra = $doc;

			//$select = Former::checkbox('sel_'.$doc['_id'])->check(false)->id($doc['_id'])->class('selector');

			$actions = $this->makeActions($doc);

			$row = array();

			$row[] = $counter;
			$row[] = Former::checkbox('sel_'.$doc['_id'])->check(false)->id($doc['_id'])->class('selector');

			foreach($fields as $field){
				if($field[1]['kind'] != false && $field[1]['show'] == true){

					$fieldarray = explode('.',$field[0]);
					if(is_array($fieldarray) && count($fieldarray) > 1){
						$fieldarray = implode('\'][\'',$fieldarray);
						$cstring = '$label = (isset($doc[\''.$fieldarray.'\']))?true:false;';
						eval($cstring);
					}else{
						$label = (isset($doc[$field[0]]))?true:false;
					}


					if($label){

						if( isset($field[1]['callback']) && $field[1]['callback'] != ''){
							$callback = $field[1]['callback'];
							$row[] = $this->$callback($doc);
						}else{
							if($field[1]['kind'] == 'datetime'){
								$rowitem = date('d-m-Y H:i:s',$doc[$field[0]]->sec);
							}elseif($field[1]['kind'] == 'date'){
								$rowitem = date('d-m-Y',$doc[$field[0]]->sec);
							}elseif($field[1]['kind'] == 'currency'){
								$num = (double) $doc[$field[0]];
								$rowitem = number_format($num,2,',','.');
							}else{
								$rowitem = $doc[$field[0]];
							}

							if(isset($field[1]['attr'])){
								$attr = '';
								foreach ($field[1]['attr'] as $key => $value) {
									$attr .= '"'.$key.'"="'.$value.'" ';
								}
								$row[] = '<span '.$attr.' >'.$rowitem.'</span>';
							}else{
								$row[] = $rowitem;
							}

						}


					}else{
						$row[] = '';
					}
				}
			}

			$row[] = $actions;
			$row['extra'] = $extra;

			$aadata[] = $row;

			$counter++;
		}


		$result = array(
			'sEcho'=> Input::get('sEcho'),
			'iTotalRecords'=>$count_all,
			'iTotalDisplayRecords'=> $count_display_all,
			'aaData'=>$aadata,
			'qrs'=>$q,
			'sort'=>array($sort_col=>$sort_dir)
		);

		return Response::json($result);
	}

	public function postDel(){
		$id = Input::get('id');

		$controller_name = strtolower($this->controller_name);

		$model = $this->model;

		if(is_null($id)){
			$result = array('status'=>'ERR','data'=>'NOID');
		}else{

			$id = new MongoId($id);

			if($model->delete(array('_id'=>$id))){
				Event::fire($controller_name.'.delete',array('id'=>$id,'result'=>'OK'));
				$result = array('status'=>'OK','data'=>'CONTENTDELETED');
			}else{
				Event::fire($controller_name.'.delete',array('id'=>$id,'result'=>'FAILED'));
				$result = array('status'=>'ERR','data'=>'DELETEFAILED');
			}
		}

		return Response::json($result);
	}

	public function beforeSave($data)
	{
		return $data;
	}

	public function afterSave($data)
	{
		return $data;
	}

	public function makeActions($data){
		return '';
	}

	public function beforeUpdate($id,$data)
	{
		return $data;
	}

	public function afterUpdate($id,$data = null)
	{
		return $id;
	}

	public function beforeView($data)
	{
		return $data;
	}

	public function beforeValidateAdd($data)
	{
		return $data;
	}

	public function beforeUpdateForm($population)
	{
		if(isset($population['tags']) && is_array($population['tags']))
		{
			$population['tags'] = implode(',', $population['tags'] );
		}
		return $population;
	}

	public function get_view($id){
		$_id = new MongoId($id);

		$model = $this->model;

		$obj = $model->get(array('_id'=>$_id));

		$obj = $this->beforeView($obj);

		$this->crumb->add(strtolower($this->controller_name).'/view/'.$id,'View',false);
		$this->crumb->add(strtolower($this->controller_name).'/view/'.$id,$id,false);

		//return View::make(strtolower($this->controller_name).'.'.$this->view_object)
		return View::make('view')
			->with('crumb',$this->crumb)
			->with('obj',$obj);
	}

	public function get_action_sample(){
		\Laravel\CLI\Command::run(array('notify'));
	}


}