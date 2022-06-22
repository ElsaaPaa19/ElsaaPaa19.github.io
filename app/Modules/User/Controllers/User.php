<?php

namespace  App\Modules\User\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class User extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}


	public function index()
	{
		return view('App\Modules\User\Views/user', [
			'title' => 'User'
		]);
	}
}
