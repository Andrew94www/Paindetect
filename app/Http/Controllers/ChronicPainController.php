<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChronicPainController extends Controller
{
 public function cretatePatient(Request $request){
    $request->except(['_token']);
    $result = DB::table('patient')->insert($request->except(['_token']));
    return redirect('paindetect');
 }


 public function cretatePatientIndex(Request $request){
    $request->except(['_token']);
    $result = DB::table('patient_index')->insert($request->except(['_token']));
    return redirect('chronicpain');

 }

 public function cretatePatientPainDetect(Request $request){
    dd($request->all());
 }
}
