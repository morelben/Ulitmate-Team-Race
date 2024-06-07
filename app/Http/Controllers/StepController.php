<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StepController extends Controller
{
    public function indexTeam(){
        $steps = DB::table('etapes')->paginate(4);
        return view('pages.welcome.indexTeam',[
            'steps' => $steps
        ]);
    }

    public function indexAdmin(){
        $steps = DB::table('etapes')->paginate(4);
        return view('pages.welcome.indexAdmin',[
            'steps' => $steps
        ]);
    }

    public function insertStepRunner(Request $request)
    {
        $step_id = $request->input('step_id');
        $step = DB::table('etapes')->find($step_id);

        $runners = $request->input('coureur', []);
//        dd($runners);
        if (count($runners) > $step->nbrcoureur) {
            return  redirect()->back()->with('error','The number of selected runners does not match the required number for this step.');
        }

        $errors = [];
        foreach ($runners as $runnerId) {
            $existingAssignment = DB::table('etape_coureur')
                ->where('idetape', $step_id)
                ->where('idcoureur', $runnerId)
                ->first();

            if ($existingAssignment) {
                $runner = DB::table('coureurs')->find($runnerId);
                $errors[] = "The runner {$runner->nomcoureur} is already assigned to this step.";
            }
        }

        if (count($errors) > 0) {
            return redirect()->back()->withErrors($errors);
        }

        foreach ($runners as $runnerId) {
            DB::table('etape_coureur')->insert([
                'idetape' => $step->id,
                'idcoureur' => $runnerId
            ]);
        }

        return redirect()->back()->with('success', 'The runners have been successfully registered.');
    }

    public function RunnerByIdStep($idStep){
        $step = new Step();
        $runners = $step->getRunnerById($idStep);
        $getStep = $step->getSetpById($idStep);
        $step_id = $getStep->id;
//        dd($runners);
        return view('pages.admin.affectationTempsCoureur',[
            'runners' => $runners,
            'step_id' => $step_id
        ]);
    }

    public function searchMultiMot(Request $request){
        $keywords = $request->input('mot');
        $results = DB::table('etapes')
            ->where('nometape', 'ILIKE' , '%' . $keywords . '%')
            ->orWhere('longueur', 'ILIKE' , '%' . $keywords . '%')
            ->paginate(2);
        return view('pages.welcome.indexAdmin', [
            'steps' => $results,
        ]);
    }

    public function searchMultiMotTeam(Request $request){
        $keywords = $request->input('mot');
        $results = DB::table('etapes')
            ->where('nometape', 'ILIKE' , '%' . $keywords . '%')
            ->orWhere('longueur', 'ILIKE' , '%' . $keywords . '%')
            ->paginate(2);
        return view('pages.welcome.indexTeam', [
            'steps' => $results,
        ]);
    }

    public function insertStep(Request $request)
    {
        $request->validate([
            'number_step' => 'required|gte:0',
            'name_step' => 'required|max:255',
            'length_step' => 'required|gte:0',
            'number_runner' => 'required|gte:0',
            'departure_time' => 'required',
            'depart_hh' => 'required|numeric|between:0,23|gte:0',
            'depart_mm' => 'required|numeric|between:0,59|gte:0',
            'depart_ss' => 'required|numeric|between:0,59|gte:0',
        ], [
            'number_step.required' => 'The step number is required.',
            'number_step.gte' => 'The step number must not be a negative value.',
            'name_step.required' => 'The step name is required.',
            'name_step.max' => 'The step name may not be greater than 255 characters.',
            'length_step.required' => 'The step length is required.',
            'length_step.gte' => 'The step length must not be a negative value.',
            'number_runner.required' => 'The number of runners is required.',
            'number_runner.gte' => 'The number of runners must not be a negative value.',
            'departure_time.required' => 'The departure time is required.',
            'depart_hh.required' => 'The departure hour is required.',
            'depart_hh.numeric' => 'The departure hour must be a number.',
            'depart_hh.between' => 'The departure hour must be between 0 and 23.',
            'depart_hh.gte' => 'The departure hour must not be a negative value.',
            'depart_mm.required' => 'The departure minute is required.',
            'depart_mm.numeric' => 'The departure minute must be a number.',
            'depart_mm.between' => 'The departure minute must be between 0 and 59.',
            'depart_mm.gte' => 'The departure minute must not be a negative value.',
            'depart_ss.required' => 'The departure second is required.',
            'depart_ss.numeric' => 'The departure second must be a number.',
            'depart_ss.between' => 'The departure second must be between 0 and 59.',
            'depart_ss.gte' => 'The departure second must not be a negative value.',
        ]);

        $number_step = $request->input('number_step');
        $name_step = $request->input('name_step');
        $length_step = $request->input('length_step');
        $number_runner = $request->input('number_runner');
        $departure_time = Carbon::createFromFormat('Y-m-d',$request->departure_time);
        $departure_time->setTime($request->depart_hh,$request->depart_mm,$request->depart_ss);
//        dd($departure_time);
        DB::table('etapes')->insert([
            'nometape' => $name_step,
            'longueur' => $length_step,
            'nbrcoureur' => $number_runner,
            'rang' => $number_step,
            'date_depart' => $departure_time
        ]);
        return redirect()->route('indexAdmin')->with('success', 'Step saved successfully.');
    }

    public function editStep(Request $request)
    {
        $request->validate([
            'number_step_edit' => 'required|gte:0',
            'name_step_edit' => 'required|max:255',
            'length_step_edit' => 'required|gte:0',
            'number_runner_edit' => 'required|gte:0'
        ], [
            'number_step_edit.required' => 'The step number is required.',
            'number_step_edit.gte' => 'The step number must not be a negative value.',
            'name_step_edit.required' => 'The step name is required.',
            'name_step_edit.max' => 'The step name may not be greater than 255 characters.',
            'length_step_edit.required' => 'The step length is required.',
            'length_step_edit.gte' => 'The step length must not be a negative value.',
            'number_runner_edit.required' => 'The number of runners is required.',
            'number_runner_edit.gte' => 'The number of runners must not be a negative value.'
        ]);

        $step_id = $request->input('step_id');

        DB::table('etapes')
        ->where('id', $step_id)
        ->update([
            'rang' => $request->input('number_step_edit'),
            'nometape' => $request->input('name_step_edit'),
            'longueur' => $request->input('length_step_edit'),
            'nbrcoureur' => $request->input('number_runner_edit')
        ]);
        return redirect()->route('indexAdmin')->with('success', 'Step updated  successfully.');
    }

    public function insertTimeRunner(Request $request){
        $request->validate([
            'temps_arriver' => 'required',
            'arrive_hh' => 'required|numeric|between:0,23|gte:0',
            'arrive_mm' => 'required|numeric|between:0,59|gte:0',
            'arrive_ss' => 'required|numeric|between:0,59|gte:0',
            'penalite' => 'required|numeric|gte:0'
        ], [
            'temps_arriver.required' => 'The time to arrive is required.',
            'arrive_hh.required' => 'The departure hour is required.',
            'arrive_hh.numeric' => 'The departure hour must be a number.',
            'arrive_hh.between' => 'The departure hour must be between 0 and 23.',
            'arrive_hh.gte' => 'The departure hour must not be a negative value.',
            'arrive_mm.required' => 'The departure minute is required.',
            'arrive_mm.numeric' => 'The departure minute must be a number.',
            'depart_mm.between' => 'The departure minute must be between 0 and 59.',
            'depart_mm.gte' => 'The departure minute must not be a negative value.',
            'arrive_ss.required' => 'The departure second is required.',
            'arrive_ss.numeric' => 'The departure second must be a number.',
            'arrive_ss.between' => 'The departure second must be between 0 and 59.',
            'arrive_ss.gte' => 'The departure second must not be a negative value.',
            'penalite.required' => 'The penalty is required.',
            'penalite.numeric' => 'The penalty must be a number.',
            'penalite.gte' => 'The penalty must not be a negative value.',

        ]);

        $step_id = $request->input('step_id');
        $step = new Step();
        $date_depart = $step->getDepartStepById($step_id);
//        dd($date_depart);
        $date_arrive = $request->input('temps_arriver');
        $arrive_hh = $request->input('arrive_hh');
        $arrive_mm = $request->input('arrive_mm');
        $arrive_ss = $request->input('arrive_ss');
        $idCoureur = $request->input('runner');
        $penality = $request->input('penalite');

        $date_arrive = Carbon::createFromFormat('Y-m-d',$date_arrive);
        $date_arrive->setTime($arrive_hh,$arrive_mm,$arrive_ss);
//        dd([$date_depart,$date_arrive]);
        DB::table('temps_coureur_etape')->insert([
            'idetape' => $step_id,
           'idcoureur' => $idCoureur,
            'heure_depart' => $date_depart,
            'heure_arriver' => $date_arrive,
            'penalite' => $penality
        ]);
        return redirect()->route('indexAdmin')->with('success', 'Time runner saved successfully.');

    }
}
