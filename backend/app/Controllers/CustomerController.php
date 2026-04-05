<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CustomerController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();
        return $this->respond($customers);
    }

    public function create()
    {
        $rules = [
            'company_id' => 'required|integer',
            'name' => 'required|min_length[3]',
            'gstin' => 'permit_empty|exact_length[15]',
            'address' => 'required',
            'state' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $customerModel = new CustomerModel();
        $data = [
            'company_id' => $this->request->getVar('company_id'),
            'name' => $this->request->getVar('name'),
            'gstin' => $this->request->getVar('gstin'),
            'address' => $this->request->getVar('address'),
            'state' => $this->request->getVar('state'),
        ];

        $customerModel->save($data);
        return $this->respondCreated(['message' => 'Customer created successfully.']);
    }

    public function update($id = null)
    {
        $rules = [
            'company_id' => 'required|integer',
            'name' => 'required|min_length[3]',
            'gstin' => 'permit_empty|exact_length[15]',
            'address' => 'required',
            'state' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $customerModel = new CustomerModel();
        $data = [
            'company_id' => $this->request->getVar('company_id'),
            'name' => $this->request->getVar('name'),
            'gstin' => $this->request->getVar('gstin'),
            'address' => $this->request->getVar('address'),
            'state' => $this->request->getVar('state'),
        ];

        if (!$customerModel->update($id, $data)) {
            return $this->failNotFound('Customer not found.');
        }

        return $this->respond(['message' => 'Customer updated successfully.']);
    }

    public function delete($id = null)
    {
        $customerModel = new CustomerModel();

        if (!$customerModel->delete($id)) {
            return $this->failNotFound('Customer not found.');
        }

        return $this->respondDeleted(['message' => 'Customer deleted successfully.']);
    }
}
