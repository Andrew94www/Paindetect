<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChronicPainController extends Controller
{
 public function cretatePatient(Request $request){
    $result = DB::table('patient')->insert($request->except(['_token']));
    return redirect('paindetect');
 }


 public function cretatePatientIndex(Request $request){
    $result = DB::table('patient_index')->insert($request->except(['_token']));
 }

 public function cretatePatientPainDetect(Request $request){
    $result = DB::table('pain_detect')->insert($request->except(['_token']));
    return redirect('chronicpain');
 }
}
