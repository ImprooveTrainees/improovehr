<?php

namespace App\Http\Controllers;

use App\absence;
use App\notifications;
use App\NotificationsUsers;
use App\User;
use App\notifications_reminders;
use App\settings_general;
use App\users_flextime;
use App\settings_extradays;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\sliderView;
use Redirect,Response;
use Carbon\Carbon;

require '../vendor/autoload.php';
use \Mailjet\Resources;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $user = Auth::user();

        $id_user= Auth::user()->id;

        $id_typeuser = $user->roles->id;

        $notification = new notifications();

        $notif_user = new NotificationsUsers();

        $allNotifications = notifications::all();

        $allNotificationUsers = NotificationsUsers::all();

        //$listAbsencesConcluded = $user->userAbsence();

        //DB::table('absences')->where(['status','=','Approved'],['end_date','<',$present_date])->update(['status' => 'Concluded']);

        $present_date = Carbon::now();

        $allAbsences = absence::All();

        foreach($allAbsences as $ab) {

            if($present_date>$ab->end_date && $ab->status=="Approved") {

                $ab->status="Concluded";
                $ab->save();

            }

        }

        // ROLE OF AUTHENTICATED USER

        $roleuser = DB::table('users')
        ->where('users.id','=',$id_user)
        ->select('users.idusertype')->value('idusertype');

        $countryUser = DB::table('users')
        ->where('users.id','=',$id_user)
        ->select('users.country')
        ->value('country');


        $listVacationsTotal = DB::table('users')->join('absences','absences.iduser','=','users.id')
        ->join('absence_types','absence_types.id','=','absences.absencetype')
        ->join('users_deps','users_deps.idUser','=','users.id')
        ->join('departments','departments.id','=','users_deps.idDepartment')
        ->select('users.id','users.name','absence_types.description','absences.id as absencedId','absences.status','absences.attachment','absences.start_date as start_date','absences.end_date as end_date','departments.description as depDescription')
        ->where('users.id','!=','1')
        ->where('users.country','like', $countryUser)
        ->where('absence_types.id','=','1')->get();


        $listAbsencesTotal = DB::table('users')->join('absences','absences.iduser','=','users.id')
        ->join('absence_types','absence_types.id','=','absences.absencetype')
        ->join('users_deps','users_deps.idUser','=','users.id')
        ->join('departments','departments.id','=','users_deps.idDepartment')
        ->select('users.*','absence_types.description','absences.id as absencedId','absences.status','absences.attachment','absences.start_date as start_date','absences.end_date as end_date','departments.description as depDescription')
        ->where('users.id','!=','1')
        ->where('users.country','like', $countryUser)
        ->where('absence_types.id','>','1')->get();

        $absence = absence::select('id','absencetype','status','end_date','start_date','motive','attachment')->where('iduser', $id_user)->orderBy('start_date','desc')->get();

        $array_vacations = array();

        $array_absences = array();

        foreach($absence as $abs) {

            if($abs->absencetype==1) {

            //LIST - VACATIONS FROM AUTHENTICATED USER

            $id = $abs->id;

            $start = $abs->start_date;

            $end = $abs->end_date;

            $stat = $abs->status;


            $start = substr($start, 0,-9);
            $end = substr($end, 0,-9);

            array_push($array_vacations, $id, $start, $end, $stat);

            } else {

                //LIST - ABSENCES FROM AUTHENTICATED USER

                $id = $abs->id;

                $start = $abs->start_date;

                $end = $abs->end_date;

                $stat = $abs->status;

                $motive = $abs->motive;

                $attachment = $abs->attachment;

                $absence_type = $abs->absencetype;

                array_push($array_absences,$id,$start,$end,$stat,$attachment,$motive,$absence_type);

            }


        }

        //$mssg = is('Admin');


        //$status = DB::table('absences')->where('iduser', $userid)->value('status');
        //$end_date = DB::table('absences')->where('iduser', $userid)->value('end_date');
        //$start_date = DB::table('absences')->where('iduser', $userid)->value('start_date');



        $vacation_days_available = $request->session()->get('vacationDays');

        return view('holidays',compact('user','array_vacations','array_absences','listVacationsTotal','listAbsencesTotal', 'vacation_days_available','roleuser'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $user = Auth::user();
        $userid = Auth::id();

        $allAbsences = absence::All();

        $vacationsAlready = false;
        $absencesAlready = false;
        $vacationStartonHoliday = false;
        $absenceStartonHoliday = false;

        $username = DB::table('users')
        ->where('users.id','=',$userid)
        ->select('users.name')
        ->value('name');

        $countryUser = DB::table('users')
        ->where('users.id','=',$userid)
        ->select('users.country')
        ->value('country');

        $managerId = DB::table('users')->where('users.idusertype','=',2)->where('users.country','like',$countryUser)
        ->select('users.id')->value('id');

        $roleuser = DB::table('users')
        ->where('users.id','=',$userid)
        ->select('users.idusertype')->value('idusertype');



        //Beginning Holidays API
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://date.nager.at/Api/v2/PublicHolidays/'.date("Y").'/PT');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resultHolidays = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        // PORTUGAL HOLIDAYS WITH EXTRA DAYS

        $resultHolidays = json_decode($resultHolidays);

        $holidays = array();

        foreach($resultHolidays as $hol) {

            $hld = Carbon::parse($hol->date);
            array_push($holidays, $hld);

        }

        $allExtraDays = settings_extradays::all();

        foreach($allExtraDays as $extra) {

            $xtr = Carbon::parse($extra->extra_day);
            array_push($holidays, $xtr);

        }

        // END - PORTUGAL HOLIDAYS WITH EXTRA DAYS

        // NOT ALLOW TO CREATE VACATIONS ON DAYS ALREADY APPROVED / CONCLUDED

        $vacation = new absence();

        $absence = new absence();

        $notification = new notifications();

        $notif_user = new NotificationsUsers();

        $op = request('op');

        $available_days = request('vacationDays');

        $updValue = request('upd');

        if($op==1) {

            $startDate = request('start_date');
            $endDate = request('end_date');
            $from = Carbon::parse($startDate);
            $to = Carbon::parse($endDate);

            foreach($allAbsences as $all) {

                if($all->iduser == $userid) {

                    if($all->absencetype == 1) {
                        // VACATIONS

                        if($all->status !== "Disapproved") {

                            if($to>=$all->start_date && $from<=$all->end_date  || $from==$all->start_date || $from==$all->end_date || $to == $all->start_date || $to == $all->end_date) {

                                $vacationsAlready = true;
                                break;

                            }

                        }


                    }

                }

            }

            for($i=0;$i<count($holidays);$i++) {

                if($from == $holidays[$i]) {

                    $vacationStartonHoliday = true;

                }

            }

            $days = $to->diffInWeekdays($from);

            if($available_days < $days) {

                return redirect('/holidays')->withErrors('You only have '.$available_days.' vacation days available. Please do not exceed your vacation days.');

            } else if($to < $from) {

                return redirect('/holidays')->withErrors('Error! End Date can not be inferior to Start Date.');

            } else if($from->isWeekend()) {

                return redirect('/holidays')->withErrors('Error! Your Start Date must be a week day.');

            } else if($vacationStartonHoliday == true) {

                return redirect('/holidays')->withErrors('Error! The Start Date you chose is on a holiday.');

            } else if($vacationsAlready == true) {

                return redirect('/holidays')->withErrors('Error! You already have vacations scheduled for the dates you chosen.');

            } else {

                if($roleuser<=2) {

                    $vacation->iduser=$userid;
                    $vacation->absencetype=1;
                    $vacation->attachment="";
                    $vacation->status="Approved";
                    $vacation->start_date = request('start_date');
                    $vacation->end_date = request('end_date');
                    $vacation->motive = "";

                    $vacation->save();

                } else {

                    $vacation->iduser=$userid;
                    $vacation->absencetype=1;
                    $vacation->attachment="";
                    $vacation->status="Pending";
                    $vacation->start_date = request('start_date');
                    $vacation->end_date = request('end_date');
                    $vacation->motive = "";

                    $vacation->save();

                }



                if($roleuser>2) {

                    $notification->type="Vacations";
                    $notification->description=$username." created vacations from ".$startDate." to ".$endDate." . Waiting for Approval.";

                    $notification->save();

                    $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                    $notif_user->notificationId=$id_notif;
                    $notif_user->createUserId=$userid;
                    $notif_user->receiveUserId=$managerId;

                    $notif_user->save();

                }

            }


        } else if($op==2) {

            $startDate = request('start_date');
            $endDate = request('end_date');

            $from = Carbon::parse($startDate);
            $to = Carbon::parse($endDate);

            foreach($allAbsences as $all) {

                if($all->iduser == $userid) {

                    if($all->absencetype > 1) {
                        // ABSENCES

                        if($all->status !== "Disapproved") {

                            if($to>=$all->start_date && $from<=$all->end_date || $from==$all->start_date || $from==$all->end_date || $to == $all->start_date || $to == $all->end_date) {

                                $absencesAlready = true;
                                break;

                            }

                        }


                    }

                }

            }

            for($i=0;$i<count($holidays);$i++) {

                if($from == $holidays[$i]) {

                    $absenceStartonHoliday = true;

                }

            }

            if($to < $from) {

                return redirect('/holidays')->withErrors('Error! End Date can not be inferior to Start Date.');

            } else if($from->isWeekend()) {

                return redirect('/holidays')->withErrors('Error! Your Start Date must be a week day.');

            }  else if($absenceStartonHoliday == true) {

                return redirect('/holidays')->withErrors('Error! The Start Date you chose is on a holiday.');

            } else if($absencesAlready == true) {

                return redirect('/holidays')->withErrors('Error! You already have absences scheduled for the dates you chosen.');

            } else {

                if($roleuser<=3) {

                    $absence->iduser=$userid;
                    $absence->absencetype=6;
                    $absence->attachment="";
                    $absence->status="Approved";
                    $absence->start_date = request('start_date');
                    $absence->end_date = request('end_date');
                    $absence->motive = "";

                    $absence->save();

                } else {

                    $absence->iduser=$userid;
                    $absence->absencetype=6;
                    $absence->attachment="";
                    $absence->status="Pending";
                    $absence->start_date = request('start_date');
                    $absence->end_date = request('end_date');
                    $absence->motive = "";

                    $absence->save();

                }

                if($roleuser>2) {

                    $notification->type="Absences";
                    $notification->description=$username." created an absence from ".$startDate." to ".$endDate." . Waiting for Approval.";

                    $notification->save();

                    $id_notif = notifications::orderBy('created_at','desc')->first()->id;

                    $notif_user->notificationId=$id_notif;
                    $notif_user->createUserId=$userid;
                    $notif_user->receiveUserId=$managerId;

                    $notif_user->save();

                }

            }

        } else if($op==3) {

            $onHoliday = false;

            $start_date = request('upd_start_date');

            $tempEndDate = DB::table('absences')
                    ->where('id', $updValue)
                    ->select('absences.end_date')->value('end_date');

            if($start_date > $tempEndDate) {

                return redirect('/holidays')->withErrors('Error! Start Date must be inferior to End Date.');

            }

            $startDate = Carbon::parse($start_date);

            for($i=0;$i<count($holidays);$i++) {

                if($startDate == $holidays[$i]) {

                    $onHoliday = true;

                }

            }

            if($startDate->isWeekend()) {

                return redirect('/holidays')->withErrors('Error! Your Start Date must be a week day.');

            } else if($onHoliday == true) {

                return redirect('/holidays')->withErrors('Error! The Start Day you chose is on a holiday.');

            } else {

                if($roleuser<=2) {

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['start_date' => $start_date]);

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['status' => 'Approved']);

                } else {

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['start_date' => $start_date]);

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['status' => 'Pending']);

                }

                if($roleuser>2) {

                    $notification->type="Vacations";
                    $notification->description=$username." updated start date of created vacations. Waiting for Approval.";

                    $notification->save();

                        $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                        $notif_user->notificationId=$id_notif;
                        $notif_user->createUserId=$userid;
                        $notif_user->receiveUserId=$managerId;

                        $notif_user->save();

                }


            }



        } else if($op==4) {

            $end_date = request('upd_end_date');

            $tempStartDate =  DB::table('absences')
            ->where('id', $updValue)
            ->select('absences.start_date')->value('start_date');

            if($end_date < $tempStartDate) {

                return redirect('/holidays')->withErrors('Error! End Date must be superior to Start Date.');

            }

            if($roleuser<=2) {

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['end_date' => $end_date]);

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['status' => 'Approved']);

            } else {

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['end_date' => $end_date]);

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['status' => 'Pending']);

            }

            if($roleuser>2) {

                $notification->type="Vacations";
                $notification->description=$username." updated end date of created vacations. Waiting for Approval.";

                $notification->save();

                    $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                    $notif_user->notificationId=$id_notif;
                    $notif_user->createUserId=$userid;
                    $notif_user->receiveUserId=$managerId;

                    $notif_user->save();

            }

        } else if($op==5) {

            $onHoliday = false;

            $start_datetime = request('upd_start_datetime');

            $tempEndDateTime = DB::table('absences')
            ->where('id', $updValue)
            ->select('absences.start_date')->value('start_date');

            if($start_datetime > $tempEndDateTime) {

                return redirect('/holidays')->withErrors('Error! Start Date must be inferior to End Date.');

            }

            $startDate = Carbon::parse($start_datetime);

            for($i=0;$i<count($holidays);$i++) {

                if($startDate == $holidays[$i]) {

                    $onHoliday = true;

                }

            }

            if($startDate->isWeekend()) {

                return redirect('/holidays')->withErrors('Error! Your Start Date must be a week day.');

            } else if($onHoliday == true) {

                return redirect('/holidays')->withErrors('Error! The Start Day you chose is on a holiday.');

            } else {

                if($roleuser<=3) {

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['start_date' => $start_datetime]);

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['status' => 'Approved']);


                } else {

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['start_date' => $start_datetime]);

                    DB::table('absences')
                    ->where('id', $updValue)
                    ->update(['status' => 'Pending']);

                }

                if($roleuser>2) {

                    $notification->type="Absences";
                    $notification->description=$username." updated start date of created absences. Waiting for Approval.";

                    $notification->save();

                        $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                        $notif_user->notificationId=$id_notif;
                        $notif_user->createUserId=$userid;
                        $notif_user->receiveUserId=$managerId;

                        $notif_user->save();

                }

            }

        } else if($op==6) {

            $end_datetime = request('upd_end_datetime');

            $tempStartDateTime = DB::table('absences')
            ->where('id', $updValue)
            ->select('absences.start_date')->value('start_date');

            if($end_datetime < $tempStartDateTime) {

                return redirect('/holidays')->withErrors('Error! End Date must be superior to Start Date.');

            }

            if($roleuser<=3) {

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['end_date' => $end_datetime]);

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['status' => 'Approved']);

            } else {

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['end_date' => $end_datetime]);

                DB::table('absences')
                ->where('id', $updValue)
                ->update(['status' => 'Pending']);

            }

            if($roleuser>2) {

                $notification->type="Absences";
                $notification->description=$username." updated end date of created absences. Waiting for Approval.";

                $notification->save();

                    $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                    $notif_user->notificationId=$id_notif;
                    $notif_user->createUserId=$userid;
                    $notif_user->receiveUserId=$managerId;

                    $notif_user->save();

            }

        } else if($op==7) {

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['status' => 'Approved']);

            $idUserCreated = DB::table('users')
            ->join('absences','absences.iduser','=','users.id')
            ->where('absences.id','=',$updValue)
            ->select('absences.iduser')
            ->value('iduser');

            $typeAbsence = DB::table('absences')
            ->where('absences.id','=',$updValue)
            ->select('absences.absencetype')
            ->value('absencetype');

            $notification->type="Approval";

            if($typeAbsence > 1) {

                $notification->description=$username." approved one of your absences.";

            } else {

                $notification->description=$username." approved one of your vacations.";

            }

            $notification->save();

            $id_notif = notifications::orderBy('created_at','desc')->first()->id;

            $notif_user->notificationId=$id_notif;
            $notif_user->createUserId=$userid;
            $notif_user->receiveUserId=$idUserCreated;

            $notif_user->save();

        } else if($op==8) {

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['status' => 'Disapproved']);

            $idUserCreated = DB::table('users')
            ->join('absences','absences.iduser','=','users.id')
            ->where('absences.id','=',$updValue)
            ->select('absences.iduser')
            ->value('iduser');

            $typeAbsence = DB::table('absences')
            ->where('absences.id','=',$updValue)
            ->select('absences.absencetype')
            ->value('absencetype');

            $notification->type="Approval";

            if($typeAbsence > 1) {

                $notification->description=$username." disapproved one of your vacations.";

            } else {

                $notification->description=$username." disapproved one of your absences.";

            }

            $notification->save();

            $id_notif = notifications::orderBy('created_at','desc')->first()->id;

            $notif_user->notificationId=$id_notif;
            $notif_user->createUserId=$userid;
            $notif_user->receiveUserId=$idUserCreated;

            $notif_user->save();

        } else if($op==9) {

            $attachment = request('inputGroupFile01');

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['attachment' => $attachment]);

        } else if($op==10) {

            $typeAbs = request('typeUpd');

            $motive = request('motive');

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['absencetype' => $typeAbs]);

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['motive' => $motive]);

        }

        return redirect('/holidays');
        //->with('msgAbs',$msg);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $workHoursSettings = settings_general::orderBy('created_at', 'desc')->first();

        $user = Auth::user();

        $id_user = Auth::user()->id;

        $notification = new notifications();

        $notif_user = new NotificationsUsers();

        $allNotifications = notifications::all();

        $allNotificationUsers = NotificationsUsers::all();

        $countryUser = DB::table('users')
        ->where('users.id','=',$id_user)
        ->select('users.country')
        ->value('country');

        $roleuser = DB::table('users')
        ->where('users.id','=',$id_user)
        ->select('users.idusertype')->value('idusertype');

        $username = DB::table('users')
        ->where('users.id','=',$id_user)
        ->select('users.name')->value('name');

        $noNotification = false;

        $listVacationsTotal = DB::table('users')->join('absences','absences.iduser','=','users.id')
        ->join('absence_types','absence_types.id','=','absences.absencetype')
        ->join('users_deps','users_deps.idUser','=','users.id')
        ->join('departments','departments.id','=','users_deps.idDepartment')
        ->select('users.id','users.name','absence_types.description','absences.id as absencedId','absences.status','absences.attachment','absences.start_date as start_date','absences.end_date as end_date','departments.description as depDescription')
        ->where('users.id','!=','1')
        ->where('users.country','like', $countryUser)
        ->where('absence_types.id','=','1')->get();


        $listAbsencesTotal = DB::table('users')->join('absences','absences.iduser','=','users.id')
        ->join('absence_types','absence_types.id','=','absences.absencetype')
        ->join('users_deps','users_deps.idUser','=','users.id')
        ->join('departments','departments.id','=','users_deps.idDepartment')
        ->select('users.*','absence_types.description','absences.id as absencedId','absences.status','absences.attachment','absences.start_date as start_date','absences.end_date as end_date','departments.description as depDescription')
        ->where('users.id','!=','1')
        ->where('users.country','like', $countryUser)
        ->where('absence_types.id','>','1')->get();

        // DATE CALCULATION

        $contractDate = $user->contractUser->start_date;

        $currentDate = date("Y-m-d");

        $date1 = date_create($currentDate);
        $date2 = date_create($contractDate);

        $yearCurrent = $date1->format("Y");
        $yearContract = $date2->format("Y"); // YEAR OF CONTRACT

        $monthContract = $date2->format("m"); //MONTH OF CONTRACT
        $dayContract = $date2->format("d"); // DAY OF CONTRACT

        $monthCurrent = $date1->format("m"); // CURRENT MONTH
        $dayCurrent = $date1->format("d"); // CURRENT DAY

        $diff=date_diff($date1,$date2);
        $years = $diff->format("%Y%"); //format years
        $months = $diff->format("%m%"); //format months

        // END DATE CALCULATION

        //$listVacationsUser = $user->userAbsence()->where('absencetype',1);

        $nrVacationsCY = $user->listAbsencesUserCY($id_user);

        $nrVacationsLY = $user->listAbsencesUserLY($id_user);

        $count_days = 0;

        $count_days2 = 0;

        $dateEndLY = date('Y-12-31', strtotime('- 1 year')); // DATE - END OF LAST YER

        $dateEndCY = date('Y-12-31'); // DATE - END OF CURRENT YEAR

        $dateStartCY = date('Y-01-01'); // DATE - START OF CURRENT YEAR

        $dateStartLY = date('Y-01-01', strtotime('- 1 year')); // DATE - START OF LAST YEAR

        $dateEnd2Y = date('Y-12-31', strtotime('- 2 year')); // DATE - END OF 2 YEARS AGO

        //Beginning Holidays API
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://date.nager.at/Api/v2/PublicHolidays/'.date("Y").'/PT');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resultHolidays = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);


        $resultHolidays = json_decode($resultHolidays);

        /* $holidays = [

            Carbon::create(2020, 1, 1),
            Carbon::create(2020, 2, 26),
            Carbon::create(2020, 4, 10),
            Carbon::create(2020, 4, 12),
            Carbon::create(2020, 4, 25),
            Carbon::create(2020, 5, 1),
            Carbon::create(2020, 6, 10),
            Carbon::create(2020, 6, 11),
            Carbon::create(2020, 8, 15),
            Carbon::create(2020, 10, 5),
            Carbon::create(2020, 11, 1),
            Carbon::create(2020, 12, 1),
            Carbon::create(2020, 12, 8),
            Carbon::create(2020, 12, 24),
            Carbon::create(2020, 12, 25),
            Carbon::create(2020, 12, 31),


        ]; */

        $holidays = array();

        foreach($resultHolidays as $hol) {

            $hld = Carbon::parse($hol->date);
            array_push($holidays, $hld);

        }

        // ADD EXTRA DAYS TO HOLIDAYS

        $allExtraDays = settings_extradays::all();

        foreach($allExtraDays as $extra) {

            $xtr = Carbon::parse($extra->extra_day);
            array_push($holidays, $xtr);

        }


        foreach($nrVacationsCY as $vac) {

            $start = $vac->start_date;
            $end = $vac->end_date;

            if($start<=$dateEndLY) {

                $start = $start_year;

            }

            $date3 = date_create($start);
            $date4 = date_create($end);


            //$diff_endstart = date_diff($date3,$date4);
            //$days = $diff_endstart->format("%d%"); //format days

            $from = Carbon::parse($date3);
            $to = Carbon::parse($date4);

            //$days = $to->diffInWeekdays($from);

            $days=$from->diffInDaysFiltered(function (Carbon $date) use ($holidays) {

                return $date->isWeekday() && !in_array($date, $holidays);

            }, $to);

            $count_days += $days;

            $count_days += 1; //Number of vacation days already spent this year

        }

        //$count_days = $days;

        //$count_days += 1; //Number of vacation days already spent this year

        foreach($nrVacationsLY as $vac) {

            $start2 = $vac->start_date;
            $end2 = $vac->end_date;

            if($start2<=$dateEnd2Y) {

                $start2 = $dateStartLY;

            }

            $date5 = date_create($start2);
            $date6 = date_create($end2);

            //$diff_endstart2 = date_diff($date5,$date6);
            //$days2 = $diff_endstart2->format("%d%"); //format days

            $from2 = Carbon::parse($date5);
            $to2 = Carbon::parse($date6);

            $days2 = $to2->diffInWeekdays($from2);

            $count_days2 += $days2;

            $count_days2 += 1; //Number of vacation days already spent from last year

        }

        //$count_days2 += 1; //Number of vacation days already spent from last year


        $balance = 0;

        $vacationDaysCY = 0;
        $vacationDaysLY = 0;

        if($years<1){

            $vacationDaysLY = ((12 - $monthContract) + 1) * 2;    //MONTH DIFFERENCE BETWEEN BEGINNING CONTRACT AND END OF YEAR

            if($dayContract>=15) {

                $vacationDaysLY = $vacationDaysLY - 1;

            }

            if($yearContract==$yearCurrent) {

                $vacationDaysLY = 0;

            }


            $vacationDaysCY = ($monthCurrent - 1) * 2;       //MONTH DIFFERENCE BETWEEN MONTH CURRENT AND BEGINNING OF YEAR

            if($dayCurrent>=15) {

                $vacationDaysCY = $vacationDaysCY + 1;

            }

            $balanceLY = ($vacationDaysLY - $count_days2); // TOTAL DAYS LAST YEAR - DAYS SPENT LAST YEAR

            if($balanceLY < 0) {

                $balanceLY = 0;

            }

            $vacations_total = $vacationDaysCY + $balanceLY; // TOTAL DAYS

            $vacationDaysAvailable = $vacations_total - $count_days; // TOTAL AVAILABLE DAYS


        } else {

            if($yearContract!=($yearContract)-1) {

                $vacationDaysLY = 2 * 12;

            } else {

                $vacationDaysLY = 2 * ((12 - $monthContract) + 1);

            }


            $vacationDaysCY = 2 * 12;

        }

        $balanceLY = ($vacationDaysLY - $count_days2); // TOTAL DAYS LAST YEAR - DAYS SPENT LAST YEAR

        if($balanceLY < 0) {

            $balanceLY = 0;

        }

        $vacations_total = $vacationDaysCY + $balanceLY; // TOTAL DAYS

        // MAX DAYS PER YEAR -> VARIABLE FROM SETTINGS

        $maxVacations = DB::table('settings_general')->select('limit_vacations')->latest('created_at')->first();

        $maxVacations = settings_general::orderBy('created_at','desc')->first()->limit_vacations;

        if($vacations_total > $maxVacations) {

            $vacations_total = $maxVacations;

        }

        $vacationDaysAvailable = $vacations_total - $count_days; // TOTAL AVAILABLE DAYS

        // $numberVacationsAvailable = $vacations_total - $count_days;

        // return view('admin.dashboard',compact('numberVacationsAvailable','vacations_total'));
        // return view('testeNumberHolidays',compact('numberVacationsAvailable','vacations_total'));
        //
        $userLogado =  Auth::id();
        $ausenciasDoUser = absence::where('iduser','=', $userLogado)
               ->where('absencetype', '!=' , 1)
               ->where('status', '=' , 'Concluded')
               ->select('*')
               ->get();

        $diasAusencia = 0;

        for($i = 0; $i < count($ausenciasDoUser); $i++) {
            $beginning = $ausenciasDoUser[$i]->start_date;
            $ending = $ausenciasDoUser[$i]->end_date;
            $date1=date_create($beginning);
            $date2=date_create($ending);
            $diff=date_diff($date1,$date2);
            $days = $diff->format("%d%");
            $diasAusencia += $days;
        }
        $diasAusencia += 1;


        //Calendar begin
        $events = sliderView::all();
        //calendar end



        //Slider begin



