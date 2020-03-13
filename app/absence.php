<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absence extends Model
{
    //

    // public function nrAusenciasUserLogado($idUser) {
    //     $ausenciasDoUser = absence::where('iduser','=', $idUser)
    //            ->where('absenceType', '!=' , 1)
    //            ->where('status', '=' , 'Concluded')
    //            ->select('*')
    //            ->get();

    //     $diasAusencia = 0;

    //     for($i = 0; $i < count($ausenciasDoUser); $i++) {
    //         $beginning = $ausenciasDoUser[$i]->start_date;
    //         $ending = $ausenciasDoUser[$i]->end_date;
    //         $date1=date_create($beginning);
    //         $date2=date_create($ending);
    //         $diff=date_diff($date1,$date2);
    //         $days = $diff->format("%d%");
    //         $diasAusencia += $days; 
    //     }



    //     return $diasAusencia;
    // }


}
