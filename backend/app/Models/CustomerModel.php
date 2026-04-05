<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_id', 'name', 'gstin', 'address', 'state'];
    protected $useTimestamps = true;
}