$eventos = DB::table('sliderView')
        ->select('*')
        ->get();





$actualDate = date("Y/m/d");
$msg = "";
$lastIteration = 0;
$blocksNum = (count($eventos) / 3);
$contagem = 0;

for($l = 0; $l < $blocksNum; $l++) {
    if($l == 0) {
        $msg .= "<div class='carousel-item active' id='carItems'>";
    }
     else {
         $msg .= "<div class='carousel-item' id='carItems'>";
     }
    $msg .= "<div class='row'>";


        for($i = $lastIteration; $i < count($eventos); $i++) {
            $today = date("Y/m/d");
            $today = date('Y-m-d', strtotime($today));
            $eventDate = date('Y-m-d',strtotime($eventos[$i]->Date));
            //filtro para mostrar apenas todos os eventos futuros da data actual
            // if($eventDate < $today) {
            //     continue;
            // }
            if($i == count($eventos)-1) {
                continue;
            }


            $msg .= "<div class='col-md-4 sizeMobile'>";
<<<<<<< HEAD
                $msg .= "<div class=' mb-2'>";
=======
                $msg .= "<div class='mb-2'>";
>>>>>>> parent of 1ea717a... Revert "Merge pull request #176 from ImprooveTrainees/homepage_as_new"

            if($eventos[$i]->{"DateEnd Absence"} != null) {
                $absenceDateEnd = date('Y-m-d',strtotime($eventos[$i]->{"DateEnd Absence"}));
            }
            else {
                $absenceDateEnd = "";
            }
            if($eventos[$i]->Type == "Birthday") {
                if(date('d/m',strtotime($eventos[$i]->Date)) == date('d/m')) {
                    $msg .= "<img class='card-img-top sliderResize2' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                    $msg .= "<div class='card-body'>";
                    $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                    $msg .= "<p class='card-text'>Happy birthday ".$eventos[$i]->Name."! </p>";
                    // <a class="btn btn-primary">Button</a>
                  $msg.= "</div>";
                }
                else {
                    $msg .= "<img class='card-img-top sliderResize2' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                    $msg .= "<div class='card-body'>";
                    $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                    $msg .= "<p class='card-text'>".$eventos[$i]->Name."'s birthday!";
                    $msg .= "<br>";
                    $msg .= "Date: ". date('d/m',strtotime($eventos[$i]->Date));
                    $msg .= "<br>";
                    $msg .= "<a href='http://www.linkedin.com' class='fa fa-linkedin' id='social'></a>";
                    $msg .= "</p>";
                    // <a class="btn btn-primary">Button</a>
                    $msg.= "</div>";

                }

            }

            else if($eventos[$i]->Type == "Absence" && $eventos[$i]->{"Absence Type"} == 1) {
                $msg .= "<img class='card-img-top sliderResize2' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                $msg .= "<div class='card-body'>";
                $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                $msg .= "<p class='card-text'> Vacations: ".$eventDate. " - ". $absenceDateEnd;
                $msg .= "<br>";
                $msg .= "<a href='http://www.linkedin.com' class='fa fa-linkedin' id='social'></a>";
                $msg .= "</p>";
                $msg.= "</div>";
            }
            else if($eventos[$i]->Type == "Contract Begin") {
                if(date('d/m',strtotime($eventos[$i]->Date)) == date('d/m')) {
                    $msg .= "<img class='card-img-top sliderResize2' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                    $msg .= "<div class='card-body'>";
                    $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                    $msg .= "<p class='card-text'> Today is ".$eventos[$i]->Name. "'s company birthday!";
                    $msg .= "<br>";
                    $msg .= "Date: ".date('d/m',strtotime($eventos[$i]->Date));
                    $msg .= "</p>";
                    $msg.= "</div>";
                }
                else {
                    $msg .= "<img class='card-img-top sliderResize2' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                    $msg .= "<div class='card-body'>";
                    $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                    $msg .= "<p class='card-text'>".$eventos[$i]->Name."'s company birthday!";;
                    $msg .= "<br>";
                    $msg .= "Date: ".date('d/m',strtotime($eventos[$i]->Date));
                    $msg .= "<br>";
                    $msg .= "<a href='http://www.linkedin.com' class='fa fa-linkedin' id='social'></a>";
                    $msg .= "</p>";
                    $msg.= "</div>";
                }

            }

            else {
                $msg .= "<img class='card-img-top sliderResize2' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                $msg .= "<div class='card-body'>";
                $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                // $msg .= "Type: ".$eventos[$i]->Type."<br>";
                if($eventos[$i]->{"Absence Motive"} == null){
                    $msg .= "<p class='card-text'>";
                }
                else {
                    $msg .= "<p class='card-text'>".$eventos[$i]->{"Absence Motive"}."<br>";

                }
                $msg .= "Date: ".$eventDate."<br>";
                $msg .= "End Date: ".$absenceDateEnd."<br>";
                $msg .= "<br>";
                $msg .= "<a href='http://www.linkedin.com' class='fa fa-linkedin' id='social'></a>";
                $msg .= "</p>";
                $msg.= "</div>";

            }


             $msg .= "</div>";
        $msg .= "</div>";



        // if($i % 3 == 0) {
        //     $lastIteration = $i+1;
        //     break 1;
        // }


        // if($i % 3 == 0) {
        //     $lastIteration = $i;
        //     break;
        // }
        $contagem++;
        if($contagem == 3) {
            $lastIteration = $i+1;
            $contagem = 0;
            break 1;
        }

        // if($i == 3) {
        //  $msg .= "</div>";
        //  $msg .= "</div>";
        // break 2;
        //  }

    }


     $msg .= "</div>";

    $msg .= "</div>";


 }

 // NOTIFICATIONS FOR ABSENCES / VACATIONS TOMORROW (FOR RH AND MANAGER)

 foreach($listAbsencesTotal as $list) {

    $today = Carbon::now();

    $startDate = Carbon::parse($list->start_date);

    //$difference = $today->diffInDays($startDate);

    $difference=$today->diffInDaysFiltered(function (Carbon $date) use ($holidays) {

        return $date->isWeekday() && !in_array($date, $holidays);

    }, $startDate);

    if($difference <= 1) {

        if($list->status == "Approved") {

            if($roleuser>1 && $roleuser<=3) {

                if($list->name !== $username) {

                    $descricao = $list->name." will be absent from ".$list->start_date." to ".$list->end_date." .";

                    foreach($allNotifications as $notifList) {

                        if($notifList->description == $descricao) {

                            $idTemp = $notifList->id;


                            foreach($allNotificationUsers as $list) {

                                if($list->notificationId == $idTemp) {

                                    if($list->receiveUserId == $id_user) {

                                        $noNotification = true;

                                    }

                                }

                            }

                        }

                    }

                    if($noNotification == false) {

                        $notification->type="Absences";
                        $notification->description=$descricao;

                        $notification->save();

                        $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                        $notif_user->notificationId=$id_notif;
                        $notif_user->receiveUserId=$id_user;

                        $notif_user->save();


                    }


                }



            }


        }

    }
}

