<?php

namespace App\Modules\Dashboard\Models;


use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table                = 'notas';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // hitung total data pada transaction
    public function getCountTrx()
    {
        return $this->db->table("notas")->countAll();
    }

    // hitung total data pada category
    public function getCountCategory()
    {
        return $this->db->table("detail_transaksi")->countAll();
    }

    // hitung total data pada product
    public function getCountProduct()
    {
        return $this->db->table("produks")->countAll();
    }

    // hitung total data pada user
    public function getCountUser()
    {
        return $this->db->table("logins")->countAll();
    }

    public function chartTransaksi($date)
    {
        $this->like('created_at', $date, 'after');
        return count($this->get()->getResultArray());
    }

    public function chartHarian($date)
    {
        $this->like('created_at', $date, 'after');
        return count($this->get()->getResultArray());
    }

    public function chartPemasukan($date)
    {
        $this->select('sum(total) as total');
        $this->like('created_at', $date, 'after');
        return $this->get()->getRow()->total;
    }

    public function countTrxHariini()
    {
        $this->where('DATE(created_at) =', date('Y-m-d'));
        return count($this->get()->getResultArray());
    }

    public function countTrxHarikemarin()
    {
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime('-1 days')));
        return count($this->get()->getResultArray());
    }

    public function totalTrxHariini()
    {
        $this->select('sum(total) as total');
        $this->where('DATE(created_at) =', date('Y-m-d'));
        return $this->get()->getRow()->total;
    }

    public function totalTrxHarikemarin()
    {
        $this->select('sum(total) as total');
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime('-1 days')));
        return $this->get()->getRow()->total;
    }
}
