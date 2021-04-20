<?php
namespace App\Repositories\Interfaces;

use App\Models\Company;

interface CompanyRepositoryInterface {

    /**
     * create a company
     */
    public function create(array $data);

    /**
     * gel all companies
     */
    public function all();

    /**
     * get a company
     */
    public function get($id);

    /**
     * update a company
     */
    public function update(Company $model, array $data);

    /**
     * delete a company
     */
    public function delete(Company $model);
        
}