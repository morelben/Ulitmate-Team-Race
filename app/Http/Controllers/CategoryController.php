<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function generateCategories()
    {
        $coureurs = DB::table('coureurs')->get();
        foreach ($coureurs as $coureur) {
            $age = Carbon::now()->diffInYears(Carbon::parse($coureur->date_naissance));
            if ($age < 18 ) {
                DB::table('categorie_coureur')->insert([
                   'categorie' => 'Junior',
                    'idcoureur' => $coureur->id
                ]);
            }else{
                DB::table('categorie_coureur')->insert([
                    'categorie' => 'Senior',
                    'idcoureur' => $coureur->id
                ]);
            }
        }
        return redirect()->back()->with('success', 'Rider categories have been successfully generated.');
    }
}
