<?php
namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Models\Company;

class CompanyRepository extends EloquentRepository implements RepositoryInterface
{
    public $user;

    public function __construct(Company $company)
    {
        parent::__construct($company);
        $this->company = $company;
    }

    /**
     * get user instance
     */
    public function getModel(){
        return $this->company;
    }
}