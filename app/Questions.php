<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    //
    protected $table = 'questions';
    protected $primaryKey = 'id';

    public function questSurveys()
    {
        return $this->hasMany('App\questSurvey', 'idQuestion');
    }
}
