<?php

namespace Hnabeel64\Repopackage\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:make {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Repository Interface with Model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FileSystem $files)
    {
        $this->files = $files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $path = $this->getInterfaceSourcePath();
        $path2 = $this->getRepositorySourcePath();
        $content = $this->getInterfaceSourceFile();
        $content2 = $this->getRepositorySourceFile();
        $modelpath = $this->getModelSourcePath();
        $model = $this->getModelSourceFile();
        if(!$this->files->isDirectory(app_path('Repository/')) && !$this->files->isDirectory(app_path('Interface/')))
        {
            $this->makeFolder(app_path('Interface/'), 0777, true, true);
            $this->files->copy($this->getBaseInterfaceStubPath(), $this->getBaseInterfaceSourcePath());
            $this->makeFolder(app_path('Repository/'), 0777, true, true);
            $this->files->copy($this->getBaseRepositoryStubPath(),$this->getBaseRepositorySourcePath());
        }
        if(!$this->files->exists($path) && !$this->files->exists($path)){
            if(!$this->files->exists($modelpath))
            {
                if($this->confirm('Do you want to make a model with same name?')){
                    $this->files->put($modelpath, $model);
                    $this->info("Model:  {$this->argument('filename')} created successfully");
                }
            }
            $this->files->put($path, $content);
            $this->files->put($path2, $content2);
            $this->info("File: {$this->argument('filename')} Service \n{$this->argument('filename')} Interface created successfully");
        }
        else
        {
            $this->error("File: {$path} already exists !");
        }
    }

    public function makeFolder($name)
    {
        return $this->files->makeDirectory($name);
    }
    public function getModelPath($name)
    {
        if(!file_exists($name)){
            return app_path('Models');
        }
        return false;
    }
    public function getModelStubPath()
    {
        return __DIR__.'/stubs/Model.stub';
    }
    public function getModelStubVariable()
    {
        return [
            'CLASS_NAME' => $this->getSingularClassName($this->argument('filename'))
        ];
    }
    public function getModelSourceFile(){
        return $this->getStubContents($this->getModelStubPath(), $this->getModelStubVariable());
    }
    public function getModelSourcePath()
    {
        return app_path('Models/') . $this->getSingularClassName($this->argument('filename')).'.php';
    }
    public function getSingularClassName($name){
        return ucwords(Pluralizer::singular($name));
    }
    public function getInterfaceStubPath(){
        return __DIR__.'/stubs/Interface.stub';
    }
    public function getRepositoryStubPath(){
        return __DIR__.'/stubs/Repository.stub';
    }
    public function getBaseInterfaceStubPath(){
        return __DIR__.'/stubs/BaseInterface.stub';
    }
    public function getBaseRepositoryStubPath(){
        return __DIR__.'/stubs/BaseReposistory.stub';
    }
    public function getInterfaceStubVariable(){
        return [
            'NAMESPACE' => 'App\\Interface',
            'CLASS_NAME' => $this->getSingularClassName($this->argument('filename'))
        ];
    }
    public function getRepositoryStubVariable(){
        return [
            'NAMESPACE' => 'App\\Repository',
            'CLASS_NAME' => $this->getSingularClassName($this->argument('filename'))
        ];
    }
    public function getInterfaceSourceFile(){
        return $this->getStubContents($this->getInterfaceStubPath(), $this->getInterfaceStubVariable());
    }
    public function getRepositorySourceFile(){
        return $this->getStubContents($this->getRepositoryStubPath(), $this->getRepositoryStubVariable());
    }
    public function getStubContents($stub, $stubVariables = []){
        $content = file_get_contents($stub);
        foreach ($stubVariables as $search => $replace) {
            $content = str_replace('$'.$search.'$', $replace, $content);
        }
        return $content;
    }
    public function getInterfaceSourcePath(){
        return app_path('Interface') . '/' . $this->getSingularClassName($this->argument('filename')
        . 'Interface.php');
    }
    public function getRepositorySourcePath(){
        return app_path('Repository') . '/'. $this->getSingularClassName(
            $this->argument('filename') . 'Repository.php'
        );
    }
    public function getBaseRepositorySourcePath()
    {
        return app_path('Repository') . '/BaseRepository.php';
    }
    public function getBaseInterfaceSourcePath()
    {
        return app_path('Interface') . '/BaseInterface.php';
    }

}