$noNotification = false;

foreach($listVacationsTotal as $list) {


    $today = Carbon::now();

    $startDate = Carbon::parse($list->start_date);

    //$difference = $today->diffInDays($startDate);

    $difference=$today->diffInDaysFiltered(function (Carbon $date) use ($holidays) {

        return $date->isWeekday() && !in_array($date, $holidays);

    }, $startDate);

    if($difference <= 1) {

        if($list->status == "Approved") {

            if($roleuser>1 && $roleuser<=3) {

                if($list->name !== $username) {

                    $descricao = $list->name." will be on vacations from ".$list->start_date." to ".$list->end_date." .";

                    foreach($allNotifications as $notifList) {

                        if($notifList->description == $descricao) {

                            $idTemp = $notifList->id;


                            foreach($allNotificationUsers as $list) {

                                if($list->notificationId == $idTemp) {

                                    if($list->receiveUserId == $id_user) {

                                        $noNotification = true;

                                    }

                                }

                            }

                        }

                    }

                if($noNotification == false) {

                    $notification->type="Vacations";
                    $notification->description=$descricao;

                    $notification->save();

                    $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                    $notif_user->notificationId=$id_notif;
                    $notif_user->receiveUserId=$id_user;

                    $notif_user->save();

                }


                }


        }


        }

    }

}

