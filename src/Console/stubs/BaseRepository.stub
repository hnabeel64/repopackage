<?php
namespace App\Repository;

use App\Interface\BaseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;


class BaseRepository implements BaseInterface{

    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findAll(): Collection
    {
        return $this->model->get();
    }
    public function findById($id): ?Model
    {
        return $this->model->find($id);
    }
    public function storeRecord(array $array): ?Model
    {
        return $this->model->create($array);
    }
    public function updateRecord($id, array $array) : bool
    {
        return $this->model->where('id',$id)->update($array);
    }
    public function deleteRecord($id): bool
    {
        $delete = $this->model->find($id);
        if($delete !== null){
            $delete->delete();
            return true;
        }
        return false;
    }

    public function findLatest(): Model
    {
        return $this->model->latest()->first();
    }

    public function findByUpdated(): Model
    {
        return $this->model->orderBy('updated_at','DESC')->first();
    }
}
