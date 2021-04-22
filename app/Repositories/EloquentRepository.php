<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


abstract class EloquentRepository {
    protected $model;

    function __construct(Model $model){
        $this->model = $model;
    }

    /**
     * get model instance
    */
    abstract public function getModel();

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
     
    /**
     * fetch all models
    */
    public function all(): Collection
    {
        return $this->model->all();
    }
    
    /**
     * count model collections
    */
    public function count()
    {
        return $this->model->count();
    }
    
    /**
     * paginate model collections
    */
    public function paginate($num)
    {
        return $this->model->paginate($num);
    }
    
    /**
     * get a model
    */
    public function get($id): Model
    {
        return $this->model->find($id);
    }
    
    /**
     * update model
    * @$model - Eloquent model
    */
    public function update($model, array $data): bool
    {
        return $model->update($data);
    }
    
    /**
     * delete model
    * @$model - Eloquent model
    */
    public function delete($model): void
    {
         $model->delete();
    }

    /**
     * eager load relations
    * $relations - array of relations
    */
    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    /**
     * check if value exists in model's table
    * $column - column in the table
    * $value - value to check for
    */
    public function valueExists($column,$value,$id=null): bool
    {
        $old_value = $this->model->where($column,$value)->whereNotIn('id',[$id])->first();
        if($old_value){
            return true;
        }
        return false;
    }

    /**
     * dessociate a belongs to relationship
    */
    public function dissociateRelations(Model $model,String $model_name, array $relationships): void
    {
        //$model_string = (String)$model;
        foreach($relationships as $relations){
            foreach($model->$relations as $relation){
                $relation->$model_name()->dissociate();
                $relation->save();
            }
        }
    }

    /**
     * sotore file locally
    * @$file_name - file name in html form
    * @$directory - folder to contain file
    * @path - laravel directory name e.g public_path, storage_path etc
    */
    public function storeLocalFile($request,$file_name,$directory,$path='public',$multiple=null): String
    {
        $file_path = $request->file($file_name)->store($directory,$path);
        if(! $file_path){
            throw new \Exception("Unable to store file");
        }
        $this->callArtisan();
        return $file_path;
    }

    /**
     * delete a local file
    * @$file_path - file path to be deleted
    */
    public function deleteLocalFile($directory,$path='public'): void
    {
        if(! Storage::disk($path)->delete($directory)){
            throw new \Exception("Unable to delete file");
        }
        $this->callArtisan();
    }

    /**
     * call artisan command
    * @$command - command string/name
    */
    public function callArtisan($command='storage:link'): void
    {
        Artisan::call($command);
    }




}