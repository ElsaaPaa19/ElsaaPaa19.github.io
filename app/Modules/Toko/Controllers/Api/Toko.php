<?php

namespace App\Modules\Toko\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Toko\Models\TokoModel;

class Toko extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = TokoModel::class;

    public function index()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->first()], 200);
    }

    public function update($id = NULL)
    {
        //$id = '1';
        $rules = [
            'nama_toko' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'alamat_toko' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'telp' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nama_pemilik' => [
                'rules'  => 'required',
                'errors' => []
            ],

        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nama_toko' => $json->nama_toko,
                'alamat_toko' => $json->alamat_toko,
                'telp' => $json->telp,
                'email' => $json->email,
                'nama_pemilik' => $json->nama_pemilik,

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
}
