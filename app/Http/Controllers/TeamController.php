<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Models\Team;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{
    public function RunnerByTeam(Request $request){
        $idTeam = Session::get('idequipe');
        $team = new Team();
        $allRunner = $team->getRunnerByTeam($idTeam);
        $stepId = $request->query('step_id');
        $step = new Step();
        $stepById = $step->getSetpById($stepId);
        return view('pages.team.affectationCoureur',[
            'runners' => $allRunner,
            'step' => $stepById,
            'step_id' => $stepId
        ]);
    }

    public function getChronoRunnerById(Request $request){
        $etape_id = $request->input('step_id');
        $name_equipe = $request->input('nameequipe');
        $equipe_id = $request->input('idequipe');

        $step = new Step();
        $stepById = $step->getSetpById($etape_id);

        $chronos = DB::table('view_coureur_rank_point')
            ->where('etape_id', $etape_id)
            ->where('equipe_id', $equipe_id)
            ->paginate(6);

        return view('pages.team.listChronoRunner',[
            'chronos' => $chronos,
            'etape_id' => $etape_id,
            'equipe_id' => $equipe_id,
            'name_equipe' => $name_equipe,
            'step' => $stepById
        ]);
    }

    public function getAllPenality(){
        $equipes = DB::table('equipes')->get();
        $etapes = DB::table('etapes')->get();
        $allpenality = DB::table('view_equipe_penalite')->where('etat','=','0')->get();

        return view('pages.admin.gestionPenalite',[
            'penalites' => $allpenality,
            'etapes' => $etapes,
            'equipes' => $equipes
        ]);
    }

    public function insertPenality(Request $request){
        $request->validate([
            'penalite' => 'required|date_format:H:i:s',

        ], [
            'penalite.required' => 'The penality time field is required.',
            'penalite.date_format' => 'The penality time must be in the format HH:MM:SS',
        ]);

        $etape = $request->input('etape');
        $equipe = $request->input('equipe');
        $penalite = $request->input('penalite');

        DB::table('equipe_penalite')->insert([
            'idetape' => $etape,
            'idequipe' => $equipe,
            'temp_penalite' => $penalite,
            'etat' => 0
        ]);
        return redirect()->route('penalityList')->with('success', 'Penality created successfully.');
    }

    public function destroyPenality(Request $request){
        $idEP = $request->input('idEP');
        DB::table('equipe_penalite')
            ->where('id', $idEP)
            ->delete();
        return redirect()->route('penalityList')->with('success', 'Penality deleted successfully.');
    }


    public  function  exportPDF(){
        $resultat = Session::get('resultat');

        $pdf = Pdf::loadView('pages.pdf.certificationEquipe',[
            'equipe' => $resultat[0]
        ]);
        return $pdf->download('RunningChamps.pdf');
//            return view('pages.pdf.certificationEquipe');
    }
}
