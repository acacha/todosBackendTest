<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    protected $client;

    protected $urlTodosBakend="http://localhost:8085/api/v1/task";

    /**
     * TaskController constructor.
     * @param $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function index()
    {
        $tasks = \GuzzleHttp\json_decode($this->client->request('GET',$this->urlTodosBakend)->getBody())->data;
//        dd($tasks);
        return view('tasks')->with('tasks', $tasks);
    }
}
