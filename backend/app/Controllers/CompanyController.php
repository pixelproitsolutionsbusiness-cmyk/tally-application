<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CompanyController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $companyModel = new CompanyModel();
        $companies = $companyModel->findAll();
        return $this->respond($companies);
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'gstin' => 'required|exact_length[15]|is_unique[companies.gstin]',
            'address' => 'required',
            'state' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $companyModel = new CompanyModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'gstin' => $this->request->getVar('gstin'),
            'address' => $this->request->getVar('address'),
            'state' => $this->request->getVar('state'),
        ];

        $companyModel->save($data);
        return $this->respondCreated(['message' => 'Company created successfully.']);
    }

    public function update($id = null)
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'gstin' => 'required|exact_length[15]',
            'address' => 'required',
            'state' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $companyModel = new CompanyModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'gstin' => $this->request->getVar('gstin'),
            'address' => $this->request->getVar('address'),
            'state' => $this->request->getVar('state'),
        ];

        if (!$companyModel->update($id, $data)) {
            return $this->failNotFound('Company not found.');
        }

        return $this->respond(['message' => 'Company updated successfully.']);
    }

    public function delete($id = null)
    {
        $companyModel = new CompanyModel();

        if (!$companyModel->delete($id)) {
            return $this->failNotFound('Company not found.');
        }

        return $this->respondDeleted(['message' => 'Company deleted successfully.']);
    }
}
