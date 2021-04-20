<?php
namespace App\Repositories\Interfaces;


interface RepositoryInterface {

    /**
     * create a model
     */
    public function create(array $data);

    /**
     * gel model collection
     */
    public function all();

    /**
     * get a model
     */
    public function get($id);

    /**
     * update a model
     */
    public function update($model, array $data);

    /**
     * delete a model
     */
    public function delete($model);
        
}