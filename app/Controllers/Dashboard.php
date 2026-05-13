<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Dashboard extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        return view('dashboard');
    }

    public function getStats()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $totalProducts = $this->productModel->countAll();
        
        
        $lowStock = $this->productModel
            ->where('stock <=', 10)
            ->where('stock >', 0)
            ->countAllResults();
        
        
        $outOfStock = $this->productModel
            ->where('stock', 0)
            ->countAllResults();
        
        
        $totalValue = $this->productModel
            ->select('SUM(price * stock) as total')
            ->get()
            ->getRow()
            ->total ?? 0;
        
        return $this->response->setJSON([
            'success' => true,
            'totalProducts' => $totalProducts,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock,
            'totalValue' => $totalValue
        ]);
    }

    public function getRecentProducts()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $products = $this->productModel
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $products
        ]);
    }
}