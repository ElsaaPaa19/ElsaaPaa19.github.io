<?php

namespace App\Modules\Kas\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Kas\Models\KasModel;

class Kas extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = KasModel::class;

    public function index()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->getKas()], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->showKas($id)], 200);
    }

    public function saldo()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->select("saldo")->orderBy("id_kas", "DESC")->limit(1)->get()->getRowArray()], 200);
    }

    public function create()
    {
        $rules = [
            'jenis' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nominal' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        $query = $this->model->selectMax('id_kas', 'last');
        $hasil = $query->get()->getRowArray();
        $last = $hasil['last'] + 1;
        $noKode = 'KS-' . sprintf('%06s', $last);

        $queryKas = $this->model->select('saldo')->orderBy('id_kas', 'DESC')->limit(1);
        $hasil = $queryKas->get()->getRowArray();
        $saldo = $hasil['saldo'];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $nominal = $json->nominal;
            if ($json->jenis == "Pemasukan") {
                $hitungSaldo = $saldo + $nominal;
            } else {
                $hitungSaldo = $saldo - $nominal;
            }
            $data = [
                'kode' => $noKode,
                'jenis' => $json->jenis,
                'nominal' => $json->nominal,
                'keterangan' => $json->keterangan,
                'hpp' => 0,
                'saldo' => $hitungSaldo,
                'id_login' => session()->get('id'),
            ];
        } else {
            $nominal = $this->request->getPost('nominal');
            if ($this->request->getPost('jenis') == "Pemasukan") {
                $hitungSaldo = $saldo + $nominal;
            } else {
                $hitungSaldo = $saldo - $nominal;
            }
            $data = [
                'kode' => $noKode,
                'jenis' => $this->request->getPost('jenis'),
                'nominal' => $this->request->getPost('nominal'),
                'keterangan' => $this->request->getPost('keterangan'),
                'hpp' => 0,
                'saldo' => $hitungSaldo,
                'id_login' => session()->get('id'),
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
            $this->model->save($data);
            $response = [
                'status' => true,
                'message' => lang('App.saveSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function update($id = NULL)
    {
        $rules = [
            'keterangan' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'keterangan' => $json->keterangan,
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
            $this->model->update($id, $data);
            $response = [
                'status' => true,
                'message' => lang('App.updSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function delete($id = null)
    {
        $delete = $this->model->find($id);
        $kode = $delete['kode'];
        $nominal = $delete['nominal'];
        $jenis = $delete['jenis'];

        $query = $this->model->selectMax('id_kas', 'last');
        $hasil = $query->get()->getRowArray();
        $last = $hasil['last'] + 1;
        $noKode = 'KS-' . sprintf('%06s', $last);

        $queryKas = $this->model->select('saldo')->orderBy('id_kas', 'DESC')->limit(1);
        $hasil = $queryKas->get()->getRowArray();
        $saldo = $hasil['saldo'];

        if ($delete) {
            if ($jenis == "Pemasukan") {
                $hitungSaldo = $saldo - $nominal;
            } else {
                $hitungSaldo = $saldo + $nominal;
            }

            $data = [
                'kode' => $noKode,
                'jenis' => 'Refersal',
                'nominal' => '-' . $nominal,
                'keterangan' => $kode,
                'hpp' => 0,
                'saldo' => $hitungSaldo,
                'id_login' => session()->get('id'),
            ];

            $this->model->save($data);

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
}
