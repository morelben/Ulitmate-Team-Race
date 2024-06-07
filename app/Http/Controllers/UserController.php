<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login()
    {
        return(view('index'));
    }

    public function register()
    {
        return(view('register'));
    }

    public function insertTeam(Request $request)
    {
        $request->validate([
            'nameTeam' => 'required|max:255',
            'emailTeam' => 'required|unique:users,email',
            'pwdTeam' => 'required|min:8',
        ],[
            'nameTeam.required' => 'The name field is required.',
            'nameTeam.max' => 'The name may not be greater than 255 characters.',

            'emailTeam.required' => 'The email field is required.',
            'emailTeam.unique' => 'The email has already been taken.',

            'pwdTeam.required' => 'The password field is required.',
            'pwdTeam.min' => 'The password must be at least 8 characters.',
        ]);

        DB::table('equipes')->insert([
            'nomequipe' => $request->input('nameTeam'),
            'email' => $request->input('emailTeam'),
            'password' => Hash::make($request->input('pwdTeam')),
        ]);

        return redirect()->intended(route('login'))->with('success', 'Your Team account has been successfully created. Please log in');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $email = $request->input('email');
        $pwd = $request->input('password');

        $admin = DB::table('admin')->where('email', $email)->first();
        if ($admin && Hash::check($pwd, $admin->password)) {
            $request->session()->regenerate();
            Session::put('idadmin', $admin->id);
            Session::put('nameadmin', $admin->nomadmin);
            return redirect()->intended('/indexAdmin');
        }

        $equipe = DB::table('equipes')->where('email', $email)->first();
        if ($equipe && Hash::check($pwd, $equipe->password)) {
            $request->session()->regenerate();
            Session::put('idequipe', $equipe->id);
              Session::put('nameequipe', $equipe->nomequipe);
            return redirect()->intended('indexTeam');
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
                'password' => 'The provided credentials do not match our records.'
            ])
            ->onlyInput('email', 'password');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }

    public function trun(){
        $tables = Schema::getAllTables();
        DB::statement('SET session_replication_role =replica');
        DB::beginTransaction();

        try{
            foreach ($tables as $table){
                DB::table($table->tablename)->truncate();
            }
            DB::commit();
        }catch (\Exception $e){

        } finally {
            DB::statement('SET session_replication_role = DEFAULT');
            Admin::create([
                'nomadmin' => 'Administrateur',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('mdpadmin02')
            ]);

            return redirect()->route('login');
        }
    }
}
