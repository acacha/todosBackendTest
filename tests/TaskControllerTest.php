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

    protected $apiResult = '[{
"name": "Suscipit qui vitae voluptatem illo unde neque commodi.",
"done": true,
"priority": 5
},
{
    "name": "Quia et dolores et.",
"done": true,
"priority": 8
},
{
    "name": "Quaerat dicta aperiam unde dicta ut repellendus excepturi necessitatibus.",
"done": true,
"priority": 5
}]';

    /**
     * Mocking
     */
    public function __construct()
    {
        // We have no interest in testing Eloquent
        $this->mock = Mockery::mock('GuzzleHttp\Client');
    }

    public function tearDown()
    {
        Mockery::close();
    }

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
        $stream = GuzzleHttp\Psr7\stream_for('{"data" : '. $this->apiResult . ' }');

        $response = new \GuzzleHttp\Psr7\Response(
            200,
            ['Content-Type' => 'application/json'],
            $stream
        );
        //1 Prepare test
        $this->login();
        //1.1 Isolate
        $this->mock
            ->shouldReceive('request')
            ->once()
            ->andReturn($response);

        $this->app->instance('GuzzleHttp\Client', $this->mock);

        //2 Execute test
        $response = $this->call('GET', '/tasks');
        //3 comprovacions/assercions/shoulds/expectations
        $this->assertEquals(200, $response->status());
        $this->assertViewHas('tasks');

















        // getData() returns all vars attached to the response.
        $tasks = $response->original->getData()['tasks'];

//      $this->assertTrue(is_array($tasks));
//      dd(get_class($tasks));
        $this->assertInstanceOf('Illuminate\Support\Collection', $tasks);
        $this->assertInstanceOf('StdClass', $tasks[0]);
    }

    protected function login()
    {
        $user = factory(\App\User::class)->create();
        $this->actingAs($user);
    }
}
