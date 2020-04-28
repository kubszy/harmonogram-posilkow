<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrzepisyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function przepisy ()
    {
      return view('przepisy.lista');
    }
}
