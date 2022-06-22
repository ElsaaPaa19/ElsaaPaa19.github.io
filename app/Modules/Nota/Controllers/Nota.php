<?php

namespace  App\Modules\Nota\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;
use App\Modules\Dashboard\Models\DashboardModel;
use App\Modules\Toko\Models\TokoModel;

class Nota extends BaseController
{
	protected $setting;
	protected $dashboard;
	protected $toko;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		$this->dashboard = new DashboardModel();
		$this->toko = new TokoModel();
	}


	public function index()
	{
		$countTrxHariini = $this->dashboard->countTrxHariini();
		$countTrxHarikemarin = $this->dashboard->countTrxHarikemarin();
		$totalTrxHariini = $this->dashboard->totalTrxHariini();
		$totalTrxHarikemarin = $this->dashboard->totalTrxHarikemarin();
		$toko = $this->toko->first();

		return view('App\Modules\Nota\Views/nota', [
			'title' => "Detail Transaksi",
			'countTrxHariini' => $countTrxHariini,
			'countTrxHarikemarin' => $countTrxHarikemarin,
			'totalTrxHariini' => $totalTrxHariini,
			'totalTrxHarikemarin' => $totalTrxHarikemarin,

		]);
	}
}
