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
      public function officeDescricao($id, $country) {
        $officeDescricao = DB::table('users')
            ->join('users_deps', 'users.id', '=', 'users_deps.idUser')
            ->join('offices_deps', 'users_deps.idDepartment', '=', 'offices_deps.idDepartment')
            ->join('offices', 'offices_deps.idOffice', '=', 'offices.id')
            ->where('users.id','=',$id)
            ->where('offices.country','=', $country)
            ->select('offices.description')
            ->value('description');

        return $officeDescricao;
     }
      public function managerDoUser($depart, $country) {


            // select users.name
            // from  users, departments, users_deps,contracts
            // where users.id=users_deps.idUser
            // and users_deps.idDepartment=departments.id
            // and contracts.iduser=users.id
            // and contracts.position="Manager"
            // and users_deps.idDepartment
            // in(
            // select users_deps.idDepartment from users_deps where users_deps.iduser = 2);


            $manager = DB::table('users')
            ->join('users_deps', 'users.id', '=', 'users_deps.idUser')
            ->join('departments', 'users_deps.idDepartment', '=', 'departments.id')
            ->join('contracts', 'contracts.iduser', '=', 'users.id')
            ->join('offices_deps', 'users_deps.idDepartment', '=', 'offices_deps.idDepartment')
            ->join('offices', 'offices_deps.idOffice', '=', 'offices.id')
            ->where('contracts.position','=', 'Manager')
            ->where('departments.description', '=', $depart)
            ->where('offices.country', '=', $country)
            ->where('users.country', '=', $country)
            ->select('users.name')
            ->groupBy('offices.description')
            ->value('name');



        return $manager;
     }


    public function userAbsence() {

        $userAbsence = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->select('absences.*','users.name as user_name','users.photo as user_photo')
        ->get();

        return $userAbsence;

    }

    public function listVacations() {

        $listVacations = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->join('contracts', 'contracts.iduser', '=', 'users.id')
        ->where('absences.absencetype','=',1)
        ->select('absences.*','users.name as user_name','contracts.position as position')
        ->get();

        return $listVacations;

    }

    public function listAbsences() {

        $listAbsences = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->join('absence_types', 'absence_types.id', '=', 'absences.absencetype')
        ->where('absences.absencetype','>',1)
        ->select('absences.*','users.name as user_name','absence_types.description as description')
        ->get();

        return $listAbsences;

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

        return $listAbsencesUserCY;

    }

    public function listAbsencesUserLY($id) {

        //LAST YEAR
        $dateBegin = date('Y-01-01', strtotime('- 1 year'));
        $dateEnd = date('Y-12-31', strtotime('- 1 year'));

        $listAbsencesUserLY = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->where('users.id','=',$id)
        ->where('absences.absencetype','=',1)
        ->where('absences.status','like','Concluded')
        ->where('absences.end_date','>=',$dateBegin)
        ->where('absences.end_date','<=',$dateEnd)
        ->select('absences.*')
        ->get();

        return $listAbsencesUserLY;

    }



}
