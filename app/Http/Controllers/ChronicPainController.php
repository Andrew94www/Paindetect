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
    return redirect('chronicpain');
 }

 public function cretatePatientPainDetect(Request $request){
  $request->validate([
        'questions1' => 'required',
        "questions2" => 'required',
        "questions3" => 'required',
        "questions4" => 'required',
        "questions5" => 'required',
        "questions6" => 'required',
        "questions7" => 'required',
        "questions9" => 'required',
        "questions10" => 'required',
        "questions11" => 'required',
        "imaga" => 'required'
    ]);
    $result = DB::table('pain_detect')->insert($request->except(['_token']));
    return redirect('Index');
 }
}
