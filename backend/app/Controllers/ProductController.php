<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll();
        return $this->respond($products);
    }

    public function create()
    {
        $rules = [
            'company_id' => 'required|integer',
            'name' => 'required|min_length[3]',
            'hsn_code' => 'required|min_length[6]|max_length[10]',
            'gst_rate' => 'required|decimal',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $productModel = new ProductModel();
        $data = [
            'company_id' => $this->request->getVar('company_id'),
            'name' => $this->request->getVar('name'),
            'hsn_code' => $this->request->getVar('hsn_code'),
            'gst_rate' => $this->request->getVar('gst_rate'),
            'stock' => $this->request->getVar('stock'),
        ];

        $productModel->save($data);
        return $this->respondCreated(['message' => 'Product created successfully.']);
    }

    public function update($id = null)
    {
        $rules = [
            'company_id' => 'required|integer',
            'name' => 'required|min_length[3]',
            'hsn_code' => 'required|min_length[6]|max_length[10]',
            'gst_rate' => 'required|decimal',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $productModel = new ProductModel();
        $data = [
            'company_id' => $this->request->getVar('company_id'),
            'name' => $this->request->getVar('name'),
            'hsn_code' => $this->request->getVar('hsn_code'),
            'gst_rate' => $this->request->getVar('gst_rate'),
            'stock' => $this->request->getVar('stock'),
        ];

        if (!$productModel->update($id, $data)) {
            return $this->failNotFound('Product not found.');
        }

        return $this->respond(['message' => 'Product updated successfully.']);
    }

    public function delete($id = null)
    {
        $productModel = new ProductModel();

        if (!$productModel->delete($id)) {
            return $this->failNotFound('Product not found.');
        }

        return $this->respondDeleted(['message' => 'Product deleted successfully.']);
    }
}
