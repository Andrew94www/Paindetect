<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChronicPainController extends Controller
{
 public function index(Request $request){
    $request->except(['_token']);
   $result = DB::table('patient')->insert($request->except(['_token']));
  dd($result);
 }
}
