<?php

namespace  App\Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;
use App\Modules\Laporan\Models\LaporanProdukModel;
use App\Modules\Laporan\Models\LaporanPenjualanModel;
use App\Modules\Laporan\Models\LaporanKategoriModel;
use TCPDF;
use Spipu\Html2Pdf\Html2Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    protected $setting;
    protected $produk;
    protected $penjualan;
    protected $kategori;

    public function __construct()
    {
        //memanggil Model
        $this->setting = new Settings();
        $this->produk = new LaporanProdukModel();
        $this->penjualan = new LaporanPenjualanModel();
        $this->kategori = new LaporanKategoriModel();
    }


    public function index()
    {
        return view('App\Modules\Laporan\Views/laporan', [
            'title' => 'Laporan'
        ]);
    }

    public function barangPdf()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        $data = [
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->produk->getLaporanByProduk($start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/barang_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $file = FCPATH . 'files/barang.pdf';
        $pdf->Output($file, 'F');
        $attachment = base_url('files/barang.pdf');
        $pdf->Output('barang.pdf', 'I');  // display on the browser
    }

    public function penjualanPdf()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        $data = [
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->penjualan->getLaporanByPenjualan($start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/penjualan_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $file = FCPATH . 'files/penjualan.pdf';
        $pdf->Output($file, 'F');
        $attachment = base_url('files/penjualan.pdf');
        $pdf->Output('penjualan.pdf', 'I');  // display on the browser
    }

    public function kategoriPdf()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        $data = [
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->kategori->getLaporanByKategori($start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/kategori_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $file = FCPATH . 'files/kategori.pdf';
        $pdf->Output($file, 'F');
        $attachment = base_url('files/kategori.pdf');
        $pdf->Output('kategori.pdf', 'I');  // display on the browser
    }
}
