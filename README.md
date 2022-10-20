# repopackage
Make Repository service class, Interfaces and predefined methods and model with just one command. Simple to Medium CRUD generator ease of development for repository pattern followers.
=========================================

The repopackage is the idea of repository design pattern implementation
for beginner to intermediate developer. Time savour for the developer
just install the package and publish assets. Don't need to add Model manually
just run the command and repopackage will take care the other things. ;)

  1. Install package by this command `composer require hnabeel64/repopackage`

  2. Then publish the vendor `php artisan vendor:publish --tag=repository`

  3. Now When a new table exist and you want to make a crud for it just
     write on console `php artisan repository:make {TableName}` 



Usage
-----

Repository pattern is easy to use as:

when you publish the vendor and make a new repository through command,
this Base Interface come with pre defined methods such as: 

```php
public function findAll(): Collection;

public function findById($id): ?Model;

public function storeRecord(array $array): ?Model;

public function updateRecord($id, array $array): bool;

public function deleteRecord($id): bool;

public function findLatest(): Model;

public function findByUpdated(): Model;
```

These are predefined methods in repository service and Interface
have and both are bind on service container through service provider
dynamically.

Child Interface contain following extra methods

```php
    public function findAll(): Collection;

    public function findById($id): ?Model;

    public function storeRecord(array $array): ?Model;

    public function updateRecord($id, array $array): bool;

    public function deleteRecord($id): bool;

    public function findLatest(): Model;

    public function findByUpdated(): Model;

    public function findBy($field, $value): ?Model;

    public function search($field, $value): ?Model;
```

:warning: **NOTE:** you have to implement these methods in controller with try catch blocks. Import the class through dependency-injection


