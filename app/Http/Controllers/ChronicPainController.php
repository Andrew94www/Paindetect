<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class ChronicPainController extends Controller
{
 public function cretatePatient(Request $request){
     dd($request->all());
    $request->validate([
        'question' => 'required',
        "question_1" => 'required',
        "question_2" => 'required',
        "question_3" => 'required',
        "question_4" => 'required',
        "question_5" => 'required',
        "question_6" => 'required',
        "question_7" => 'required',
        "question_8" => 'required',
        "question_9" => 'required',
       ]);
    $result = DB::table('patient')->insert($request->except(['_token']));
    return redirect('paindetect');
 }


 public function cretatePatientIndex(Request $request){
   $request->validate([
    'date' => 'required',
    "name" => 'required',
    "id_patient" => 'required',
    "contact_id" => 'required',
    "treatment" => 'required'
   ]);
    $result = DB::table('patient_index')->insert([ "name" => $request->input('name'),
    'date' => $request->input('date'),
    "id_patient" =>  $request->input('id_patient'),
    "contact_id" => $request->input('contact_id'),//'nociceptionPain'
    "noc_now" => $request->input('nociceptionPain'),
    "ish_now" => $request->input('ishemiaPain'),
    "neu_now" => $request->input('neuropaticPain'),
    "cen_now" => $request->input('sensitPain'),
    "dez_now" => $request->input('dezingibitionPain'),
    "dis_now" => $request->input('disfunPain'),
    "treatment" =>  $request->input('treatment'),]);

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
    return redirect('/');
 }
 public function changeLocale($locale)
 {
     $availableLocales = ['ru', 'en','ua'];

     if (!in_array($locale, $availableLocales)) {
         $locale = config('app.locale');
     }
     session(['locale' => $locale]);
     App::setLocale($locale);
     return redirect()->back();
 }
}
