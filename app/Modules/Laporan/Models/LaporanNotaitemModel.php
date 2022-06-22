<?php

namespace App\Modules\Laporan\Models;

use CodeIgniter\Model;

class LaporanNotaitemModel extends Model
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

    public function detailLaporanByKategori($start, $end, $id)
    {
        $this->select("n.no_nota, {$this->table}.qty, {$this->table}.jumlah, {$this->table}.satuan, p.id_produk, p.nama_produk, {$this->table}.created_at");
        $this->join("produks p", "p.id_produk = {$this->table}.id_produk");
        $this->join("notas n", "n.id_nota = {$this->table}.id_nota");
        $this->where("DATE({$this->table}.created_at) BETWEEN '$start' AND '$end'", '',false);
        $this->where("p.id_kategori", $id);
        $this->orderBy("{$this->table}.id_itemnota", 'DESC');
        $query = $this->findAll();
        return $query;
    }

}
