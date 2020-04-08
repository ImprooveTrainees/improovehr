<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    protected $table = 'surveys';
    protected $primaryKey = 'id';

    public function areas()
    {
        return $this->belongsToMany('App\Areas', 'areas_quest_connects', 'idSurvey', 'idArea');
    }

}
