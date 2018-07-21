<?php

namespace App\Http\Controllers\TeamManager;

use App\Http\Requests\StoreTeam;
use App\Http\Controllers\Controller;
use App\Team;

/**
 * @author Isaac Buitrago
 * Class TeamController
 * @package App\Http\Controllers\TeamManager
 */
class TeamController extends Controller
{

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

        if(!empty($request->file('team_logo')))
        {
            // store the image and store it's path

            $team->photo_url = $request->file('team_logo')->store('team_logos');

        }

        $team->save();

        return (response()->json(["Team $team->name created"]));
    }
}