// END NOTIFICATIONS FOR ABSENCES / VACATIONS TOMORROW (FOR RH AND MANAGER)

// NOTIFICATIONS FOR ABSENCES / VACATIONS STARTING TOMORROR THAT STATUS IS PENDING (FOR RH AND MANAGER)

$noNotification2 = false;

foreach($listAbsencesTotal as $listAb) {

    $today = Carbon::now();

    $startDate = Carbon::parse($list->start_date);

    $difference=$today->diffInDaysFiltered(function (Carbon $date) use ($holidays) {

        return $date->isWeekday() && !in_array($date, $holidays);

    }, $startDate);

    //$difference = $today->diffInDays($startDate);

    if($difference <= 1) {

        if($listAb->status == "Pending") {

            if($roleuser>1 && $roleuser<=3) {

                if($listAb->name !== $username) {

                    $descricao2 = "Urgent! You have an Absence from ".$listAb->name." waiting for Approval, from ".$listAb->start_date." to ".$listAb->end_date." .";

                    foreach($allNotifications as $notifList) {

                        if($notifList->description == $descricao2) {

                            $idTemp = $notifList->id;


                        foreach($allNotificationUsers as $list) {

                            if($list->notificationId == $idTemp) {

                                if($list->receiveUserId == $id_user) {

                                    $noNotification2 = true;

                                }

                            }

                        }

                        }


                    }

                    if($noNotification2 == false) {

                        $notification->type="Approval";
                        $notification->description=$descricao2;

                        $notification->save();

                        $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                        $notif_user->notificationId=$id_notif;
                        $notif_user->receiveUserId=$id_user;

                        $notif_user->save();

                        if($workHoursSettings->alert_holidays == 1) {
                                //Mail to user
                            $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
                            $body = [
                            'Messages' => [
                                [
                                'From' => [
                                    'Email' => "mailsenderhr@gmail.com",
                                    'Name' => "ImprooveHR"
                                ],
                                'To' => [
                                    [
                                    'Email' => "andresl19972@gmail.com",
                                    'Name' => User::find($id_user)->name,
                                    ]
                                ],
                                'Subject' => "Absence waiting for approval",
                                'TextPart' => "My first Mailjet email",
                                'HTMLPart' => "<h3>Dear ".User::find($id_user)->name.",".$descricao2."</h3><br/>!",
                                'CustomID' => "AppGettingStartedTest"
                                ]
                            ]
                            ];
                            $response = $mj->post(Resources::$Email, ['body' => $body]);
                            $response->success();

                            //
                        }




                    }


                }



                }




        }

    }


}

