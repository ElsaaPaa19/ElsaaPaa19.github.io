<?php

namespace  App\Modules\Penjualan\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;
use App\Modules\Toko\Models\TokoModel;

class Penjualan extends BaseController
{
	protected $setting;
	protected $toko;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		$this->toko = new TokoModel();
	}


	public function index()
	{
		$toko = $this->toko->first();

		return view('App\Modules\Penjualan\Views/kasir', [
			'title' => 'Kasir',

		]);
	}
}
