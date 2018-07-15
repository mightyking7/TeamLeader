<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Isaac Buitrago
 *
 * A Team can register members, store member information, accept polls, and create registration forms
 *
 * @package App
 */
class Team extends Model
{
    private $name;         // Team name

    private $photoUrl;     // URL to team logo in the storage directory

    private $description;  // Description of Team's purpose and activities

    private $isRecruiting; // Boolean of whether the team is currently recruiting members

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'photoUrl', 'description', 'isRecruiting'];


}
