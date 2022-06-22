<?php

namespace  App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Modules\Dashboard\Models\DashboardModel;

class Dashboard extends BaseController
{
    protected $dashboard;

    public function __construct()
    {
        //memanggil Model
        $this->dashboard = new DashboardModel();
    }


    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['countTrxHariini'] = $this->dashboard->countTrxHariini();
        $data['countTrxHarikemarin'] = $this->dashboard->countTrxHarikemarin();
        $data['totalTrxHariini'] = $this->dashboard->totalTrxHariini();
        $data['totalTrxHarikemarin'] = $this->dashboard->totalTrxHarikemarin();
        $data['jmlProduk'] = $this->dashboard->getCountProduct();
        $data['jmlUser'] = $this->dashboard->getCountUser();

        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['transaksi'] = [];
        foreach ($bln as $b) {
            $date = date('Y-') . $b;
            $data['transaksi'][] = $this->dashboard->chartTransaksi($date);
        }

        $jam = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '00'];
        $data['jam'] = [];
        foreach ($jam as $j) {
            $date = date('Y-m-d') . ' ' . $j;
            $data['harian'][] = $this->dashboard->chartHarian($date);
        }

        $tgl = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $data['tgl'] = [];
        foreach ($tgl as $t) {
            $date = date('Y-m-') . $t;
            $data['pemasukan'][] = $this->dashboard->chartPemasukan($date);
        }

        return view('App\Modules\Dashboard\Views/index', $data);
    }
}
