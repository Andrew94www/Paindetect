<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChronicPainController extends Controller
{
 public function index(Request $chronicPain){
    dd($chronicPain->input('question'));
 }
}
