<?php
/**
 * Created by PhpStorm.
 * User: isaacbuitrago
 * Date: 7/19/18
 * Time: 11:07 PM
 */

namespace Tests\Unit;

use App\Http\Requests\StoreTeam;
use Illuminate\Http\Request;
use Tests\TestCase;
use Faker\Factory as Faker;


class TeamControllerTest extends TestCase
{

    /**
     *
     * @test
     */
    public function testCreateTeamTest()
    {
        $data = Faker::create();

        $team = ['name'=> $data->name, 'description'=> $data->text(200), 'recruited'=> "$data->boolean(50)"];

        $response = $this->post('/team', $team);

        $this->assertEquals(200, $response->status());

    }



}
