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

    public function updateCompany($model,$request){
        $this->update($model,$request->except('logo_path'));
        if($request->hasFile('logo_path')){
            $file = $this->storeLocalFile($request,'logo_path','company-logos');
            $this->update($model,['logo_path'=>$file]);
        }
    }

    public function createCompany($request){
        $company = $this->create($request->except('logo_path'));
        if($request->hasFile('logo_path')){
            $file = $this->storeLocalFile($request,'logo_path','company-logos');
            $this->update($company,['logo_path'=>$file]);
        }
    }
}