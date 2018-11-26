<?php

namespace App\Http\Controllers\TeamManager;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeam;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Team;


/**
 * @author Isaac Buitrago
 * Class TeamController
 * @package App\Http\Controllers\TeamManager
 */
class TeamController extends Controller
{

    /**
     * The current team
     * @var Team
     */
    private $team;

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team): void
    {
        $this->team = $team;
    }

    /**
     * @param StoreTeam $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTeam(StoreTeam $request)
    {
        //TODO make sure the error response is react compatible

        //validate the data entering the request

        $validData = $request->validated();

        // store the team in the database

        $team = new Team();

        $team->name = $validData['name'];

        $team->description = $validData['description'];

        $team->recruiting =  $validData['recruiting'];

        $team->save();

        return (response()->json(["Team $team->name created"]));
    }

    /**
     * Used to set the logo for a team, if no image is provided a default logo is utilized.
     * The precondition is that the team is not null
     * @param Request $request
     */
    public function setLogo(Request $request)
    {

        if($request->hasFile('team_logo'))
        {
            // validate the file and store it

            // TODO system should run at lower privilege at this point

            $validator = Validator::make($request->all(), [
                'team_logo' => 'nullable|file|image|mimes:bmp,gif,jpeg,jpg,jif,jfif,png,svg,tiff,tif|max:10000'
            ]);

            if($validator->fails())
            {
                return (response()->json(['invalid file']));
            }

            $this->team->photo_url = $request->file('team_logo')->store('team_logos');
        }

        else
        {

            $this->team->photo_url = env('DEFAULT_TEAM_LOGO');
        }

        $this->team->save();

        return(response()->json(["logo set"]));
    }

    /**
     * Used to retrieve the set of teams for the current authenticted users
     * @param Request $request
     */
    public function getTeams(Request $request)
    {
        $captain = Auth::user();

        $teams = Team::where('captain_id', '=', $captain->getAuthIdentifier())->get(

            ['id','name','description','recruiting','created_at','updated_at']);

        return(response()->json($teams));
    }
}
