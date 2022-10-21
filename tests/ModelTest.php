<?php

namespace Hnabeel64\Repopackage\Tests;

use Hnabeel64\Repopackage\Tests\TestCase;
use App\Models\Check;
use App\Repository\CheckService;

class ModelTest extends TestCase
{
    /** @test */
    public function it_creates_record_in_model()
    {
        // dd($this->assertDatabaseHas('checks'));
        $model = new Check();
        $check = new CheckService($model);
        $check2 = $model::create([
            'name' => 'dummytest'
        ]);
        $result = $check->all();
        $this->assertNotNull($result);
        $this->assertNotNull($check2);
        $this->assertEquals(1,Check::count());
        $this->assertTrue($result, $check2);
    }

}
