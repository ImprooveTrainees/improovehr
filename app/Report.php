<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //

    public function absencesFiltered() {


        $absencesFiltered = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->join('absence_types', 'absence_types.id', '=', 'absences.absencetype')
        ->select('absences.*','users.id','users.name','absence_types.id','absence_types.description')
        ->get();

        return $absencesFiltered;

    }

}
