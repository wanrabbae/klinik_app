<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionCtrl extends Controller
{
    public function index()
    {
        return view('transaction.transaction');
    }
}
