<?php
namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Models\User;

class UserRepository extends EloquentRepository implements RepositoryInterface
{
    public $user;

    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    /**
     * get user instance
     */
    public function getModel(){
        return $this->user;
    }
}