<?php

namespace App\Modules\Kas\Controllers;

use App\Controllers\BaseController;
use App\Modules\Kas\Models\KasModel;

class Kas extends BaseController
{
    protected $kas;

    public function __construct()
    {
        //memanggil function di model
        $this->kas = new KasModel();
    }

    public function index()
    {

        $queryKas = $this->kas->selectMax('saldo', 'last');
        $hasil = $queryKas->get()->getRowArray();
        $saldo = $hasil['last'];

        return view('App\Modules\Kas\Views/kas', [
            'title' => 'Kas',
            'saldo' => $saldo,
        ]);
    }
}
