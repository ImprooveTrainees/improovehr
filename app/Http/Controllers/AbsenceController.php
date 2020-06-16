<?php

namespace App\Http\Controllers;

use App\absence;
use App\notifications;
use App\NotificationsUsers;
use App\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\sliderView;
use Redirect,Response;
use Carbon\Carbon;

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

        $noNotification = false;

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

        foreach($listAbsencesTotal as $list) {

            $dayBefore = Carbon::now()->subDays(1);

            $startDate = Carbon::parse($list->start_date);

            $difference = $dayBefore->diffInDays($startDate);

            if($difference <= 1) {

                if($list->status == "Approved") {

                    if($roleuser>1 && $roleuser<=3) {

                        $descricao = $list->name." will be absent tomorrow from ".$list->start_date." to ".$list->end_date." .";

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

        $noNotification = false;

        foreach($listVacationsTotal as $list) {


            $dayBefore = Carbon::now()->subDays(1);

            $startDate = Carbon::parse($list->start_date);

            $difference = $dayBefore->diffInDays($startDate);

            if($difference <= 1) {

                if($list->status == "Approved") {

                    if($roleuser>1 && $roleuser<=3) {

                        $descricao = $list->name." will be on vacations tomorrow from ".$list->start_date." to ".$list->end_date." .";

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

            $days = $to->diffInWeekdays($from);

            if($available_days < $days) {

                return redirect('/holidays')->withErrors('You only have '.$available_days.' vacation days available. Please do not exceed your vacation days.');

            } else if($to < $from) {

                return redirect('/holidays')->withErrors('Error! End Date can not be inferior to Start Date.');

            } else {

                $vacation->iduser=$userid;
                $vacation->absencetype=1;
                $vacation->attachment="";
                $vacation->status="Pending";
                $vacation->start_date = request('start_date');
                $vacation->end_date = request('end_date');
                $vacation->motive = "";

                $vacation->save();

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

            if($to < $from) {

                return redirect('/holidays')->withErrors('Error! End Date can not be inferior to Start Date.');

            } else {

                $absence->iduser=$userid;
                $absence->absencetype=6;
                $absence->attachment="";
                $absence->status="Pending";
                $absence->start_date = request('start_date');
                $absence->end_date = request('end_date');
                $absence->motive = "";

                $absence->save();

                if($roleuser>2) {

                    $notification->type="Absences";
                $notification->description=$username." created an absence. Waiting for Approval.";

                    $notification->save();

                    $id_notif = notifications::orderBy('created_at','desc')->first()->id;

                    $notif_user->notificationId=$id_notif;
                    $notif_user->createUserId=$userid;
                    $notif_user->receiveUserId=$managerId;

                    $notif_user->save();

                }

            }

        } else if($op==3) {

            $start_date = request('upd_start_date');

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['start_date' => $start_date]);

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['status' => 'Pending']);

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

        } else if($op==4) {

            $end_date = request('upd_end_date');

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['end_date' => $end_date]);

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['status' => 'Pending']);

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

            $start_datetime = request('upd_start_datetime');

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['start_date' => $start_datetime]);

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['status' => 'Pending']);

            if($roleuser>2) {

                $notification->type="Vacations";
                $notification->description=$username." updated start date of created absences. Waiting for Approval.";

                $notification->save();

                    $id_notif = notifications::orderBy('created_at','desc')->first()->id;


                    $notif_user->notificationId=$id_notif;
                    $notif_user->createUserId=$userid;
                    $notif_user->receiveUserId=$managerId;

                    $notif_user->save();

            }

        } else if($op==6) {

            $end_datetime = request('upd_end_datetime');

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['end_date' => $end_datetime]);

            DB::table('absences')
            ->where('id', $updValue)
            ->update(['status' => 'Pending']);

            if($roleuser>2) {

                $notification->type="Vacations";
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
            ->select('users.id')
            ->value('id');

            $typeAbsence = DB::table('absences')
            ->where('absences.id','=',$updValue)
            ->select('absences.absencetype')
            ->value('absencetype');

            $notification->type="Approval";

            if($typeAbsence > 1) {

                $notification->description=$username." approved one of your vacations.";

            } else {

                $notification->description=$username." approved one of your absences.";

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
            ->select('users.id')
            ->value('id');

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

        $user = Auth::user();

        $id_user = Auth::user()->id;

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

        $holidays = [

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
            Carbon::create(2020, 12, 31)


        ];


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

        }

        //$count_days = $days;

        $count_days += 1; //Number of vacation days already spent this year

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

        }

        $count_days2 += 1; //Number of vacation days already spent from last year


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

        if($vacations_total > 30) {

            $vacations_total = 30;

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
        $msg .= "<div class='carousel-item active'>";
    }
     else {
         $msg .= "<div class='carousel-item'>";
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


            $msg .= "<div class='col-md-4'>";
                $msg .= "<div class='card mb-2'>";

            if($eventos[$i]->{"DateEnd Absence"} != null) {
                $absenceDateEnd = date('Y-m-d',strtotime($eventos[$i]->{"DateEnd Absence"}));
            }
            else {
                $absenceDateEnd = "";
            }
            if($eventos[$i]->Type == "Birthday") {
                if(date('d/m',strtotime($eventos[$i]->Date)) == date('d/m')) {
                    $msg .= "<img class='card-img-top sliderResize' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                    $msg .= "<div class='card-body'>";
                    $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                    $msg .= "<p class='card-text'>Happy birthday ".$eventos[$i]->Name."! </p>";
                    // <a class="btn btn-primary">Button</a>
                  $msg.= "</div>";
                }
                else {
                    $msg .= "<img class='card-img-top sliderResize' src=".$eventos[$i]->Photo." alt='Card image cap'>";
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
                $msg .= "<img class='card-img-top sliderResize' src=".$eventos[$i]->Photo." alt='Card image cap'>";
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
                    $msg .= "<img class='card-img-top sliderResize' src=".$eventos[$i]->Photo." alt='Card image cap'>";
                    $msg .= "<div class='card-body'>";
                    $msg .= "<h4 class='card-title'>".$eventos[$i]->Name."</h4>";
                    $msg .= "<p class='card-text'> Today is ".$eventos[$i]->Name. "'s company birthday!";
                    $msg .= "<br>";
                    $msg .= "Date: ".date('d/m',strtotime($eventos[$i]->Date));
                    $msg .= "</p>";
                    $msg.= "</div>";
                }
                else {
                    $msg .= "<img class='card-img-top sliderResize' src=".$eventos[$i]->Photo." alt='Card image cap'>";
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
                $msg .= "<img class='card-img-top sliderResize' src=".$eventos[$i]->Photo." alt='Card image cap'>";
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

// Slider End


//Flextime begin
/* $ch2 = curl_init();

        curl_setopt($ch2, CURLOPT_URL, 'https://api.harvestapp.com/v2/time_entries');
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers2 = array();
        $headers2[] = 'Harvest-Account-Id: 1287235';
        $headers2[] = 'Authorization: Bearer 2303952.pt.xaKulkdplacNlAb2W77kLcNyen2H3RUsxQgzVgndlSypJP0bE8EUcHw-bWeq6AYqWVL4l0-uwd9J1VGi5A32bw';
        $headers2[] = 'User-Agent: ImprooveHR(andre.lopes@gmail.com)';
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

        $result2 = curl_exec($ch2);
        if (curl_errno($ch2)) {
            echo 'Error:' . curl_error($ch2);
        }
        curl_close($ch2);

        $result2 = json_decode($result2);


        //end Time entries Harvest

        $totalHours = 0;
        $monday = date( 'Y-m-d', strtotime( 'monday this week'));
        $tuesday = date( 'Y-m-d', strtotime( 'tuesday this week'));
        $wednesday = date( 'Y-m-d', strtotime( 'wednesday this week'));
        $thursday = date( 'Y-m-d', strtotime( 'thursday this week'));
        $friday = date( 'Y-m-d', strtotime( 'friday this week'));

        for($i = 0; $i  < count($result2->time_entries); $i++) {
            if($result2->time_entries[$i]->spent_date == $monday) {
                $totalHours += $result2->time_entries[$i]->hours;

            }
            if($result2->time_entries[$i]->spent_date == $tuesday) {

                $totalHours += $result2->time_entries[$i]->hours;

            }
            if($result2->time_entries[$i]->spent_date == $wednesday) {

                $totalHours += $result2->time_entries[$i]->hours;

            }
            if($result2->time_entries[$i]->spent_date == $thursday) {
                $totalHours += $result2->time_entries[$i]->hours;

            }
            if($result2->time_entries[$i]->spent_date == $friday) {
                $totalHours += $result2->time_entries[$i]->hours;

            }


            } */



//FlexTime End


        $request->session()->put('vacationDays', $vacationDaysAvailable);

        //$_SESSION["vacationDays"] = $vacationDaysAvailable;

        //session(['vacationDays' => $vacationDaysAvailable]);



        return view('admin.dashboard',compact('vacationDaysAvailable','vacations_total','diasAusencia', 'events', 'msg'));
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
