<?php

namespace App\Modules\Laporan\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Laporan\Models\LaporanProdukModel;
use App\Modules\Laporan\Models\LaporanPenjualanModel;
use App\Modules\Laporan\Models\LaporanKategoriModel;
use App\Modules\Laporan\Models\LaporanNotaitemModel;
use App\Modules\Laporan\Models\LaporanKasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseControllerApi
{
    protected $format       = 'json';
    protected $produk;
    protected $penjualan;
    protected $kategori;
    protected $notaitem;
    protected $kas;

    public function __construct()
    {
       $this->produk = new LaporanProdukModel();
       $this->penjualan = new LaporanPenjualanModel();
       $this->kategori = new LaporanKategoriModel();
       $this->notaitem = new LaporanNotaitemModel();
       $this->kas = new LaporanKasModel();
    }

    public function produk()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->produk->getLaporanByProduk($start, $end)], 200);
    }

    public function penjualan()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->penjualan->getLaporanByPenjualan($start, $end)], 200);
    }

    public function kategori()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->kategori->getLaporanByKategori($start, $end)], 200);
    }

    public function detailKategori()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        $id = $input['id_kategori'];
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->notaitem->detailLaporanByKategori($start, $end, $id)], 200);
    }

    public function LabaRugi()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];

        $data['sumPenjualan'] = $this->kas->sumPenjualan($start, $end);
        $data['sumPemasukanLain'] = $this->kas->sumPemasukanLain($start, $end);
        $totalPendapatan = $data['sumPenjualan'] + $data['sumPemasukanLain'];
        $data['sumHPP'] = $this->kas->sumHPP($start, $end);
        $labaKotor = $totalPendapatan - $data['sumHPP'];
        $data['sumPengeluaran'] = $this->kas->sumPengeluaran($start, $end);
        $data['sumPengeluaranLain'] = $this->kas->sumMutasiBank($start, $end);
        $totalPengeluaran = $data['sumPengeluaran'] +  $data['sumPengeluaranLain'];
        $labaBersih = $labaKotor - $totalPengeluaran;
        foreach ($data as $key => $value) {
            $arrayData = [
                'pemasukan_penjualan' => $data['sumPenjualan'],   
                'pemasukan_lain' => $data['sumPemasukanLain'],
                'total_pendapatan' => $totalPendapatan,
                'beban_pokok_pendapatan' => $data['sumHPP'],
                'laba_kotor' => $labaKotor,
                'pengeluaran' => $data['sumPengeluaran'],
                'pengeluaran_lain' => $data['sumPengeluaranLain'],
                'total_pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
            ];
        }

        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $arrayData], 200);
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
