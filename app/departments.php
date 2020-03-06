<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class departments extends Model
{
    //
    protected $table = 'departments';
    protected $primaryKey = 'id';

    function offices() {
        return $this->belongsToMany('App\offices','offices_deps','idOffice','idDepartment');
    }
    public function user() {
        return $this->belongsToMany('App\users','users_deps', 'idDepartment', 'id');
      }

}
