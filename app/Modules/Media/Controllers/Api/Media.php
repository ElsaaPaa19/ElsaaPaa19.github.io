<?php 
namespace App\Modules\Media\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Media\Models\MediaModel;

class Media extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = MediaModel::class;

	public function create()
    {
        $gambar = $this->request->getFile('image');
        $id_produk = $this->request->getPost('id_produk');
        $fileName = $gambar->getRandomName();
        if ($gambar !== "") {
            $path = "images/";
            $moved = $gambar->move($path, $fileName);
            if ($moved) {
                $simpan = $this->model->save([
                    'media_path' => $path . $fileName,
                    'id_produk' => $id_produk,
                    'active' => 1
                ]);
                if ($simpan) {
                    return $this->respond(["status" => true, "message" => lang('App.imgSuccess'), "data" => $this->model->getInsertID()], 200);
                } else {
                    return $this->respond(["status" => false, "message" => lang('App.imgFailed'), "data" => []], 200);
                }
            }
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.uploadFailed'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function delete($id = null)
    {
        $hapus = $this->model->find($id);
        if ($hapus) {
            $this->model->delete($id);
            unlink($hapus['media_path']);
            
            $response = [
                'status' => true,
                'message' => lang('App.imgDeleted'),
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