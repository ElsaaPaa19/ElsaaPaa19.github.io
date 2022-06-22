<?php

namespace App\Modules\Penjualan\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Penjualan\Models\KeranjangModel;
use App\Modules\Produk\Models\ProdukModel;

class Keranjang extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = KeranjangModel::class;
    protected $produk;

    public function __construct()
    {
        $this->produk = new ProdukModel();
    }

    public function index()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->getKeranjang()], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->find($id)], 200);
    }

    public function create()
    {
        $rules = [
            'id_produk' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();

            $id_produk = $json->id_produk;
            $qty = $json->qty;

            $data = $this->produk->where(['id_produk' => $id_produk])->first();
            $beli = $data['harga_beli'];
            $jual = $data['harga_jual'];
            $satuan = $data['satuan_produk'];
            $hpp = $beli * $qty;
            $total = $jual * $qty;
            $data = [
                'id_produk' => $id_produk,
                'id_member' => $json->id_member,
                'harga_beli' => $beli,
                'harga_jual' => $json->harga_jual,
                'stok' => $json->stok,
                'qty' => $qty,
                'satuan' => $satuan,
                'hpp' => $hpp,
                'total' => $total,
            ];
        } else {
            $id_produk = $this->request->getPost('id_produk');
            $qty = $this->request->getPost('qty');

            $data = $this->produk->where(['id_produk' => $id_produk])->first();
            $beli = $data['harga_beli'];
            $jual = $data['harga_jual'];
            $satuan = $data['satuan_produk'];
            $hpp = $beli * $qty;
            $total = $jual * $qty;
            $data = [
                'id_produk' => $id_produk,
                'id_member' => $this->request->getPost('id_member'),
                'harga_beli' => $beli,
                'harga_jual' => $this->request->getPost('harga_jual'),
                'stok' => $this->request->getPost('stok'),
                'qty' => $qty,
                'satuan' => $satuan,
                'hpp' => $hpp,
                'total' => $total,
            ];
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.isRequired'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $simpan = $this->model->save($data);
            if ($simpan) {
                $response = [
                    'status' => true,
                    'message' => lang('App.productSuccess'),
                    'data' => [],
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function update($id = NULL)
    {
        $input = $this->getRequestInput();
        $id_produk = $input['id_produk'];
        $qty = $input['qty'];

        $produk = $this->produk->where(['id_produk' => $id_produk])->first();

        if ($produk['stok'] >= $qty) {
            $beli = $produk['harga_beli'];
            $jual = $produk['harga_jual'];
            $hpp = $beli * $qty;
            $total = $jual * $qty;
            $data = [
                'qty' => $qty,
                'hpp' => $hpp,
                'total' => $total,
            ];
            $this->model->update($id, $data);
            /* var_dump($this->model->getLastQuery()->getQuery());
            die; */
            $response = [
                'status' => true,
                'message' => lang('App.updSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.stockLess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function delete($id = null)
    {
        $hapus = $this->model->find($id);
        if ($hapus) {
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

    public function truncate()
    {
        if ($this->model->truncate()) {
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
}
