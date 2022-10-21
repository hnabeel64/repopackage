<?php

namespace Hnabeel64\Repopackage\Tests;

use Hnabeel64\Repopackage\RepositoryServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
      parent::setUp();
      $this->artisan('migrate',[
        '--database' => 'testing',
        '--realpath' => realpath(__DIR__.'/database/migrations')
      ])->run();
}

protected function getPackageProviders($app)
{
    return [
        RepositoryServiceProvider::class,
    ];
}

protected function getEnvironmentSetUp($app)
{
    $app['config']->set('database.default', 'testing');
    $app['config']->set('database.connections.testing', [
        'driver'   => 'sqlite',
        'database' => ':memory:',
        'prefix'   => '',
    ]);
}
}
