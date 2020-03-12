<?php

namespace App;
use App\UserType;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use DB;

use Carbon;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';
    protected $primaryKey = 'id';

    public function UserContract() {
        return $this->hasOne('App\contract', 'iduser', 'id');
      }
    public function roles() {

        // $userid = Auth::id();

        // $type = UserType::select('id')->where('description',$role)->get();

        // return User::where('idtypeuser', $type)->where('id', $userid)->get();

        return $this->hasOne('App\UserType','id','idusertype');

    }

      public function contractUser() {
        return $this->hasOne('App\contract', 'iduser', 'id');
      }
      public function departments() {
         return $this->belongsToMany('App\departments','users_deps', 'idUser', 'idDepartment');
      }
      public function officeDescricao($id) {
        $officeDescricao = DB::table('users')
            ->join('users_deps', 'users.id', '=', 'users_deps.idUser')
            ->join('offices_deps', 'users_deps.idDepartment', '=', 'offices_deps.idDepartment')
            ->join('offices', 'offices_deps.idOffice', '=', 'offices.id')
            ->where('users.id','=',$id)
            ->select('offices.description')
            ->get();

        return $officeDescricao;
     }
      public function managerDoUser($id) {
        $manager = DB::table('users')
            ->join('users_deps', 'users.id', '=', 'users_deps.idUser')
            ->join('departments', 'users_deps.idDepartment', '=', 'departments.id')
            ->join('contracts', 'users.id', '=', 'contracts.iduser')
            ->where('users.id','=',$id)
            ->select('users.name')
            ->get();

        return $manager;
     }


    public function userAbsence() {

        $userAbsence = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->select('absences.*','users.name as user_name','users.photo as user_photo')
        ->get();

        return $userAbsence;

    }

    public function listAbsencesUserCY($id) {

        //CURRENT YEAR
        $current_date = date("Y/01/01");

        $listAbsencesUserCY = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->where('users.id','=',$id)
        ->where('absences.absencetype','=',1)
        ->where('absences.status','like','Concluded')
        ->where('absences.end_date','>=',$current_date)
        ->select('absences.*')
        ->get();

        // Articles::whereBetween('created_at', [
        //     Carbon::now()->startOfYear(),
        //     Carbon::now()->endOfYear(),
        // ]);



        return $listAbsencesUserCY;

    }

    public function listAbsencesUserLY($id) {

        //LAST YEAR
        //$current_date = date("Y/01/01");

        $listAbsencesUserLY = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->where('users.id','=',$id)
        ->where('absences.absencetype','=',1)
        ->where('absences.status','like','Concluded')
        ->where('absences.end_date','>=','2019-01-01 00:00:00')
        ->where('absences.end_date','<=','2019-12-31 23:59:59')
        ->select('absences.*')
        ->get();

        return $listAbsencesUserLY;

    }



}