$noNotification2 = false;


foreach($listVacationsTotal as $listVac) {

    $today = Carbon::now();

    $startDate = Carbon::parse($list->start_date);

    $difference=$today->diffInDaysFiltered(function (Carbon $date) use ($holidays) {

        return $date->isWeekday() && !in_array($date, $holidays);

    }, $startDate);

    //$difference = $today->diffInDays($startDate);

    if($difference <= 1) {

        if($listVac->status == "Pending") {

            if($roleuser==2) {

                if($listVac->name !== $username) {
                    $descricao2 = "Urgent! You have Vacations from ".$listVac->name." waiting for Approval, from ".$listVac->start_date." to ".$listVac->end_date." .";

                    foreach($allNotifications as $notifList) {

                        if($notifList->description == $descricao2) {

                            $idTemp = $notifList->id;


                        foreach($allNotificationUsers as $list) {

                            if($list->notificationId == $idTemp) {

                                if($list->receiveUserId == $id_user) {

                                    $noNotification2 = true;

                                }

                            }

                        }

                        }


                    }

                    if($noNotification2 == false) {

                        $notification->type="Approval";
                        $notification->description=$descricao2;

                        $notification->save();

                        $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                        $notif_user->notificationId=$id_notif;
                        $notif_user->receiveUserId=$id_user;

                        $notif_user->save();

                         //Mail to user
                         $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
                         $body = [
                         'Messages' => [
                             [
                             'From' => [
                                 'Email' => "mailsenderhr@gmail.com",
                                 'Name' => "ImprooveHR"
                             ],
                             'To' => [
                                 [
                                 'Email' => "andresl19972@gmail.com",
                                 'Name' => User::find($id_user)->name,
                                 ]
                             ],
                             'Subject' => "Vacations waiting for approval",
                             'TextPart' => "My first Mailjet email",
                             'HTMLPart' => "<h3>Dear ".User::find($id_user)->name.",".$descricao2."</h3><br/>!",
                             'CustomID' => "AppGettingStartedTest"
                             ]
                         ]
                         ];
                         $response = $mj->post(Resources::$Email, ['body' => $body]);
                         $response->success();

                         //



                    }



                }





            }

        }

    }


}


