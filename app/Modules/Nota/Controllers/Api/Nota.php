<?php

namespace App\Modules\Nota\Controllers\Api;

use Exception;
use App\Controllers\BaseControllerApi;
use App\Libraries\Settings;
use App\Modules\Nota\Models\NotaModel;
use App\Modules\Produk\Models\ProdukModel;
use App\Modules\Nota\Models\NotaItemModel;
use App\Modules\Toko\Models\TokoModel;
use App\Modules\Kas\Models\KasModel;

class Nota extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = NotaModel::class;
    protected $setting;
    protected $produk;
    protected $itemNota;
    protected $toko;
    protected $kas;

    public function __construct()
    {
        $this->setting = new Settings();
        $this->produk = new ProdukModel();
        $this->itemNota = new NotaItemModel();
        $this->toko = new TokoModel();
        $this->kas = new KasModel();
    }

    public function index()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->orderBy('created_at', 'desc')->findAll()], 200);
    }

    public function show($id = null)
    {
        return $this->respond(["status" => true, "message" => lang("App.getSuccess"), "data" => $this->model->find($id)], 200);
    }

    public function create()
    {
        $rules = [
            'bayar' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $hpp = $json->hpp;
            $total = $json->total;
            $bayar = $json->bayar;
            $kembali = $json->kembali;
            $idmember = $json->id_member;
        } else {
            $hpp = $this->request->getPost('hpp');
            $total = $this->request->getPost('total');
            $bayar = $this->request->getPost('bayar');
            $kembali = $this->request->getPost('kembali');
            $idmember = $this->request->getPost('id_member');
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.isRequired'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            if (!$bayar == 0) {
                $hitung = $bayar - $total;
                if ($bayar >= $total) {
                    $input = $this->request->getVar('data');

                    foreach ($input as $value) {
                        $id_produk[] = $value[0];
                        $harga_jual[] = $value[1];
                        $stok[] = $value[2];
                        $jumlah[] = $value[3];
                        $satuan[] = $value[4];
                        $harga_beli[] = $value[5];
                    }

                    $total_produk = count($id_produk);

                    $query = $this->model->selectMax('id_nota', 'last');
                    $hasil = $query->get()->getRowArray();
                    $last = $hasil['last'] + 1;
                    /* if ($last == 0) {
                        $last = $last+1;
                    } else {
                        $last;
                    } */
                    $noNota = sprintf('%06s', $last);

                    $dataNota = [
                        'no_nota' => date('Ymd') . $noNota,
                        'id_member' => $idmember,
                        'jumlah' => $total_produk,
                        'hpp' => $hpp,
                        'total' => $total,
                        'bayar' => $bayar,
                        'kembali' => $kembali,
                        'periode' => date('m-Y'),
                        'id_login' => session()->get('id'),
                        'id_toko' => 1
                    ];
                    $this->model->save($dataNota);
                    $idnota = $this->model->getInsertID();

                    $arrNota = array();
                    foreach ($input as $key => $value) {
                        $id_produk = $value[0];
                        $harga_jual = $value[1];
                        $stok = $value[2];
                        $qty = $value[3];
                        $satuan = $value[4];
                        $harga_beli = $value[5];

                        $item = array(
                            'id_produk' => $id_produk,
                            'id_nota' => $idnota,
                            'harga_beli' => $harga_beli,
                            'harga_jual' => $harga_jual,
                            'qty' => $qty,
                            'satuan' => $satuan,
                            'jumlah' => $harga_jual * $qty,
                        );
                        array_push($arrNota, $item);
                    }
                    $dataItem = $arrNota;
                    $this->itemNota->insertBatch($dataItem);

                    $arrStok = array();
                    foreach ($input as $key => $value) {
                        $id_produk = $value[0];
                        $harga_jual = $value[1];
                        $stok = $value[2];
                        $qty = $value[3];
                        $satuan = $value[4];
                        $harga_beli = $value[5];

                        $stock = array(
                            'id_produk' => $id_produk,
                            'stok' => $stok - $qty,
                        );

                        array_push($arrStok, $stock);
                    }
                    $dataStok = $arrStok;
                    $this->produk->updateBatch($dataStok, 'id_produk');

                    $queryKas = $this->kas->selectMax('id_kas', 'last');
                    $hasil = $queryKas->get()->getRowArray();
                    $last = $hasil['last'] + 1;
                    /* if ($last == 0) {
                        $last = $last+1;
                    } else {
                        $last;
                    } */
                    $kodeKas = 'KS-' . sprintf('%06s', $last);

                    $queryKas = $this->kas->select('saldo')->orderBy('id_kas', 'DESC')->limit(1);
                    $hasil = $queryKas->get()->getRowArray();
                    $saldo = $hasil['saldo'];

                    $dataKas = [
                        'kode' =>  $kodeKas,
                        'jenis' => 'Pemasukan',
                        'nominal' => $total,
                        'hpp' => $hpp,
                        'keterangan' => 'Penjualan',
                        'saldo' => $total + $saldo,
                        'id_login' => session()->get('id')
                    ];
                    $this->kas->save($dataKas);

                    $response = [
                        'status' => true,
                        'message' => lang('App.saveSuccess'),
                        'data' => ['idnota' => $idnota],
                    ];
                    return $this->respond($response, 200);
                } else {
                    $response = [
                        'status' => false,
                        'message' => lang('App.uangKurang') . $hitung,
                        'data' => [],
                    ];
                    return $this->respond($response, 200);
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => lang('App.harusBayar'),
                    'data' => [],
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function update($id = NULL)
    {
        $rules = [
            'id_produk' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_produk' => $json->id_produk,
                'id_member' => $json->id_member,
                'jumlah' => $json->jumlah,
                'total' => $json->total,
                'periode' => $json->periode,
            ];
        } else {
            $data = $this->request->getRawInput();
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.isRequired'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $simpan = $this->model->update($id, $data);
            if ($simpan) {
                $response = [
                    'status' => true,
                    'message' => lang('App.updSuccess'),
                    'data' => [],
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function delete($id = null)
    {
        $delete = $this->model->find($id);
        if ($delete) {
            $this->model->delete($id);
            $response = [
                'status' => true,
                'message' => lang('App.delSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.delFailed'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function cetakNota($id = null)
    {
        return $this->respond(["status" => true, "message" => lang("App.getSuccess"), "data" => $this->itemNota->findNota($id)], 200);
    }

    public function cetakUSB()
    {
        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $id = $json->id_nota;
        } else {
            $id = $this->request->getPost('id_nota');
        }

        $toko = $this->toko->first();
        $nota = $this->model->find($id);
        $item = $this->itemNota->findNotaCetak($id);

        $tanggal = date('Y-m-d H:i:s');
        $user = session()->get('nama');
        $appname = $this->setting->info['app_name'];

        // Data Toko
        $namaToko = $toko['nama_toko'];
        $alamatToko = $toko['alamat_toko'];
        $telpToko = $toko['telp'];
        $nibToko = $toko['NIB'];

        // Data Nota
        $noNota = $nota['no_nota'];
        $total = $nota['total'];
        $bayar = $nota['bayar'];
        $kembali = $nota['kembali'];
    }
}
