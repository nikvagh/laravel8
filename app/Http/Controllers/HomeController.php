<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index(){
		return view('home');
	}
	public function chat(){
		return view('chatHome');
	}
}
