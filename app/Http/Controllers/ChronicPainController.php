<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ChronicPainController extends Controller
{
    public function cretatePatient(Request $request)
    {
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
        $patient = DB::table('patient')->where('contact_id', Session::get('contact_id'))->first();
        if ($patient) {
            $days_since_creation = floor((time() - (int)$patient->date_create) / (60 * 60 * 24));
            if ($days_since_creation >= 0 && $days_since_creation < 15){
                return redirect()->route('callback');

            }
            if ($days_since_creation >= 0 && $days_since_creation < 15){
                redirect('callback');
            }
            if ($days_since_creation >= 15 && $days_since_creation < 30){
                DB::table('patient')
                    ->where('contact_id', Session::get('contact_id'))
                    ->update(['neu_after_15_day' => $request->input('chronicPain')]);
            }
            if ($days_since_creation >= 30){
                DB::table('patient')
                    ->where('contact_id', Session::get('contact_id'))
                    ->update(['neu_after_30_day' => $request->input('chronicPain')]);
            }
            return redirect('paindetect');
        }
        $result = DB::table('patient')->insert(["neu_now" => $request->input('chronicPain'),
            'contact_id' => Session::get('contact_id'),
            'date_create' => Session::get('date_create')]);
        return redirect('paindetect');
    }


    public function cretatePatientIndex(Request $request)
    {

        $request->validate([
            'date' => 'required',
            "name" => 'required',
            "id_patient" => 'required',
            "contact_id" => 'required',
            "treatment" => 'required'
        ]);
        Session::put('contact_id', $request->input('contact_id'));
        $contact_id = $request->input('contact_id');
        $patient = DB::table('patient_index')->where('contact_id', $contact_id)->first();
        if ($patient) {
            $days_since_creation = floor((time() - (int)$patient->date_create) / (60 * 60 * 24));
            if ($days_since_creation >= 0 && $days_since_creation < 15){
                return redirect()->route('callback');

            }
            if ($days_since_creation >= 15 && $days_since_creation < 30) {
                Session::put('contact_id', $patient->contact_id);
                Session::put('date_create', $patient->date_create);
                DB::table('patient_index')
                    ->where('contact_id', $contact_id)
                    ->update(['noc_after_15_day' => $request->input('nociceptionPain'),
                        'neu_after_15_day' => $request->input('neuropaticPain'),
                        'ish_after_15_day' => $request->input('ishemiaPain'),
                        'cen_after_15_day' => $request->input('sensitPain'),
                        'dez_after_15_day' => $request->input('dezingibitionPain'),
                        'dis_after_15_day' => $request->input('disfunPain')]);
            }
            if ($days_since_creation >= 30) {
                Session::put('contact_id', $patient->contact_id);
                Session::put('date_create', $patient->date_create);
                DB::table('patient_index')
                    ->where('contact_id', $contact_id)
                    ->update(['noc_after_30_day' => $request->input('nociceptionPain'),
                        'neu_after_30_day' => $request->input('neuropaticPain'),
                        'ish_after_30_day' => $request->input('ishemiaPain'),
                        'cen_after_30_day' => $request->input('sensitPain'),
                        'dez_after_30_day' => $request->input('dezingibitionPain'),
                        'dis_after_30_day' => $request->input('disfunPain')]);
            }
            return redirect('chronicpain');
        }
        $result = DB::table('patient_index')->insert(["name" => $request->input('name'),
            'date' => $request->input('date'),
            'date_create' => time(),
            "id_patient" => $request->input('id_patient'),
            "contact_id" => $request->input('contact_id'),//'nociceptionPain'
            "noc_now" => $request->input('nociceptionPain'),
            "ish_now" => $request->input('ishemiaPain'),
            "neu_now" => $request->input('neuropaticPain'),
            "cen_now" => $request->input('sensitPain'),
            "dez_now" => $request->input('dezingibitionPain'),
            "dis_now" => $request->input('disfunPain'),
            "treatment" => $request->input('treatment'),]);
        Session::put('date_create', time());
        return redirect('chronicpain');
    }


    public function cretatePatientPainDetect(Request $request)
    {
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
            "imaga" => 'required'
        ]);
        $patient = DB::table('patient')->where('contact_id', Session::get('contact_id'))->first();
        if ($patient) {
            $days_since_creation = floor((time() - (int)$patient->date_create) / (60 * 60 * 24));
            if ($days_since_creation >= 0 && $days_since_creation < 15){
                return redirect()->route('callback');

            }
            if ($days_since_creation >= 0 && $days_since_creation < 15){
                redirect('callback');
            }
            if ($days_since_creation >= 15 && $days_since_creation < 30){
                DB::table('pain_detect')
                    ->where('contact_id', Session::get('contact_id'))
                    ->update(['neu_after_15_day' => $request->input('chronicPain')]);
            }
            if ($days_since_creation >= 30){
                DB::table('pain_detect')
                    ->where('contact_id', Session::get('contact_id'))
                    ->update(['neu_after_30_day' => $request->input('chronicPain')]);
            }
            return redirect('/');
        }
        $result = DB::table('pain_detect')->insert([
            "neu_now" => $request->input('result'),
            'contact_id' => Session::get('contact_id'),
            'data_create' => Session::get('date_create')]);
        return redirect('/');
    }

    public function changeLocale($locale)
    {
        $availableLocales = ['ru', 'en', 'ua'];

        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();
    }
}
