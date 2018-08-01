<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Team;

class HomeController extends Controller
{

    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retrieves the current set of teams
     * for the authenticated user and
     * shows the application dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $captain = Auth::user();

        $teams = Team::where('captain_id', '=', $captain->getAuthIdentifier())->get(

            ['id','name','description','recruiting','created_at','updated_at']);

        return(view('dashboard', [$teams->toJson()] ));
    }
}
