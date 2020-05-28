<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //

    public function allAbsences() {


        $allAbsences = DB::table('absences')
        ->join('absence_types', 'absence_types.id', '=', 'absences.absencetype')
        ->select('absences.*','absence_types.description as description')
        ->get();

        return $allAbsences;

    }

}
