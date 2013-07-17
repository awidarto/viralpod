<?php

class UploadController extends Controller {

	public function __construct()
	{

	}

	public function postIndex()
	{
		$files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $destinationPath = 'public/storage/temp/'.str_random(8);
        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $uploadSuccess = $file->move($destinationPath, $filename);

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('public/storage/temp/'.$filename),
                    'thumbnail_url'=> 'http://url.to/thumnail.jpg',
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> 'http://url.to/delete /file/',
                    'delete_type'=> 'DELETE'
                );

        }



        return Response::JSON(array('files'=>$fileitems) );
	}

    public function postAdd()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $destinationPath = 'public/storage/temp/'.str_random(8);
        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $uploadSuccess = $file->move($destinationPath, $filename);

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('public/storage/temp/'.$filename),
                    'thumbnail_url'=> 'http://url.to/thumnail.jpg',
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> 'http://url.to/delete /file/',
                    'delete_type'=> 'DELETE'
                );

        }

        return Response::JSON(array('files'=>$fileitems) );
    }

    public function postEdit()
    {
        $files = Input::file('files');

        $file = $files[0];

        //print_r($file);

        //exit();

        $rstring = str_random(8);

        $destinationPath = 'public/storage/temp/'.$rstring;
        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $extension =$file->getClientOriginalExtension(); //if you need extension of the file

        $uploadSuccess = $file->move($destinationPath, $filename);

        $thubnail = Image::make($destinationPath.'/'.$filename)
            ->resize(150,75)
            ->save($destinationPath.'/th_'.$filename);

        $fileitems = array();

        if($uploadSuccess){
            $fileitems[] = array(
                    'url'=> URL::to('public/storage/temp/'.$rstring.'/'.$filename),
                    'thumbnail_url'=> URL::to('public/storage/temp/'.$rstring.'/th_'.$filename),
                    'name'=> $filename,
                    'type'=> $filemime,
                    'size'=> $filesize,
                    'delete_url'=> 'http://url.to/delete /file/',
                    'delete_type'=> 'DELETE'
                );

        }

        return Response::JSON(array('files'=>$fileitems) );
    }

    public function postDelete($file)
    {

    }

    public function postUp(){

        $file = Input::file('file');

        $destinationPath = Config::get('kickstart.storage').'/uploads/'.str_random(8);
        $filename = $file->getClientOriginalName();
        //$extension =$file->getClientOriginalExtension();
        $upload_success = Input::file('file')->move($destinationPath, $filename);

        if( $upload_success ) {
           return Response::json('success', 200);
        } else {
           return Response::json('error', 400);
        }

    }


}
