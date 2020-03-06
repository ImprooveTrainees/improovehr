<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class offices extends Model
{
    protected $table = 'offices';
    protected $primaryKey = 'id';

    function departments() {
        return $this->belongsToMany('App\departments','offices_deps','idDepartment', 'idOffice');
    }

}
