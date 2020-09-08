<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KabuApi;

class KabuController extends Controller
{
    public function index()
    {
        dd((new KabuApi())->board(9984));
    }
}