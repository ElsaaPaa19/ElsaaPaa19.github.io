<?php

namespace  App\Modules\Excel\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;
use App\Modules\Produk\Models\ProdukModel;

class Import extends BaseController
{
    protected $setting;
    protected $produk;

    public function __construct()
    {
        //memanggil Model
        $this->setting = new Settings();
        $this->produk = new ProdukModel();
    }


    public function import()
    {
        return view('App\Modules\Excel\Views/import', [
            'title' => 'Import Excel - Data Produk'
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

    public function saveExcel()
    {
        $file_excel = $this->request->getFile('fileexcel');
        $ext = $file_excel->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }
            $barcode = $row[0];
            $namaProduk = $row[1];
            $merk = $row[2];
            $hargaBeli = $row[3];
            $hargaJual = $row[4];
            $satuan = $row[5];
            $deskripsi = $row[6];
            $stok = $row[7];

            $cekKode = $this->produk->getWhere(['nama_produk' => $namaProduk])->getResult();

            if (count($cekKode) > 0) {
                session()->setFlashdata('error', 'Import data gagal karena Nama Produk sudah ada');
            } else {
                $simpandata = [
                    'id_produk' => $this->_generateId(),
                    'barcode' => $barcode,
                    'nama_produk' => $namaProduk,
                    'merk' => $merk,
                    'harga_beli' => $hargaBeli,
                    'harga_jual' => $hargaJual,
                    'satuan_produk' => $satuan,
                    'deskripsi' => $deskripsi,
                    'stok' => $stok,
                    'active' => 1,
                    'id_kategori' => 1
                ];

                $this->produk->save($simpandata);
                session()->setFlashdata('success', 'Proses Import data Excel Berhasil');
            }
        }

        return redirect()->to('/excel/import');
    }
}
