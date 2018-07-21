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

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'photo_url', 'description', 'recruiting'];


}
