<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Captain extends Model implements Authenticatable
{
    //

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];


    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */

    protected $hidden = ['password', 'remember_token'];


    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return('id');
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return($this->id);
    }

    /**
     * Captain will not return a password
     * @return string
     */
    public function getAuthPassword()
    {
        return(null);
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return($this->remember_token);
    }

    /**
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $this->remember_token =  $value;

        $this->save();
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return('remember_token');
    }
}
