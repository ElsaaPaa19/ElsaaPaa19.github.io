<?php

namespace App\Modules\Kas\Models;

use CodeIgniter\Model;

class KasModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'kas_saldos';
    protected $primaryKey           = 'id_kas';
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

    public function getKas()
    {
        $this->select("{$this->table}.*, l.nama");
        $this->join("logins l", "l.id_login = {$this->table}.id_login");
        $query = $this->findAll();
        return $query;
    }

    public function showKas($id)
    {
        $this->select("{$this->table}.*, l.nama");
        $this->join("logins l", "l.id_login = {$this->table}.id_login");
        $this->where("{$this->table}.id_kas", $id);
        $query = $this->first();
        return $query;
    }
}
