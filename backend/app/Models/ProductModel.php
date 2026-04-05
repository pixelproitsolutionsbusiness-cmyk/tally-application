<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_id', 'name', 'hsn_code', 'gst_rate', 'stock'];
    protected $useTimestamps = true;
}
