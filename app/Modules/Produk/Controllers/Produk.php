<?php

namespace App\Modules\Produk\Controllers;

use App\Controllers\BaseController;
use App\Modules\Produk\Models\ProdukModel;
use App\Modules\Nota\Models\NotaModel;
use Hashids\Hashids;

class Produk extends BaseController
{
    protected $produk;
    protected $nota;

    public function __construct()
    {
        //memeriksa session role selain Admin redirect ke /
        /*if (session()->get('logged_in') == true && session()->get('role') == 2) {
            header('location:/');
            exit();
        }*/

        //memanggil Model
        $this->produk = new ProdukModel();
        $this->nota = new NotaModel();
        $this->hashids = new Hashids();
        //$this->userModel = new UserModel();
    }


    public function index()
    {
        return view('App\Modules\Produk\Views/produk', [
            'title' => lang('Produk Angkringan'),
        ]);
    }

    function _generateId()
    {
        helper('text');
        $unique = random_string('nozero', 1) . random_string('alpha', 1) . random_string('numeric', 2) . random_string('alpha', 3);
        //$unique = crc32(uniqid(time()));
        $cek_unique = $this->produk->where(['id_produk' => $unique])->first();
        if ($cek_unique) {
            $unique + 1;
        } else {
            $unique;
        }

        return $unique;
    }

    public function produkBaru()
    {
        $id_produk = strtolower($this->_generateId());

        return view('App\Modules\Produk\Views/produk_baru', [
            'title' => lang('App.add'),
            'id_produk' => $id_produk,
        ]);
    }

    public function produkEdit($id = null)
    {
        $data = $this->produk->find($id);

        return view('App\Modules\Produk\Views/produk_edit', [
            'title' => lang('App.edit'),
            'data' => $data,
        ]);
    }
}
