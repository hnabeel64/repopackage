<?php

namespace Hnabeel64\Repopackage\Tests;

use Hnabeel64\Repopackage\Console\CreateRepository;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\Artisan;
use Hnabeel64\Repopackage\Tests\TestCase;

class CommandTest extends TestCase
{
   /** @test **/
   public function it_creates_repository_and_interface()
   {
       Application::starting(function ($artisan) {
           $artisan->add(app(CreateRepository::class));
        });
        $this->artisan('repository:make Check')
        ->expectsConfirmation('Do you want to make a model with same name?', 'yes')
        ->assertExitCode(0);
   }
}
