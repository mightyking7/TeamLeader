<?php

use App\Team;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Business email routes
 */
Route::post('/send', 'AccountManager\BusinessEmailController@sendVerificationEmail');

Route::post('/confirm', 'AccountManager\BusinessEmailController@verifyCaptainEmail');

/**
 * Team routes
 */

// TODO authenticate the user attempting to access this team
Route::post('/team', 'TeamManager\TeamController@createTeam');

Route::put('/teamlogo/{team}', function(Team $team, Request $request){

    $team->setLogoAdapter($request);
});


