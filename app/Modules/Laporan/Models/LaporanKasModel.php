<?php

namespace App\Modules\Laporan\Models;

use CodeIgniter\Model;

class LaporanKasModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'kas_saldos';
    protected $primaryKey           = 'id_kas';
    protected $useAutoIncrement     = false;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = false;
    protected $allowedFields        = [];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function sumPenjualan($start, $end)
    {
        $this->select('sum(nominal) as total');
        $this->groupStart();
        $this->like('jenis', 'Pemasukan');
        $this->like('keterangan', 'Penjualan');
        $this->groupEnd();
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", '',false);
        return $this->get()->getRow()->total;
    }

    public function sumPemasukanLain($start, $end)
    {
        $this->select('sum(nominal) as total');
        $this->groupStart();
        $this->like('jenis', 'Pemasukan');
        $this->notLike('keterangan', 'Penjualan');
        $this->groupEnd();
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", '',false);
        return $this->get()->getRow()->total;
    }

    public function sumHPP($start, $end)
    {
        $this->select('sum(hpp) as total');
        $this->groupStart();
        $this->like('jenis', 'Pemasukan');
        $this->like('keterangan', 'Penjualan');
        $this->groupEnd();
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", '',false);
        return $this->get()->getRow()->total;
    }

    public function sumPengeluaran($start, $end)
    {
        $this->select('sum(nominal) as total');
        $this->like('jenis', 'Pengeluaran');
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", '',false);
        return $this->get()->getRow()->total;
    }

    public function sumMutasiBank($start, $end)
    {
        $this->select('sum(nominal) as total');
        $this->like('jenis', 'Mutasi ke Bank');
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", '',false);
        return $this->get()->getRow()->total;
    }
}
