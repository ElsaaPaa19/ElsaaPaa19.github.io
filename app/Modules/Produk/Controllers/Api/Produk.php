<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Media\Models\MediaModel;
use App\Modules\Produk\Models\ProdukModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Produk extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = ProdukModel::class;
    protected $media;

    public function __construct()
    {
        $this->media = new MediaModel();
    }

    public function index()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->getProduk()], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->showProduk($id)], 200);
    }

    public function create()
    {
        $rules = [
            'id_produk' => [
                'rules'  => 'required|is_unique[produks.id_produk]',
                'errors' => []
            ],
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nama_produk' => [
                'rules'  => 'required|min_length[10]|max_length[255]',
                'errors' => []
            ],
            'satuan_produk' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'merk' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'harga_beli' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'harga_jual' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'stok' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $id = $json->id_produk;
            $data = [
                'id_produk' => $id,
                'barcode' => $json->barcode,
                'id_kategori' => $json->id_kategori,
                'nama_produk' => $json->nama_produk,
                'merk' => $json->merk,
                'harga_beli' => $json->harga_beli,
                'harga_jual' => $json->harga_jual,
                'satuan_produk' => $json->satuan_produk,
                'deskripsi' => $json->deskripsi,
                'stok' => $json->stok,
                'active' => $json->active,
            ];
        } else {
            $id = $this->request->getPost('id_produk');
            $data = [
                'id_produk' => $id,
                'barcode' => $this->request->getPost('barcode'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'nama_produk' => $this->request->getPost('nama_produk'),
                'merk' => $this->request->getPost('merk'),
                'harga_beli' => $this->request->getPost('harga_beli'),
                'harga_jual' => $this->request->getPost('harga_jual'),
                'satuan_produk' => $this->request->getPost('satuan_produk'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'stok' => $this->request->getPost('stok'),
                'active' => $this->request->getPost('active'),
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

            /* $hasImage = $this->media->where(['id_produk' => $id])->first();
            $produkId = $hasImage['id_produk'];

            $dataMedia = [
                'active' => 1
            ];

            if ($hasImage) {
                $this->media->update(['id_produk' => $produkId], $dataMedia);
            } */

            $response = [
                'status' => true,
                'message' => lang('App.productSuccess'),
                'data' => ['url' => base_url('produk')],
            ];
            return $this->respond($response, 200);
        }
    }

    public function update($id = NULL)
    {
        $rules = [
            'id_kategori' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nama_produk' => [
                'rules'  => 'required|min_length[10]|max_length[255]',
                'errors' => []
            ],
            'satuan_produk' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'merk' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'harga_beli' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'harga_jual' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'stok' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'barcode' => $json->barcode,
                'id_kategori' => $json->id_kategori,
                'nama_produk' => $json->nama_produk,
                'merk' => $json->merk,
                'harga_beli' => $json->harga_beli,
                'harga_jual' => $json->harga_jual,
                'satuan_produk' => $json->satuan_produk,
                'stok' => $json->stok,
            ];
        } else {
            $data = $this->request->getRawInput();
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.updFailed'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $this->model->update($id, $data);
            $response = [
                'status' => true,
                'message' => lang('App.productUpdated'),
                'data' => ['url' => base_url('produk')],
            ];
            return $this->respond($response, 200);
        }
    }

    public function delete($id = null)
    {
        $hapus = $this->model->find($id);
        if ($hapus) {
            // Delete media
            $qmedia = $this->media->where(['id_produk' => $id])->first();
            if ($qmedia) :
                $idmedia = $qmedia['id_media'];
                $foto = $qmedia['media_path'];
                unlink($foto);
                $this->media->delete($idmedia);
            endif;

            $this->model->delete($id);
            $response = [
                'status' => true,
                'message' => lang('App.productDeleted'),
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

    public function setHarga($id = NULL)
    {
        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'harga_jual' => $json->harga_jual,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'harga_jual' => $input['harga_jual'],
            ];
        }

        if ($data > 0) {
            $this->model->update($id, $data);
            $response = [
                'status' => true,
                'message' => lang('App.productUpdated'),
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.updFailed'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function setStok($id = NULL)
    {
        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $stok = $json->stok;
            $data = [
                'stok' => $stok,
            ];
        } else {
            $input = $this->request->getRawInput();
            $stok = $input['stok'];
            $data = [
                'stok' => $stok,
            ];
        }

        if ($data > 0) {
            if ($stok == '0') {
                $this->model->update($id, ['stok' => $stok, 'active' => 0]);
            } else {
                $this->model->update($id, $data);
            }

            $response = [
                'status' => true,
                'message' => lang('App.updSuccess'),
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.updFailed'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function setAktif($id = NULL)
    {

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $active = $json->active;
            $data = [
                'active' => $active,
            ];
        } else {
            $input = $this->request->getRawInput();
            $active = $input['active'];
            $data = [
                'active' => $active,
            ];
        }

        if ($data > 0) {
            $qStok = $this->model->find($id);
            $cStok = $qStok['stok'];

            if ($cStok == '0') {
                $this->model->update($id, ['active' => $active, 'stok' => 1]);
            } else {
                $this->model->update($id, $data);
            }

            $response = [
                'status' => true,
                'message' => lang('App.productUpdated'),
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.updFailed'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function getProdukTerbaru()
    {
        $input = $this->request->getVar();
        $page = $input['page'];
        $limit = 5;
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->getProdukTerbaru($page, $limit), "per_page" => $limit, "total_page" => $this->model->countAllResults()], 200);
    }

    public function getProdukKasir()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->getProdukKasir()], 200);
    }

    public function cariProduk()
    {
        $input = $this->request->getVar();
        $query = $input['query'];
        $data = $this->model->searchProduk($query);
        if ($data) {
            $response = [
                'status' => true,
                'message' => lang('App.getSuccess'),
                'data' => $data
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.noData'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function getMedia($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->media->where(['id_produk' => $id, 'active' => 1])->first()], 200);
    }

    public function deleteMultiple()
    {
        $input = $this->request->getVar('data');
        $data = json_decode($input, true);

        foreach ($data as $data) {
            $id = $data['id_produk'];
            $qmedia = $this->media->where(['id_produk' => $id])->first();
            $idmedia = $qmedia['id_media'];
            $foto = $qmedia['media_path'];
            if ($foto != null) :
                unlink($foto);
                $this->media->delete($idmedia);
            endif;
            $this->model->delete($id);
        }

        $response = [
            'status' => true,
            'message' => lang('App.delSuccess'),
            'data' => [],
        ];
        return $this->respond($response, 200);
    }

    public function excelExport()
    {
        $input = $this->request->getVar('data');
        $data = json_decode($input, true);

        $spreadsheet = new Spreadsheet();

        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'ID Produk')
            ->setCellValue('C1', 'Barcode')
            ->setCellValue('D1', 'Nama Produk')
            ->setCellValue('E1', 'Merk')
            ->setCellValue('F1', 'Harga Beli')
            ->setCellValue('G1', 'Harga Jual')
            ->setCellValue('H1', 'Satuan')
            ->setCellValue('I1', 'Deskripsi')
            ->setCellValue('J1', 'Stok')
            ->setCellValue('K1', 'Aktif')
            ->setCellValue('L1', 'Tgl Input')
            ->setCellValue('M1', 'Tgl Update');
        $column = 2;
        // tulis data ke cell
        $no = 1;
        foreach ($data as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['id_produk'])
                ->setCellValue('C' . $column, $data['barcode'])
                ->setCellValue('D' . $column, $data['nama_produk'])
                ->setCellValue('E' . $column, $data['merk'])
                ->setCellValue('F' . $column, $data['harga_beli'])
                ->setCellValue('G' . $column, $data['harga_jual'])
                ->setCellValue('H' . $column, $data['satuan_produk'])
                ->setCellValue('I' . $column, $data['deskripsi'])
                ->setCellValue('J' . $column, $data['stok'])
                ->setCellValue('K' . $column, $data['active'])
                ->setCellValue('L' . $column, $data['created_at'])
                ->setCellValue('M' . $column, $data['updated_at']);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'ImportData-' . getdate()[0] . '.xlsx';
        $writer->save('files/export/' . $fileName);
        $fileXlsx = base_url('files/export/' . $fileName);

        $response = [
            'status' => true,
            'message' => lang('App.getSuccess'),
            'data' => ['filename' => $fileName, 'url' => $fileXlsx],
        ];
        return $this->respond($response, 200);
    }
}
