<?php
namespace App\Interface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseInterface {


    public function findAll(): Collection;

    public function findById($id): ?Model;

    public function storeRecord(array $array): ?Model;

    public function updateRecord($id, array $array): bool;

    public function deleteRecord($id): bool;

    public function findLatest(): Model;

    public function findByUpdated(): Model;
}
