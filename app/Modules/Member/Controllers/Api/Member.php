<?php

namespace App\Modules\Member\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Member\Models\MemberModel;

class Member extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = MemberModel::class;

    public function index()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->findAll()], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->find($id)], 200);
    }

    public function create()
    {
        $rules = [
            'nama_member' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        $query = $this->model->selectMax('id_member', 'last');
        $hasil = $query->get()->getRowArray();
        $last = $hasil['last'] + 1;
        $noMember = 'M' . sprintf('%04s', $last);

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'no_member' => $noMember,
                'nama_member' => $json->nama_member,
                'alamat_member' => $json->alamat_member,
                'telepon' => $json->telepon,
                'email' => $json->email,
                'NIK' => $json->nik,
            ];
        } else {
            $data = [
                'no_member' => $noMember,
                'nama_member' => $this->request->getPost('nama_member'),
                'alamat_member' => $this->request->getPost('alamat_member'),
                'telepon' => $this->request->getPost('telepon'),
                'email' => $this->request->getPost('email'),
                'NIK' => $this->request->getPost('nik'),
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
            'nama_member' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nama_member' => $json->nama_member,
                'alamat_member' => $json->alamat_member,
                'telepon' => $json->telepon,
                'email' => $json->email,
                'NIK' => $json->nik,
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
}
