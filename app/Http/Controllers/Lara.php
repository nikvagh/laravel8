<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class Lara extends Controller
{
    public function lara_form(){
        return view('lara_form');
    }
}
