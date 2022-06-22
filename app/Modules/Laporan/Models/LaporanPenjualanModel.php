<?php

namespace App\Modules\Laporan\Models;

use CodeIgniter\Model;

class LaporanPenjualanModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'notas';
    protected $primaryKey           = 'id_nota';
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

    public function getLaporanByPenjualan($start, $end)
    {
        $this->select("{$this->table}.*, l.nama");
        $this->join("logins l", "l.id_login = {$this->table}.id_login");
        $this->where("DATE({$this->table}.created_at) BETWEEN '$start' AND '$end'", '',false);
        $this->orderBy("{$this->table}.id_nota", 'DESC');
        $query = $this->findAll();
        return $query;
    }

}
