<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Step extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function getAllStep(){
        $results = DB::table('etapes')->get();
        return $results;
    }

    public function getSetpById($idStep){
        $results = DB::table('etapes')->where('id',$idStep)->first();
        return $results;
    }

    public function getRunnerById($idStep){
        $results = DB::table('view_etape_coureur')->where('idetape',$idStep)->get();
        return $results;
    }

    public function getDepartStepById($idStep){
        $result = DB::table('etapes')
            ->where('id', $idStep)
            ->pluck('date_depart')
            ->first();

        return $result;
    }
}
