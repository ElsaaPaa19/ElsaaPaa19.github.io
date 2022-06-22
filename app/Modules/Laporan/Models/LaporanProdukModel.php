<?php

namespace App\Modules\Laporan\Models;

use CodeIgniter\Model;

class LaporanProdukModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'nota_items';
    protected $primaryKey           = 'id_itemnota';
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

    public function getLaporanByProduk($start, $end)
    {
        $this->select("{$this->table}.*, p.nama_produk, m.media_path, k.nama_kategori");
        $this->join("produks p", "p.id_produk = {$this->table}.id_produk");
        $this->join("medias m", "m.id_produk = {$this->table}.id_produk", "left");
        $this->join("kategoris k", "k.id_kategori = p.id_kategori");
        $this->where("DATE({$this->table}.created_at) BETWEEN '$start' AND '$end'", '',false);
        $this->orderBy("{$this->table}.id_itemnota", 'DESC');
        $query = $this->findAll();
        return $query;
    }

}
