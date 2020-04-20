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

    public function surveyType()
    {
        return $this->belongsTo('App\surveyType', 'idSurveyType');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'survey_users', 'idSurvey', 'idUser');
    }

}
