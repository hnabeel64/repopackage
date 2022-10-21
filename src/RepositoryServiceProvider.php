<?php

namespace Hnabeel64\Repopackage;

use Hnabeel64\Repopackage\Console\CreateRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function getInterfaces(){
        $files = new FileSystem();
        $folder = $files->isDirectory(app_path('Interface'));
        if($folder)
        {
            if(!empty($folder))
            {
                $result = array_diff(scandir(app_path('Interface')), ['.', '..']);
                $result = array_map(function($val){
                    return str_replace('.php', '', 'App\Interface\\'.$val);
                }, $result);
                $result = implode(',',$result);
                return $result;
            }
            return false;
        }
        return false;
    }
    public function getRepository(){
        $files = new FileSystem();
        $folder = $files->isDirectory(app_path('Repository'));
        if($folder)
        {
            if(!empty($folder))
            {
                $result = array_diff(scandir(app_path('Repository')), ['.','..']);
                $result = array_map(function($val) {
                    return str_replace('.php', '', 'App\Repository\\'.$val);
                }, $result);
                $result = implode(',',$result);
                return $result;
            }
            return false;
        }
        return false;
    }
    public function mergeBoth()
    {
        $arr1 = explode(",",$this->getInterfaces());
        $arr2 = explode(",",$this->getRepository());
        $aa = array_merge($arr1,$arr2);
        $matches = [];
        $final ='';
        foreach($arr1 as $key)
        {
            $remove = "App\Interface\\";
            $arrMatch = array_map(function($val) use($remove){
                return preg_replace('/::class/i', '', str_replace($remove, '', $val));
            }, $arr1);
            $arrMatch = array_map(function($val) use ($remove){
                return preg_replace('/Interface/i', '',str_replace($remove, '', $val));
            }, $arr1);
            foreach($arrMatch as $key => $arrM){
                $keysValue = trim($final);
                $matches[$key]  = "'". implode("','",array_values(preg_grep("/$arrM/i", $aa))). "'";
            }
        }
        // dd($matches);
        return $matches;

    }
    public function boot()
    {

        if($this->app->runningInConsole())
        {
            $this->app->booted(function() {
                $this->commands([
                    CreateRepository::class,
                ]);
            });
            $this->loadMigrationsFrom(realpath('tests/database/migrations/'));
        }
        $this->publishes([
            __DIR__.'/Interface' => app_path('Interface/'),
            __DIR__.'/Repository' => app_path('Repository/')
        ], 'repository');
    }

    public function register()
    {
        if(!empty($this->mergeBoth()))
        {
            $array = $this->mergeBoth();
            foreach ($array as $key => $value) {
                $x = explode(',',$value);
                $this->app->bind($x[0]. "," .$x[1]);
            }
            // dd(app()->getBindings());
        }
    }
}

?>
