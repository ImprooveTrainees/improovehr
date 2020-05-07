<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class questSurvey extends Model
{
    //
    protected $table = 'quest_surveys';
    protected $primaryKey = 'id';

    public function questions()
    {
        return $this->belongsTo('App\Questions', 'idQuestion', 'id');
    }
}
