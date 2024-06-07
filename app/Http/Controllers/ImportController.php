<?php

namespace App\Http\Controllers;

use App\Imports\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importStepsResults(Request $request){
        $fileSteps = Excel::toArray(new Import(),$request->file('file1'))[0];
//        dd($fileSteps);
        $rules = [
            'etape' => 'required',
            'longueur' =>'required',
            'nb_coureur' => 'required',
            'rang' =>'required',
            'date_depart' => 'required',
            'heure_depart' => 'required',
        ];

        $customMessages = [
            'etape.required' => 'L\'étape est obligatoire.',
            'longueur.required' => 'La longueur est obligatoire.',
            'nb_coureur.required' => 'Le nombre de coureurs est obligatoire.',
            'rang.required' => 'Le rang est obligatoire.',
            'date_depart.required' => 'La date de départ est obligatoire.',
            'heure_depart.required' => 'L\'heure de départ est obligatoire.',
        ];

        $erreur = [];
        $validation=[];
        $i=1;

        foreach ($fileSteps as $row){
            $validator = Validator::make($row, $rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                foreach ($errors as $error) {
                    $validation[]=$error .' (Ligne '.$i.')';
                }
            } else {
                try{
                    DB::table('csv_etape')->insert([
                        'etape' => $row['etape'],
                        'longueur' => str_replace(',','.',$row['longueur']),
                        'nbr_coureur' => $row['nb_coureur'],
                        'rang' => $row['rang'],
                        'date_depart' => $row['date_depart'],
                        'heure_depart' => $row['heure_depart']
                    ]);
                }catch(\Exception $e){
                    $erreur[]='Erreur a la ligne'.' '.$i.' : '.$row['etape'].','.$row['longueur'].','.$row['nb_coureur'].','.$row['rang'].','.$row['date_depart'].','.$row['heure_depart'];
                }
            }
            $i++;
        }

        try{
            DB::insert("
                INSERT INTO etapes (nometape, longueur, nbrcoureur, rang, date_depart)
                SELECT
                    etape AS nometape,
                    longueur,
                    nbr_coureur,
                    rang,
                    date_depart::date + heure_depart::time AS date_depart
                FROM
                    csv_etape;
            ");
        }catch(\Exception $e){
            $erreur[]=$e->getMessage();
        }

        $fileResults = Excel::toArray(new Import(),$request->file('file2'))[0];
//                dd($fileResults);
        $rules = [
            'etape_rang' => 'required',
            'numero_dossard' =>'required',
            'nom' => 'required',
            'genre' =>'required',
            'date_naissance' => 'required',
            'equipe' => 'required',
            'arrivee' => 'required'
        ];

        $customMessages = [
            'etape_rang.required' => 'L\'étape et le rang sont obligatoires.',
            'numero_dossard.required' => 'Le numéro de dossard est obligatoire.',
            'nom.required' => 'Le nom est obligatoire.',
            'genre.required' => 'Le genre est obligatoire.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'equipe.required' => 'L\'équipe est obligatoire.',
            'arrivee.required' => 'L\'heure d\'arrivée est obligatoire.'
        ];

        $erreur = [];
        $validation=[];
        $i=1;

        foreach ($fileResults as $row){
            $validator = Validator::make($row, $rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                foreach ($errors as $error) {
                    $validation[]=$error .' (Ligne '.$i.')';
                }
            } else {
                try{
                    DB::table('csv_resultat')->insert([
                        'etape_rang' => $row['etape_rang'],
                        'numero_dossard' => $row['numero_dossard'],
                        'nom' => $row['nom'],
                        'genre' => $row['genre'],
                        'date_naissance' => $row['date_naissance'],
                        'equipe' => $row['equipe'],
                        'arrivee' => $row['arrivee']
                    ]);
                }catch(\Exception $e){
                    $erreur[]='Erreur a la ligne'.' '.$i.' : '.$row['etape_rang'].','.$row['numero_dossard'].','.$row['nom'].','.$row['genre'].','.$row['date_naissance'].','.$row['equipe'].','.$row['arrivee'];
                }
            }
            $i++;
        }
        $equipes = DB::table('csv_resultat')->select('equipe')->distinct()->pluck('equipe');

        foreach ($equipes as $equipe) {
            $email = 'equipe' . ucfirst(strtolower($equipe)) . '@gmail.com';
            $password = 'mdpequipe' . ucfirst(strtolower($equipe)) . '02';
            $hashedPassword = Hash::make($password);
            try {
                DB::table('equipes')->insert([
                    'nomequipe' => $equipe,
                    'email' => $email,
                    'password' => $hashedPassword,
                ]);
            } catch (\Exception $e) {
                $erreur[] = $e->getMessage();
            }
        }

        try {
            DB::insert("
                INSERT INTO coureurs (nomcoureur,numero_dossard,genre,date_naissance,idequipe)
                SELECT
                    nom,
                    numero_dossard,
                    genre,
                    date_naissance,
                    e.id
                FROM
                    csv_resultat cr
                JOIN
                    equipes e ON cr.equipe = e.nomEquipe
                GROUP BY
                    nom,numero_dossard, date_naissance,genre,e.id
            ");
        } catch (\Exception $e) {
            $erreur[] = $e->getMessage();
        }

        try {
            DB::insert("
                INSERT INTO temps_coureur_etape (idetape,idcoureur,heure_depart,heure_arriver)
                SELECT
                    e.id as etape_id,
                    c.id as coureur_id,
                    e.date_depart,
                    arrivee as date_arrive
                FROM
                    csv_resultat cr
                JOIN
                    coureurs c on cr.numero_dossard = c.numero_dossard
                JOIN
                    etapes e on cr.etape_rang = e.rang;
            ");
        } catch (\Exception $e) {
            $erreur[] = $e->getMessage();
        }

        try {
            DB::insert("
                INSERT INTO etape_coureur (idetape,idcoureur)
                SELECT
                    e.id as etape_id,
                    c.id as coureur_id
                FROM
                    csv_resultat cr
                JOIN
                    coureurs c on cr.numero_dossard = c.numero_dossard
                JOIN
                    etapes e on cr.etape_rang = e.rang;
            ");
        } catch (\Exception $e) {
            $erreur[] = $e->getMessage();
        }

        return view('pages.admin.importDonne',[
            'validation' => $validation,
            'erreur' => $erreur,
        ]);
    }

    public function importPoint(Request $request){
        $filePoint = Excel::toArray(new Import(),$request->file('file'))[0];
//        dd($filePoint);
        $rules = [
            'classement' => 'required',
            'points' =>'required',
        ];

        $customMessages = [
            'classement.required' => 'Le classemeent est obligatoire.',
            'points.required' => 'Le point est obligatoire.',
        ];

        $erreur = [];
        $validation=[];
        $i=1;

        foreach ($filePoint as $row){
            $validator = Validator::make($row, $rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                foreach ($errors as $error) {
                    $validation[]=$error .' (Ligne '.$i.')';
                }
            } else {
                try{
                    DB::table('csv_point')->insert([
                        'classement' => $row['classement'],
                        'points' => $row['points'],
                    ]);
                }catch(\Exception $e){
                    $erreur[]='Erreur a la ligne'.' '.$i.' : '.$row['classement'].','.$row['points'];
                }
            }
            $i++;
        }

        try {
            DB::insert("
                INSERT INTO parametre_point (rang,point_atribuer)
                SELECT
                   classement,
                   points
                FROM
                    csv_point
            ");
        } catch (\Exception $e) {
            $erreur[] = $e->getMessage();
        }

        return view('pages.admin.importPoint',[
            'validation' => $validation,
            'erreur' => $erreur,
        ]);

    }
}
