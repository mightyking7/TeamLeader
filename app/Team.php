<?php

namespace App;

use App\Http\Controllers\TeamManager\TeamController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * @author Isaac Buitrago
 *
 * A Team can register members, store member information, accept polls, and create registration forms
 *
 * @package App
 */
class Team extends Model
{

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'photo_url', 'description', 'recruiting'];

    /**
     * Adapter for setting the logo on the current team
     * @param Request $request
     */
    public function setLogoAdapter(Request $request)
    {
        // controller for manipulating teams
        $controller = new TeamController();

        $controller->setTeam($this);

        // set the logo for this team
        $controller->setLogo($request);
    }

}
