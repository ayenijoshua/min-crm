<?php
namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface {

    /**
     * create a user
     */
    public function create(array $data);

    /**
     * gel all users
     */
    public function all();

    /**
     * get a user
     */
    public function get($id);

    /**
     * update a user
     */
    public function update($model, array $data);

    /**
     * delete a user
     */
    public function delete($model);
        
}