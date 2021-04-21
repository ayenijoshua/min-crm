<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\RepositoryInterface;

class CompanyController extends Controller
{
    function __construct(RepositoryInterface $company)
    {
        $this->company = $company;
    }

    function all($paginate=null)
    {
        $companies = $paginate ? $this->company->with('employees')->paginate() : $this->company->all();
        return response(['companies'=>$companies,'success'=>true],200);
    }

    public function companies()
    {
        return view('admin.companies');
    }

    public function company($id){
        return response(['company'=>$this->company->get($id)->load('employees'),'success'=>true],200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create-company');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.edit-company',['id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $id)
    { 
        $company = $id;
        $this->company->updateCompany($company,$request);
        return response(['message'=>'Company updated successfully','success'=>true],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $id)
    {
        $company = $id;
        $this->company->dissociateRelations($company,'company', ['employees']);
        
        $this->company->delete($company);

        return response(['message'=>"Company delete successfully",'success'=>true]);
    }
}
