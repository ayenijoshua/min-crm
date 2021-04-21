<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\RepositoryInterface;
use App\Models\User;

class UserController extends Controller
{
    function __construct(RepositoryInterface $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->count();
        $companies = \App\Models\Company::count();
        return view ('admin.dashboard',['users'=>$users,'companies'=>$companies]);
    }

    /**
     * get employee dashboard
     */
    public function userDashboard(Request $request)
    {
        $id = $request->user()->id;//->with('company');
        $user = $this->user->get($id)->load('company');
        //dd($user);
        return view ('employee.dashboard',['user'=>$user]);
    }

    /**
     * get users page
     */
    public function users(){
        return view('admin.users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user($id)
    {
        return response(['user'=>$this->user->get($id)->load('company'),'success'=>true],200);
    }

    /**
     * load users resource
     */
    public function all(){
        $users = $this->user->with('company')->paginate(20);
        return response(['users'=>$users,'success'=>true],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = \App\Models\Company::all()->toJson();
        return view('admin.create-user',['companies'=>$companies]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $this->user->create($request->all());
        return response(['message'=>'User created successfully','success'=>true],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(['user'=>$this->user->get($id),'success'=>true],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.edit-user',['id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $id)
    {
        if($this->user->valueExists('email',$request->email,$id->id)){
           return response(['message'=>'Email Already exist','success'=>false],422);
        }
        $this->user->update($id,$request->all());
        return response(['message'=>'User updated successfully','success'=>true],201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $id)
    {
        $this->user->delete($id);

        return response(['message'=>"User delete successfully",'success'=>true]);
    }
}
