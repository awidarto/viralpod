<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller('products', 'ProductsController');
Route::controller('members', 'MembersController');
Route::controller('administrators', 'AdministratorsController');
Route::controller('companies', 'CompaniesController');
Route::controller('projects', 'ProjectsController');
Route::controller('events', 'EventsController');

Route::get('/', function()
{
    if(Auth::guest()){
        return Redirect::to('login');
    }else{
        return Redirect::to('dashboard');
    }
});

Route::get('hashme/{mypass}',function($mypass){

    print Hash::make($mypass);
});

Route::get('dashboard',function(){

    return View::make('pages.dashboard');

});

Route::get('login',function(){

	return View::make('auth.login');

});

Route::post('login',function(){

	$username = Input::get('username');
    $password = Input::get('password');

	$credentials = array('username'=>$username, 'password'=>$password);

    if ( $userdata = Auth::attempt($credentials) )
    {
        //print_r($userdata);
        // we are now logged in, go to home
        return Redirect::to('/');

    }
    else
    {
        // auth failure! lets go back to the login
        return Redirect::to('login')
            ->with('login_errors', true);
        // pass any error notification you want
        // i like to do it this way  
    }

});

Route::get('logout',function(){
    Auth::logout();
    return Redirect::to('/');
});

Route::get('signup',function(){

	Former::framework('TwitterBootstrap');

	return View::make('auth.signup');

});

Route::get('catalog',function(){

	Former::framework('TwitterBootstrap');

	return View::make('pages.catalog');

});

Route::get('testmongo',function(){

	$LMongo = LMongo::connection();

	$mongodb = $LMongo->getMongoDB();

	$collection_names = $mongodb->getCollectionNames();

	//var_dump($collection_names);

	//$users = LMongo::collection('users')->get();

	$user = new Admin();

	$users = $user->get();

	foreach ($users as $u)
	{
	    var_dump($u['fullname']);
	}


});




/* Filters */

Route::filter('auth', function()
{

    if (Auth::guest()){
        Session::put('redirect',URL::full());
        return Redirect::to('login');
    }
    
    if($redirect = Session::get('redirect')){
        Session::forget('redirect');
        return Redirect::to($redirect);
    }

    //if (Auth::guest()) return Redirect::to('login');
});
