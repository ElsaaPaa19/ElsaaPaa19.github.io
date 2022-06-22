<?php

namespace App\Modules\Produk\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'produks';
    protected $primaryKey           = 'id_produk';
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

    public function getProduk($page = false, $limit = false)
    {
        $offset = ($page - 1) * $limit;
        $this->select("{$this->table}.*, m.media_path, k.nama_kategori");
        $this->join("medias m", "m.id_produk = {$this->table}.id_produk", "left");
        $this->join("kategoris k", "k.id_kategori = {$this->table}.id_kategori");
        $this->orderBy("{$this->table}.id_produk", "ASC");
        $query = $this->findAll($limit, $offset);
        return $query;
    }

    public function showProduk($id)
    {
        $this->select("{$this->table}.*, m.media_path, k.nama_kategori");
        $this->join("medias m", "m.id_produk = {$this->table}.id_produk", "left");
        $this->join("kategoris k", "k.id_kategori = {$this->table}.id_kategori");
        $this->where("{$this->table}.id_produk", $id);
        $this->orderBy("{$this->table}.id_produk", "ASC");
        $query = $this->first();
        return $query;
    }

    public function getProdukTerbaru($page = false, $limit = false)
    {
        $offset = ($page - 1) * $limit;
        $this->orderBy("{$this->table}.id_produk", "DESC");
        return $this->findAll($limit, $offset);
    }

    public function getProdukKasir()
    {
        $this->select("{$this->table}.*, m.media_path, k.nama_kategori");
        $this->join("medias m", "m.id_produk = {$this->table}.id_produk", "left");
        $this->join("kategoris k", "k.id_kategori = {$this->table}.id_kategori");
        $this->where("{$this->table}.active", 1);
        $this->orderBy("{$this->table}.id_produk", "ASC");
        $query = $this->findAll();
        return $query;
    }

    public function searchProduk($keyword = false)
    {
        $this->select("{$this->table}.*, k.id_kategori, k.nama_kategori");
        $this->join("kategoris k", "{$this->table}.id_kategori = k.id_kategori", 'inner');
        $this->like("{$this->table}.id_produk", $keyword);
        $this->orLike("{$this->table}.nama_produk", $keyword);
        $this->orLike("{$this->table}.merk", $keyword);
        return $this->findAll();
    }

}
