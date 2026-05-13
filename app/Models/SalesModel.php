<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $allowedFields = ['products_id', 'quantity', 'price', 'total', 'created_at'];

    /**
     * Get sales report with product details
     */
    public function getSalesReport()
    {
        return $this->select('sales.*, products.name as product_name')
            ->join('products', 'products.id = sales.products_id')
            ->orderBy('sales.created_at', 'DESC')
            ->findAll();
    }
}
