<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    public function index()
    {
        return view('tasks')->with('tasks', []);
    }
}
