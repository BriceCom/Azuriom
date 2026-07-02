<?php

namespace Azuriom\Plugin\Tasks\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        return response()->json('Hello world!');
    }

}