// Slider End


//Flextime begin
        $userExistFlextime = users_flextime::where('idUser', Auth::user()->id)->first();
        $harvestConfigured = false;
        if($userExistFlextime == null) {
            $totalHoursTodoCurrentWeek = "N/A";
            $totalHours = "N/A";
        }
        else {

                $allAbsences = absence::All()->where('status', '=', 'Concluded')->where('iduser', '=', Auth::User()->id);

                //Time entries Harvest API
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.harvestapp.com/v2/time_entries');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


                $headers = array();
                $headers[] = 'Harvest-Account-Id:'.$userExistFlextime->acc_id;
                $headers[] = 'Authorization: Bearer '.$userExistFlextime->harvestApi_token;
                $headers[] = 'User-Agent: ImprooveHR(andre.lopes@gmail.com)';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result2 = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);

                $result2 = json_decode($result2);



        //end Time entries Harvest API


        //$actualMonthDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date("Y"));
        $monthBegin = new DateTime('first day of this month');
        $monthEnd = new DateTime('tomorrow'); //ele inclui a start date, mas não a end date, portanto adicionamos mais um dia
        $monthlyHoursWorkDays = 0;
        $dateRangeCountWeekends = new DatePeriod(
            new DateTime($monthBegin->format('Y-m-d')),
            new DateInterval('P1D'),
            new DateTime($monthEnd->format('Y-m-d'))
        );

        $workingDays = [];
        for($i = $workHoursSettings->flextime_startDay; $i <= $workHoursSettings->flextime_endDay; $i++) {
            array_push($workingDays, $i);
        }


        foreach ($dateRangeCountWeekends as $key => $value) {
            if($value->format('w') != 6 && $value->format('w') != 0) { //retira as horas dos fim de semanas do mês actual
                foreach($workingDays as $wDays) {
                    if($value->format('w') == $wDays) { //se for dentro da range dos dias escolhidos para trabalhar nas settings
                            $monthlyHoursWorkDays+= $workHoursSettings->flextime_dailyHours;
                            foreach($resultHolidays as $holiday) { //se não for fim de semana e fôr um dia da semana escolhido nas settings, mas fôr feriado, retira as horas
                                if($holiday->date == $value->format('Y-m-d')) {
                                    $monthlyHoursWorkDays-= $workHoursSettings->flextime_dailyHours;
                                }
                            }
                    }
                }
            }
        }

        //this week vars
        $currentWeek = date( 'F d', strtotime( 'monday this week' ) )." | ". date( 'F d', strtotime( 'sunday this week' ) )." ".date('Y');

        $daysCurrentWeek = [];
        $totalsCurrentWeek = [];
        $totalHours = 0;

        for($b = $workHoursSettings->flextime_startDay-1; $b < $workHoursSettings->flextime_endDay; $b++)
        {
            array_push($daysCurrentWeek,date('Y-m-d', strtotime( 'monday this week +'.$b.' days')));
            array_push($totalsCurrentWeek, 0);
        }



        for($i = 0; $i  < count($result2->time_entries); $i++) {
            for($b = 0; $b < count($daysCurrentWeek); $b++) {
                foreach($allAbsences as $absence) {
                    $dateStartAbsence = date('Y-m-d',strtotime($absence->start_date));
                    $dateEndAbsence = date('Y-m-d',strtotime('+1 day', strtotime($absence->end_date)));
                    $AbsenceDatesBetween = new DatePeriod(
                        new DateTime($dateStartAbsence),
                        new DateInterval('P1D'),
                        new DateTime($dateEndAbsence)
                );
                foreach ($AbsenceDatesBetween as $key => $value) {
                        if($value->format('Y-m-d') == $daysCurrentWeek[$b]) {
                            if($absence->absencetype == 1) {
                                $totalsCurrentWeek[$b] = "Vacations";
                                continue 3; //após confirmado que é ausência, passa para o prox dia
                            }
                            else {
                                $totalsCurrentWeek[$b] = $absence->motive;
                                continue 3;
                            }
                            // aqui passa para a prox iteração do dia da semana, pois esse dia já foi preenchido pela absence
                            //pega em todos os dias da absence (inclusive os que estão no meio) e
                            //compara com o dia da semana do harvest. Caso se verifique que algum deles é igual,
                            //é porque o user esteve ausente esses dias.
                        }
                    }


                }
                foreach($resultHolidays as $holiday) {
                    if($holiday->date == $daysCurrentWeek[$b]) {
                        $totalsCurrentWeek[$b] = $holiday->localName;
                        continue 2;
                    }
                }
                if($result2->time_entries[$i]->spent_date == $daysCurrentWeek[$b]) {
                        $totalsCurrentWeek[$b] += $result2->time_entries[$i]->hours;
                        $totalHours += $result2->time_entries[$i]->hours;
                }


            }

        }

        $totalHoursTodoCurrentWeek = 0;
        $dateRangeCurrentWeek = new DatePeriod(
            new DateTime($daysCurrentWeek[0]),
            new DateInterval('P1D'),
            new DateTime(date( "Y-m-d", strtotime(end($daysCurrentWeek) . '+1 day'))) //ultimo dia do array +1 dia, para ele contá-lo no total de horas
        );





        foreach ($dateRangeCurrentWeek as $key => $value) {
                $totalHoursTodoCurrentWeek+= $workHoursSettings->flextime_dailyHours;
                foreach($resultHolidays as $holiday) {
                    if($holiday->date == $value->format('Y-m-d')) {
                        $totalHoursTodoCurrentWeek-= $workHoursSettings->flextime_dailyHours;
                    }
                }

        }

        $userExistFlextime->hoursDoneWeek = $totalHours;
        $userExistFlextime->hoursToDoWeek = $totalHoursTodoCurrentWeek;
        $userExistFlextime->save();

        //Notifications Harvest
        $allUsersFlextime = users_flextime::All();
        $allNotiticationsHarvest = NotificationsUsers::All();



        if(date('Y-m-d') == end($daysCurrentWeek)) {
            foreach($allUsersFlextime as $flexUser) {
                if($flexUser->hoursDoneWeek < $flexUser->hoursToDoWeek && $workHoursSettings->alert_flextime == 1) {

                    $notfExists = false;
                    $notfManagerExists = false;

                    foreach($allNotiticationsHarvest as $notfHarvest) {
                        $notification = notifications::find($notfHarvest->notificationId);
                        if($notification->type == 'Flextime') {
                            if(date('Y-m-d') == date('Y-m-d',strtotime($notfHarvest->created_at)) && $notfHarvest->receiveUserId == $flexUser->idUser) {
                                $notfExists = true;
                            }

                        }
                    }
                    $userFlex = User::find($flexUser->idUser);
                    $managerUser = User::find($userFlex->managerDoUserId($userFlex->departments->first()->description, $userFlex->country));

                    foreach($allNotiticationsHarvest as $notfHarvest) {
                        $notification = notifications::find($notfHarvest->notificationId);
                        if($notification->type == 'Flextime') {
                            if(date('Y-m-d') == date('Y-m-d',strtotime($notfHarvest->created_at)) && $notfHarvest->receiveUserId == $managerUser->id) {
                                $notfManagerExists = true;
                            }

                        }
                    }

                        if(!$notfExists) {
                                $newNotification = new notifications;
                                $newNotification->type = "Flextime";
                                $newNotification->description = "You still have ".($flexUser->hoursToDoWeek - $flexUser->hoursDoneWeek)." left to report this week.";
                                $newNotification->save();
                                $newNotfUser = new NotificationsUsers;
                                $newNotfUser->notificationId = $newNotification->id;
                                $newNotfUser->receiveUserId = $flexUser->idUser;
                                $newNotfUser->save();

                            //     $managerUserAuth = User::find(Auth::user()->managerDoUserId(Auth::user()->departments->first()->description, Auth::user()->country));
                              //Mail to User

                              $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
                              $body = [
                                'Messages' => [
                                  [
                                    'From' => [
                                      'Email' => "mailsenderhr@gmail.com",
                                      'Name' => "ImprooveHR"
                                    ],
                                    'To' => [
                                      [
                                        'Email' => "andresl19972@gmail.com",
                                        'Name' => User::find($flexUser->idUser)->name,
                                      ]
                                    ],
                                    'Subject' => "Harvest hours remaining",
                                    'TextPart' => "My first Mailjet email",
                                    'HTMLPart' => "<h3>Dear ".User::find($flexUser->idUser)->name.", you still have ".($flexUser->hoursToDoWeek - $flexUser->hoursDoneWeek)." hours left to report from this week. Do it as quickly as possible.</h3><br/>!",
                                    'CustomID' => "AppGettingStartedTest"
                                  ]
                                ]
                              ];
                              $response = $mj->post(Resources::$Email, ['body' => $body]);
                              $response->success();
                            //

                        }
                        if(!$notfManagerExists && Auth::user()->id != $managerUser->id) {
                                //user manager part


                                $newNotificationAdmin = new notifications;
                                $newNotificationAdmin->type = "Flextime";
                                $newNotificationAdmin->description = $userFlex->name." still haves ".($flexUser->hoursToDoWeek - $flexUser->hoursDoneWeek)." hours left to report this week. Warn him!";
                                $newNotificationAdmin->save();
                                $newNotfUserAdmin = new NotificationsUsers;
                                $newNotfUserAdmin->notificationId = $newNotificationAdmin->id;
                                $newNotfUserAdmin->receiveUserId = $managerUser->id;
                                $newNotfUserAdmin->save();


                                $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
                              $body = [
                                'Messages' => [
                                  [
                                    'From' => [
                                      'Email' => "mailsenderhr@gmail.com",
                                      'Name' => "ImprooveHR"
                                    ],
                                    'To' => [
                                      [
                                        'Email' => "andresl19972@gmail.com",
                                        'Name' => $managerUser->name,
                                      ]
                                    ],
                                    'Subject' => "Harvest hours remaining",
                                    'TextPart' => "My first Mailjet email",
                                    'HTMLPart' => "<h3>Dear ".$managerUser->name.", ".User::find($flexUser->idUser)->name." still haves ".($flexUser->hoursToDoWeek - $flexUser->hoursDoneWeek)." hours left to report from this week. Warn him as quickly as possible.</h3><br/>!",
                                    'CustomID' => "AppGettingStartedTest"
                                  ]
                                ]
                              ];
                              $response = $mj->post(Resources::$Email, ['body' => $body]);
                              $response->success();
                               //
                        }



                }
            }
        }

        //Notifications Harvest

    }
