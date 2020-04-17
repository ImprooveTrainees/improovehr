<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subCategories extends Model
{
    //
    protected $table = 'sub_categories';
    protected $primaryKey = 'id';

    public function questions()
    {
        return $this->hasMany('App\Questions', 'idSubcat', 'id');
    }
}
