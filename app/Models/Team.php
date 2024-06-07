<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function getAllTeam(){
        $results = DB::table('equipes')->get();
        return $results;
    }
    public function getRunnerByTeam($idTeam){
        $result = DB::table('coureurs')->where('idequipe', $idTeam)->get();
        return $result;
    }

    public function getTeamByViewTeam($idequipe){
        $query = "select * from view_team_rank where equipe_id = ?";
        $result = DB::selectOne($query, [$idequipe]);
        return $result;
    }
}