//Notifications Harvest


    // $allNotiticationsHarvest = NotificationsUsers::All();
    // $notfExists = false;
    // if(date('Y-m-d') == end($daysCurrentWeek) && $totalHours < $totalHoursTodoCurrentWeek) {

    //     foreach($allNotiticationsHarvest as $notfHarvest) {
    //         $notification = notifications::find($notfHarvest->notificationId);
    //         if($notification->type == 'Flextime') {
    //             if(date('Y-m-d') == date('Y-m-d',strtotime($notfHarvest->created_at)) && $notfHarvest->receiveUserId == Auth::user()->id) {
    //                 $notfExists = true;
    //             }
    //         }

    //     }

    // if(!$notfExists) {
    //     $newNotification = new notifications;
    //     $newNotification->type = "Flextime";
    //     $newNotification->description = "You still have ".($totalHoursTodoCurrentWeek - $totalHours)." left to report this week.";
    //     $newNotification->save();
    //     $newNotfUser = new NotificationsUsers;
    //     $newNotfUser->notificationId = $newNotification->id;
    //     $newNotfUser->receiveUserId = Auth::user()->id;
    //     $newNotfUser->save();

    //     $managerUserAuth = User::find(Auth::user()->managerDoUserId(Auth::user()->departments->first()->description, Auth::user()->country));
    //     //Mail to User

    //     $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
    //     $body = [
    //       'Messages' => [
    //         [
    //           'From' => [
    //             'Email' => "mailsenderhr@gmail.com",
    //             'Name' => "ImprooveHR"
    //           ],
    //           'To' => [
    //             [
    //               'Email' => "andresl19972@gmail.com",
    //               'Name' => Auth::user()->name,
    //             ]
    //           ],
    //           'Subject' => "Harvest hours remaining",
    //           'TextPart' => "My first Mailjet email",
    //           'HTMLPart' => "<h3>Dear ".Auth::user()->name.", you still have ".($totalHoursTodoCurrentWeek - $totalHours)." hours left to report this week. Do it as quickly as possible.</h3><br/>!",
    //           'CustomID' => "AppGettingStartedTest"
    //         ]
    //       ]
    //     ];
    //     $response = $mj->post(Resources::$Email, ['body' => $body]);
    //     $response->success() && var_dump($response->getData());
    //     //

    //     if($managerUserAuth->id != null) {
    //         if($managerUserAuth->id != Auth::user()->id) { //se o user não for manager, não vai enviar de novo mail a ele mesmo
    //             //neste momento apenas temos acesso a um harvest, não é possivel avisar todos os users que faltam horas (sem info na db)
    //                 //Mail to Manager
    //                 $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
    //                 $body = [
    //                 'Messages' => [
    //                 [
    //                 'From' => [
    //                 'Email' => "mailsenderhr@gmail.com",
    //                 'Name' => "ImprooveHR"
    //                 ],
    //                 'To' => [
    //                 [
    //                 'Email' => "andresl19972@gmail.com",
    //                 'Name' => $managerUserAuth->name,
    //                 ]
    //                 ],
    //                 'Subject' => "Harvest hours remaining",
    //                 'TextPart' => "My first Mailjet email",
    //                 'HTMLPart' => "<h3>Dear ".$managerUserAuth->name.", ".Auth::user()->name." still haves ".($totalHoursTodoCurrentWeek - $totalHours)." hours left to report this week. Warn him as soon as possible.</h3><br/>!",
    //                 'CustomID' => "AppGettingStartedTest"
    //                 ]
    //                 ]
    //                 ];
    //                 $response = $mj->post(Resources::$Email, ['body' => $body]);
    //                 $response->success() && var_dump($response->getData());
    //                 //
    //                 }

    //     }






    // }


    // }
