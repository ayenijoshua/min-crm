<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\DB;

//use App\Jobs\StoreLocalFileJob;

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
     * update or create a model
    * @$columns - table columns
    * @data - post data
    */
    public function updateOrCreate(array $columns, array $data): model
    {
        return $this->model->updateOrCreate($columns,$data);
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
     * destroy many models
    * @ids - unique ids of models
    */
    public function deleteMany(array $ids): void
    {
        $this->model->destroy($ids);
    }

    /**
     * set model instance
    * @$model - Eloquent model
    */
    public function setModel(String $model): model
    {
        return $this->model = new $model;
    }

    /**
     * get value from  a table
    * @id - Id of model
    * @coloumn - name of column to get
    */
    public function getValue($id,$column): Builder
    {
        return $this->get($id)->value($column);
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
     * checks if model has relationships and notifies the user to dessociate before delete
    * especially in hasMany/belongsTo relationship
    * $model - model instance
    * $relations - array of model's relations
    */
    public function isRelatedTo(Model $model, array $relations): string
    { // if model hasMany relations
        $relation_array = [];
        foreach($relations as $relation){
            if(count($model->$relation) > 0){
                array_push($relation_array,$relation);
            }
        }
        if( count($relation_array) > 0 ){
            return implode(',',$relation_array);
        }
        return false;
    }

    /**
     * detaches belongsToMany model relations during delete
    * $model - model in use
    * $relationships - array of relations
    */
    public function detachRelations(Model $model, array $relationships): void
    {
        foreach($relationships as $relations){
            //check if model has relations
            if($model_relations = $model->$relations){
                foreach($model_relations as $relation){
                    //detach the model from the relations
                    $model->$relations()->detach($relation);
                }
            }
        }
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

    //  public function valueExistsExcept($column,$value){
    //     $old_value = $this->getModel()->where($column,$value)->where('id',)first();
    //     if($old_value){
    //         return true;
    //     }
    //     return false;
    //  }

    /**
     * remove duplicate ids from the request
    * this is useful when attaching in many-to-many relationships, so you could 
    * remove ids that already exists in the db from the request and return the rest
    * $model - model instance
    * $relation - static model relationship
    * $id - array of id | any other variable you want to detach
    */
    public function removeDuplicateRelations(Model $model,$relation,$ids): Collection
    {
        $collection = collect($ids); $idExists = [];
        //dd($collection);
        foreach($collection->all() as $key=>$val){
            if($model->$relation->contains($val)){
                array_push($idExists,$key);
            }
        }
        return $collection->except($idExists);
    }

    /**
     * set unique value
    * $num - length of value
    * $column - coulumn name
    */
    public function setUniqueValue($column,$num=7): string
    {
        $val = \Illuminate\Support\Str::random($num);
        $old_val = $this->model->where($column,$val)->first();
        if($old_val){
            $this->setUniqueValue($column,$num);
        }
        return $val;
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
     * delete belongs to relations
    */
    public function deleteRelations(Model $model, array $relations)
    {
        foreach($relations as $relation){
            if($model->$relation->count()>0){
                if(!$model->$relation()->delete()){
                    return false;
                }
            }
        }
        return true;
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

    /**
     * use db transaction
    */
    public function transaction(Closure $callback,$retries=1)
    {
        return DB::transaction($callback,$retries);
    }

    public function beginTransaction(){
        DB::beginTransaction();
    }

    public function commitTransaction(){
        DB::commit();
    }

    public function rollbackTransaction(){
        DB::rollBack();
    }



}