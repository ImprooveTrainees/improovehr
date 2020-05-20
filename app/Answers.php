<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    //
    protected $table = 'answers';
    protected $primaryKey = 'idAnswer';

    public function questSurveys() {
        return $this->belongsTo('App\questSurvey', 'idQuestSurvey');
    } 
}
