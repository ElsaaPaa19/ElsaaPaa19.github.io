<?php

namespace App\Modules\Nota\Models;

use CodeIgniter\Model;

class NotaItemModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'nota_items';
    protected $primaryKey           = 'id_itemnota';
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

    public function findNota($id)
    {
        $this->select("{$this->table}.*, b.nama_produk, n.no_nota, n.total");
        $this->join("notas n", "n.id_nota = {$this->table}.id_nota");
        $this->join("produks b", "b.id_produk = {$this->table}.id_produk");
        $this->where("{$this->table}.id_nota", $id);
        //$this->orderBy("{$this->table}.id_produk", "ASC");
        $query = $this->findAll();
        return $query;
    }

    public function findNotaCetak($id)
    {
        $this->select("{$this->table}.*, b.nama_produk, n.no_nota, n.total");
        $this->join("notas n", "n.id_nota = {$this->table}.id_nota");
        $this->join("produks b", "b.id_produk = {$this->table}.id_produk");
        $this->where("{$this->table}.id_nota", $id);
        //$this->orderBy("{$this->table}.id_produk", "ASC");
        $query = $this->get()->getResult();
        return $query;
    }
}
