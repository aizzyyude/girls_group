<?php

namespace App\Controllers;

use App\Models\ProductModel;

class SalesController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return view('pos');
    }

    public function getProducts()
    {
        $products = $this->productModel->findAll();

        return $this->response->setJSON([
            'data' => $products
        ]);
    }

    public function checkout()
    {
        $db = \Config\Database::connect();

        $cart = $this->request->getPost('cart');

        foreach ($cart as $item) {

            $db->table('sales')->insert([
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['qty']
            ]);

            $db->table('products')
                ->where('id', $item['id'])
                ->set('stock', 'stock - ' . (int)$item['qty'], false)
                ->update();
        }

        return $this->response->setJSON([
            'success' => true
        ]);
    }
}