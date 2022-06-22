<?php

namespace App\Modules\Laporan\Models;

use CodeIgniter\Model;

class LaporanKategoriModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'kategoris';
    protected $primaryKey           = 'id_kategori';
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

    public function getLaporanByKategori($start, $end)
    {
        $this->select("{$this->table}.id_kategori, {$this->table}.nama_kategori, sum(n.qty) as jumlah, sum(n.jumlah) as total");
        $this->join("produks p", "p.id_kategori = {$this->table}.id_kategori");
        $this->join("nota_items n", "n.id_produk = p.id_produk");
        $this->where("DATE(n.created_at) BETWEEN '$start' AND '$end'", '',false);
        $this->groupBy("{$this->table}.id_kategori");
        $this->orderBy("{$this->table}.id_kategori", 'DESC');
        $query = $this->findAll();
        return $query;
    }
}
