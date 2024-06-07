<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\Step;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RankingController extends Controller
{
    public function indexRankingStep(){
        $step = new Step();
        $steps = $step->getAllStep();

        return view('pages.admin.classementGEtape',[
            'steps' => $steps,
        ]);
    }

    public function showRankingByStep(Request $request){
        $step_id = $request->input('step');
        $rankingG =  DB::table('view_coureur_rank_point')->where('etape_id',$step_id)->paginate(5);
//        dd($rankingG);

        return view('pages.admin.showClassementByStep',[
            'rankings' => $rankingG,
            'etape_id' => $step_id
        ]);
    }

    public function  RankingTeam(Request $request){
        $rankingG =  DB::table('view_team_rank')->get();
        Session::put('resultat',$rankingG);
        $team = new Team();
        $teams = $team->getAllTeam();
        return view('pages.admin.classementGEquipe',[
            'teams' => $teams,
            'rankings' => $rankingG
        ]);
    }

    public function RankingElea(Request $request){
        $equipe = $request->input('idEquipe');
        $query = "
        SELECT pp.etape_id,pp.nom_etape ,sum(point_2) point_etape FROM
        (SELECT
             v.*,
             DENSE_RANK() OVER (ORDER BY v.temps_effectue  ASC) AS place_2,
             COALESCE(p.point_atribuer, 0) AS point_2
         FROM
             (SELECT
                  *,
                  DENSE_RANK() OVER (PARTITION BY etape_id  ORDER BY temps_effectue ASC) AS place_2
              FROM
                  view_coureur_rank_point vr
                      JOIN categorie_coureur cc on cc.idCoureur = vr.coureur_id
             ) v
                 LEFT JOIN
             parametre_point p
             ON
             v.place_2 = p.rang where equipe_id ='".$equipe."' ) pp  group by pp.etape_id,pp.nom_etape ;
        ";
        $rankingG = DB::select($query);

        return view('pages.admin.showClassementCoureurByStep',[
            'rankings' => $rankingG
        ]);
    }

    public function RankingTeamByCategorie(Request $request){
        $categorie = $request->input('categorie');

        if(strcmp($categorie,'M')  == 0 || strcmp($categorie,'F')  == 0){
            $query = "
            WITH equipe_points AS (
                SELECT
                    equipe_id,
                    ep.nomequipe,
                    SUM(point_2) AS total_point_obtenu
                FROM (
                         SELECT
                             v.*,
                             DENSE_RANK() OVER (ORDER BY v.temps_effectue ASC) AS place_2,
                             COALESCE(p.point_atribuer, 0) AS point_2
                         FROM
                             (SELECT
                                  *,
                                  DENSE_RANK() OVER (PARTITION BY etape_id, genre ORDER BY temps_effectue ASC) AS place_2
                              FROM
                                  view_coureur_rank
                              WHERE
                                  genre = ?
                             ) v
                         LEFT JOIN
                            parametre_point p
                         ON
                            v.place_2 = p.rang
                     ) AS subquery
                         JOIN
                     equipes ep ON ep.id = equipe_id
                GROUP BY
                    equipe_id, ep.nomequipe
            )
            SELECT
                equipe_id,
                nomequipe,
                total_point_obtenu,
                DENSE_RANK() OVER (ORDER BY total_point_obtenu DESC) AS rang_equipe
            FROM
                equipe_points
            ORDER BY
                rang_equipe;
        ";
            $rankingG = DB::select($query, [$categorie]);
            Session::put('resultat',$rankingG);
            return view('pages.admin.classementGEquipe',[
                'rankings' => $rankingG
            ]);
        }elseif (strcmp($categorie,'Junior')  == 0 || strcmp($categorie,'Senior')  == 0 ){
            $query = "
            WITH equipe_points AS (
                SELECT
                    equipe_id,
                    ep.nomequipe,
                    SUM(point_2) AS total_point_obtenu
                FROM (
                         SELECT
                             v.*,
                             DENSE_RANK() OVER (ORDER BY v.temps_effectue ASC) AS place_2,
                             COALESCE(p.point_atribuer, 0) AS point_2
                         FROM
                             (SELECT
                                  *,
                                  DENSE_RANK() OVER (PARTITION BY etape_id,categorie ORDER BY temps_effectue ASC) AS place_2
                              FROM
                                  view_coureur_rank
                              WHERE
                                  categorie = ?
                             ) v
                         LEFT JOIN
                            parametre_point p
                         ON
                            v.place_2 = p.rang
                     ) AS subquery
                         JOIN
                     equipes ep ON ep.id = equipe_id
                GROUP BY
                    equipe_id, ep.nomequipe
            )
            SELECT
                equipe_id,
                nomequipe,
                total_point_obtenu,
                DENSE_RANK() OVER (ORDER BY total_point_obtenu DESC) AS rang_equipe
            FROM
                equipe_points
            ORDER BY
                rang_equipe;
        ";
            $rankingG = DB::select($query, [$categorie]);

            Session::put('resultat',$rankingG);
            return view('pages.admin.classementGEquipe',[
                'rankings' => $rankingG
            ]);
        }
    }

    public function indexRankingStepTeam(){
        $step = new Step();
        $steps = $step->getAllStep();
        $rankingGByStep = DB::table('view_coureur_rank_point')->where('etape_id','ET192')->get();
        return view('pages.team.classementGEtape',[
            'steps' => $steps,
            'rankings' => $rankingGByStep
        ]);
    }
    public function  showRankingByStepTeam(Request $request){
        $step_id = $request->input('step');
        $rankingG =  DB::table('view_coureur_rank_point')->where('etape_id',$step_id)->get();
        $step = new Step();
        $steps = $step->getAllStep();
        return view('pages.team.classementGEtape',[
            'steps' => $steps,
            'rankings' => $rankingG,
        ]);
    }

    public function  RankingTeamTeam(Request $request){
        $rankingG =  DB::table('view_team_rank')->get();

        $team = new Team();
        $teams = $team->getAllTeam();
        return view('pages.team.classementGEquipe',[
            'teams' => $teams,
            'rankings' => $rankingG
        ]);
    }
}
