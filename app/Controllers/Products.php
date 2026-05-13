<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return view('products/index');
    }

            public function fetchRecords()
            {
                $request = $this->request;
                $start = $request->getPost('start');
                $length = $request->getPost('length');
                $searchValue = $request->getPost('search')['value'] ?? '';
            
                $result = $this->productModel->getRecords($start, $length, $searchValue);
                $data = $result['data'];
                $filteredRecords = $result['filtered'];
                $totalRecords = $this->productModel->countAll();
            
                $response = [];
                $no = $start + 1;
            
                foreach ($data as $row) {
                    $statusBadge = '';
                    if ($row['status'] == 'Available') {
                        $statusBadge = '<span class="badge badge-success">Available</span>';
                    } elseif ($row['status'] == 'Out of Stock') {
                        $statusBadge = '<span class="badge badge-danger">Out of Stock</span>';
                    } else {
                        $statusBadge = '<span class="badge badge-secondary">Discontinued</span>';
                    }
            
                    $stockDisplay = $row['stock'] . ' ' . $row['unit'];
            
                    
                    $response[] = [
                        'row_number' => $no++,
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'category' => $row['category'],
                        'price' => '₱' . number_format($row['price'], 2),
                        'stock' => $stockDisplay,
                        'status' => $statusBadge,
                        'created_at' => date('Y-m-d', strtotime($row['created_at'])),
                        'actions' => '<button class="btn btn-sm btn-warning edit-btn" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row['id'] . '"><i class="fas fa-trash"></i> Delete</button>'
                    ];
                }
            
                return $this->response->setJSON([
                    'draw' => $request->getPost('draw'),
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data' => $response
                ]);
            }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $rules = [
            'name' => 'required|min_length[3]',
            'category' => 'required',
            'price' => 'required|numeric|greater_than[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'unit' => $this->request->getPost('unit'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->productModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product added successfully'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to add product'
        ]);
    }

    public function edit($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $product = $this->productModel->find($id);
        if ($product) {
            return $this->response->setJSON(['success' => true, 'data' => $product]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $id = $this->request->getPost('id');

        $rules = [
            'name' => 'required|min_length[3]',
            'category' => 'required',
            'price' => 'required|numeric|greater_than[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'unit' => $this->request->getPost('unit'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->productModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product updated successfully'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update product'
        ]);
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        if ($this->productModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to delete product'
        ]);
    }
    public function getProducts()
    {
        // Try fetching from database
        $products = $this->productModel
            ->orderBy('name', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'data' => $products
        ]);
    }

    public function pos()
    {
        return view('pos');
    }

    public function checkout()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $db = \Config\Database::connect();
        $cart = $this->request->getPost('cart');

        if (empty($cart)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);
        }

        $salesModel = new \App\Models\SalesModel();
        $db->transStart();

        foreach ($cart as $item) {
            $product = $this->productModel->find($item['id']);

            if (!$product) {
                $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "Product not found: " . ($item['name'] ?? 'ID ' . $item['id'])
                ]);
            }

            if ($product['stock'] < $item['qty']) {
                $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "Insufficient stock for {$product['name']}. Available: {$product['stock']}"
                ]);
            }

            $salesModel->insert([
                'products_id' => $item['id'],
                'quantity'    => $item['qty'],
                'price'       => $item['price'],
                'total'       => $item['price'] * $item['qty'],
                'created_at'  => date('Y-m-d H:i:s')
            ]);

            $this->productModel->update($item['id'], [
                'stock' => $product['stock'] - $item['qty']
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction failed. Please try again.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Checkout successful!'
        ]);
    }
}