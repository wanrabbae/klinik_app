<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfografisCtrl extends Controller
{
    public function index()
    {
        return view('infografis.infografis');
    }
}
