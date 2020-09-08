<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KabuApi;

class KabuController extends Controller
{
    public function board($symbol = 9984)
    {
        return view('board', [ 'info' => (new KabuApi())->board($symbol)]);
    }
}