<?php

namespace App\Modules\Penjualan\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'keranjangs';
    protected $primaryKey           = 'id_keranjang';
    protected $useAutoIncrement     = true;
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

    public function getKeranjang()
    {
        $this->select("{$this->table}.*, b.nama_produk, b.harga_jual");
        $this->join("produks b", "b.id_produk = {$this->table}.id_produk");
        $this->orderBy("{$this->table}.id_keranjang", "ASC");
        $query = $this->findAll();
        return $query;
    }
}
