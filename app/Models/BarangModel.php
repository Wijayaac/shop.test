<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idBarang';

    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'slug', 'deskripsi', 'gambar'];

    public function getBarang($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
