<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class TaskControllerTest
 */
class TaskControllerTest extends TestCase
{
    use DatabaseMigrations;

    /*
     * Overwrite createApplication to add Http Kernel
     * see: https://github.com/laravel/laravel/pull/3943
     *      https://github.com/laravel/framework/issues/15426
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Http\Kernel::class);

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }


    /**
     * A basic test example.
     * @group todo
     * @return void
     */
    public function testExample()
    {
        //1 Prepare test
        $this->login();
        //2 Execute test
        $response = $this->call('GET', '/tasks');
        //3 comprovacions/assercions/shoulds/expectations
//        dd($response);
        $this->assertEquals(200, $response->status());
        $this->assertViewHas('tasks');
    }

    protected function login()
    {
        $user = factory(\App\User::class)->create();
        $this->actingAs($user);
    }
}
