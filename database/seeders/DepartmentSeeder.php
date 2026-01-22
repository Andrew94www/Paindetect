<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            // [Название => ['code' => 'slug', 'access' => 'password']]
            "Кафедра анатомії людини" => ["anatomy", "anatomy123"],
            "Кафедра біологічної фізики, медичної апаратури та інформатики" => ["biophysics", "phys456"],
            "Кафедра біохімії та загальної хімії" => ["biochemistry", "chem789"],
            "Кафедра гістології" => ["histology", "histo101"],
            "Кафедра медичної біології" => ["med-biology", "bio202"],
            "Кафедра мікробіології" => ["microbiology", "micro303"],
            "Кафедра нормальної фізіології" => ["physiology", "physio404"],
            "Кафедра патологічної анатомії" => ["path-anatomy", "path505"],
            "Кафедра патологічної фізіології" => ["path-physiology", "path606"],
            "Кафедра іноземних мов" => ["languages", "lang707"],
            "Кафедра суспільних наук" => ["social-sciences", "soc808"],

            "Кафедра акушерства і гінекології №1" => ["obstetrics-1", "obs1-909"],
            "Кафедра акушерства і гінекології №2" => ["obstetrics-2", "obs2-010"],
            "Кафедра внутрішньої медицини №1" => ["int-medicine-1", "med1-111"],
            "Кафедра внутрішньої медицини №2" => ["int-medicine-2", "med2-222"],
            "Кафедра внутрішньої та сімейної медицини" => ["family-medicine", "fam333"],
            "Кафедра ендокринології" => ["endocrinology", "endo444"],
            "Кафедра інфекційних хвороб" => ["infectious-diseases", "inf555"],
            "Кафедра клінічної фармації" => ["clin-pharmacy", "pharm666"],
            "Кафедра медицини катастроф та військової медицини" => ["military-med", "mil777"],
            "Кафедра нервових хвороб" => ["neurology", "neuro888"],
            "Кафедра променевої діагностики та онкології" => ["oncology", "onco999"],
            "Кафедра педіатрії №1" => ["pediatrics-1", "ped1-000"],
            "Кафедра педіатрії №2" => ["pediatrics-2", "ped2-121"],
            "Кафедра пропедевтики внутрішньої медицини" => ["propaedeutics", "prop323"],
            "Кафедра психіатрії та наркології" => ["psychiatry", "psych434"],
            "Кафедра травматології та ортопедії" => ["traumatology", "traum545"],
            "Кафедра хірургії №1" => ["surgery-1", "surg656"],
            "Кафедра хірургії №2" => ["surgery-2", "surg767"],

            "Кафедра ортопедичної стоматології" => ["ortho-dentistry", "ortho878"],
            "Кафедра стоматології дитячого віку" => ["ped-dentistry", "peddent989"],
            "Кафедра терапевтичної стоматології" => ["ther-dentistry", "ther090"],
            "Кафедра хірургічної стоматології" => ["surg-dentistry", "surg101"],

            "Кафедра фармації" => ["pharmacy", "pharm202"],
            "Кафедра pharmaceutical-chemistry" => ["pharm-chemistry", "pchem303"],
        ];

        foreach ($departments as $name => $data) {
            DB::table('departments')->updateOrInsert(
                ['code' => $data[0]], // Проверка по уникальному слагу
                [
                    'name' => $name,
                    'access_code' => $data[1], // Тот самый код доступа
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