//Notifications harvest

//endcurrentweek



//FlexTime End


        $request->session()->put('vacationDays', $vacationDaysAvailable);

        //$_SESSION["vacationDays"] = $vacationDaysAvailable;

        //session(['vacationDays' => $vacationDaysAvailable]);



        //Notifications
            $listNotificationsEvals = notifications::where('type', 'EvaluationAssigned')->orderBy('created_at', 'desc')->get();
            $notfsUsers = NotificationsUsers::All();
            $AllReminders = notifications_reminders::All();

            //notifications Evals
            foreach($listNotificationsEvals as $notfEval) { //reminders
                $notfUser = NotificationsUsers::where('notificationId', $notfEval->id)->get();
                foreach($notfUser as $userNotf) {
                    if(date('Y-m-d') == date('Y-m-d',strtotime($userNotf->date_limit_evals . "-5 days"))) {
                        $reminderDescription = "You have 5 days remaining to complete your survey from ". User::find($userNotf->createUserId)->name;
                        $reminderAlreadyExists = false;
                        foreach($AllReminders as $reminder) {
                            if($reminder->notifications_users_id == $userNotf->id && $reminder->description == $reminderDescription){
                                $reminderAlreadyExists = true; // se o reminder existe associado a esta notf, com a mesma descrição, não vai aparecer
                            }
                        }
                        if(!$reminderAlreadyExists) {
                            $newReminder = new notifications_reminders; //nova notificacao
                            $newReminder->notifications_users_id = $userNotf->id;
                            $newReminder->description = $reminderDescription;
                            $newReminder->save();

                            //Mail to user
                            $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
                            $body = [
                            'Messages' => [
                                [
                                'From' => [
                                    'Email' => "mailsenderhr@gmail.com",
                                    'Name' => "ImprooveHR"
                                ],
                                'To' => [
                                    [
                                    'Email' => "andresl19972@gmail.com",
                                    'Name' => User::find($userNotf->receiveUserId)->name,
                                    ]
                                ],
                                'Subject' => "Evaluation time is almost over",
                                'TextPart' => "My first Mailjet email",
                                'HTMLPart' => "<h3>Dear ".User::find($userNotf->receiveUserId)->name.", you have 5 days remaining to complete your survey from ". User::find($userNotf->createUserId)->name.". Don't forget!</h3><br/>!",
                                'CustomID' => "AppGettingStartedTest"
                                ]
                            ]
                            ];
                            $response = $mj->post(Resources::$Email, ['body' => $body]);
                            $response->success();

                            //
                        }


                    }
                    else if(date('Y-m-d') == date('Y-m-d',strtotime($userNotf->date_limit_evals . "-1 days"))) {
                        $reminderDescription = "You have 1 day remaining to complete your survey from ". User::find($userNotf->createUserId)->name;
                        $reminderAlreadyExists = false;
                        foreach($AllReminders as $reminder) {
                        if($reminder->notifications_users_id == $userNotf->id && $reminder->description == $reminderDescription){
                                $reminderAlreadyExists = true; // se o reminder existe associado a esta notf, com a mesma descrição, não vai aparecer
                            }
                        }
                        if(!$reminderAlreadyExists) {


                            //Mail to user
                            $mj = new \Mailjet\Client('9b7520c7fe890b48c2753779066eb9ac','b8f16fd81c883fc77bb1f3f4410b2b02',true,['version' => 'v3.1']);
                            $body = [
                            'Messages' => [
                                [
                                'From' => [
                                    'Email' => "mailsenderhr@gmail.com",
                                    'Name' => "ImprooveHR"
                                ],
                                'To' => [
                                    [
                                    'Email' => "andresl19972@gmail.com",
                                    'Name' => User::find($userNotf->receiveUserId)->name,
                                    ]
                                ],
                                'Subject' => "Evaluation time is up",
                                'TextPart' => "My first Mailjet email",
                                'HTMLPart' => "<h3>Dear ".User::find($userNotf->receiveUserId)->name.", you have 1 day remaining to complete your survey from ". User::find($userNotf->createUserId)->name.". Hurry up!</h3><br/>!",
                                'CustomID' => "AppGettingStartedTest"
                                ]
                            ]
                            ];
                            $response = $mj->post(Resources::$Email, ['body' => $body]);
                            $response->success();

                            //

                            $newReminder = new notifications_reminders; //nova notificacao
                            $newReminder->notifications_users_id = $userNotf->id;
                            $newReminder->description = $reminderDescription;
                            $newReminder->save();



                        }

                    }
                }

            }
            //notification evals end

            //notifications birthdays
            $userBdays= User::All();
            $notificationsUserBirthdays = NotificationsUsers::All();

             foreach($userBdays as $bday) {
                $notfExists = false;
                 foreach($notificationsUserBirthdays as $notfsUser) {
                     $notification = notifications::find($notfsUser->notificationId);
                     if($notfsUser->receiveUserId == Auth::User()->id && $notification->type == "Birthday" && date('Y-m',strtotime($notfsUser->created_at)) == date('Y-m')) {
                         //caso a notificacao esteja associada ao user logado, for um birthday, e tiver sido criado no mês actual, é porque já existe
                         //senão, como inserimos sempre uma notf nova associada ao user logado, ele cria uma individualmente quando faz login apenas
                        $notfExists = true;
                        break;
                     }
                 }
                 if(!$notfExists) {
                    if(date('d-m',strtotime($bday->birthDate)) == date('d-m') && Auth::user()->id == $bday->id) {
                        $newNotification = new notifications;
                        $newNotification->type = "Birthday";
                        $newNotificationUser = new NotificationsUsers;
                        $newNotification->description = "Happy birthday ".$bday->name."!";
                        $newNotification->save();
                        $newNotificationUser->notificationId = $newNotification->id;
                        $newNotificationUser->receiveUserId = Auth::user()->id; //salva sempre como o user logado asim que carrega a pag
                        $newNotificationUser->save();
                    }
                    else if(date('d-m',strtotime($bday->birthDate)) == date('d-m')) {
                            $newNotification = new notifications;
                            $newNotification->type = "Birthday";
                            $newNotificationUser = new NotificationsUsers;
                            $newNotification->description = "Today is ".$bday->name."'s birthday";
                            $newNotification->save();
                            $newNotificationUser->notificationId = $newNotification->id;
                            $newNotificationUser->receiveUserId = Auth::User()->id; //salva sempre como o user logado asim que carrega a pag
                            $newNotificationUser->save();


                    }
                    else if(date('d-m-Y',strtotime($bday->birthDate . "-1 days")) == date('d-m-Y')) {
                            $newNotification = new notifications;
                            $newNotification->type = "Birthday";
                            $newNotificationUser = new NotificationsUsers;
                            $newNotification->description = "Tomorrow will be ".$bday->name."'s birthday!";
                            $newNotification->save();
                            $newNotificationUser->notificationId = $newNotification->id;
                            $newNotificationUser->receiveUserId = Auth::User()->id; //salva sempre como o user logado asim que carrega a pag
                            $newNotificationUser->save();

                    }
                }





             }
             //notifications Birthdays end



        //Notifications end


        return view('admin.dashboard',compact('vacationDaysAvailable','vacations_total','diasAusencia', 'events', 'msg', 'totalHoursTodoCurrentWeek', 'totalHours'));
        // return view('testeAbsencesCount')->with('absences', $diasAusencia);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit(absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(absence $absence)
    {
        //
    }
}
