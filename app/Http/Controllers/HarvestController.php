<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\absence;
use Auth;
use DatePeriod;
use DateTime;
use DateInterval;

class HarvestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        // header("Content-Type: application/json");



        $allAbsences = absence::All()->where('status', '=', 'Concluded')->where('iduser', '=', Auth::User()->id);


        //Profile info harvest API
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.harvestapp.com/v2/users/me');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        
        $headers = array();
        $headers[] = 'Harvest-Account-Id: 1287235';
        $headers[] = 'Authorization: Bearer 2303952.pt.xaKulkdplacNlAb2W77kLcNyen2H3RUsxQgzVgndlSypJP0bE8EUcHw-bWeq6AYqWVL4l0-uwd9J1VGi5A32bw';
        $headers[] = 'User-Agent: ImprooveHR(andre.lopes@gmail.com)';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

      
        $result = json_decode($result); //transforma json em objecto
        //End profile info Harvest API


        //Time entries Harvest API
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.harvestapp.com/v2/time_entries');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Harvest-Account-Id: 1287235';
        $headers[] = 'Authorization: Bearer 2303952.pt.xaKulkdplacNlAb2W77kLcNyen2H3RUsxQgzVgndlSypJP0bE8EUcHw-bWeq6AYqWVL4l0-uwd9J1VGi5A32bw';
        $headers[] = 'User-Agent: ImprooveHR(andre.lopes@gmail.com)';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result2 = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $result2 = json_decode($result2);



//end Time entries Harvest API


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


//$actualMonthDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date("Y"));
$monthBegin = new DateTime('first day of this month');
$monthEnd = new DateTime('tomorrow'); //ele inclui a start date, mas não a end date, portanto adicionamos mais um dia
$monthlyHoursWorkDays = 0;
$dateRangeCountWeekends = new DatePeriod(
    new DateTime($monthBegin->format('Y-m-d')),
    new DateInterval('P1D'),
    new DateTime($monthEnd->format('Y-m-d'))
);


foreach ($dateRangeCountWeekends as $key => $value) {
    if($value->format('w') != 6 && $value->format('w') != 0) { //retira as horas dos fim de semanas do mês actual
        $monthlyHoursWorkDays+=8;
        foreach($resultHolidays as $holiday) { //se não for fim de semana mas fôr feriado, retira as horas
            if($holiday->date == $value->format('Y-m-d')) {
                $monthlyHoursWorkDays-=8;
            }
        }
    }
}


//end Holidays API

$month = date('F');


//this week vars
$currentWeek = date( 'F d', strtotime( 'monday this week' ) )." | ". date( 'F d', strtotime( 'sunday this week' ) )." ".date('Y'); 
$monday = date( 'Y-m-d', strtotime( 'monday this week'));
$tuesday = date( 'Y-m-d', strtotime( 'tuesday this week'));
$wednesday = date( 'Y-m-d', strtotime( 'wednesday this week'));
$thursday = date( 'Y-m-d', strtotime( 'thursday this week'));
$friday = date( 'Y-m-d', strtotime( 'friday this week'));

$daysCurrentWeek = [$monday, $tuesday, $wednesday, $thursday, $friday];

$mondayTotal = 0;
$tuesdayTotal = 0;  
$wednesdayTotal = 0; 
$thursdayTotal = 0; 
$fridayTotal = 0; 
$totalHours = 0;


$totalsCurrentWeek = [$mondayTotal, $tuesdayTotal,$wednesdayTotal,$thursdayTotal,$fridayTotal];

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
    new DateTime($monday),
    new DateInterval('P1D'),
    new DateTime(date( 'Y-m-d', strtotime( 'saturday this week')))
);


foreach ($dateRangeCurrentWeek as $key => $value) { 
        $totalHoursTodoCurrentWeek+=8;
        foreach($resultHolidays as $holiday) { 
            if($holiday->date == $value->format('Y-m-d')) {
                $totalHoursTodoCurrentWeek-=8;
            }
        }
    
}


//endcurrentweek

$totalHours15days = 0;
$totalHoursDone15daysThisMonth = 0;




//last week vars
$lastWeek = date( 'F d', strtotime( '-1 week monday this week' ) )." | ". date( 'F d', strtotime( '-1 week sunday this week' ) )." ".date('Y');
$mondayLastW = date( 'Y-m-d', strtotime( '-1 week monday this week'));
$tuesdayLastW = date( 'Y-m-d', strtotime( '-1 week tuesday this week'));
$wednesdayLastW = date( 'Y-m-d', strtotime( '-1 week wednesday this week'));
$thursdayLastW = date( 'Y-m-d', strtotime( '-1 week thursday this week'));
$fridayLastW = date( 'Y-m-d', strtotime( '-1 week friday this week'));

$daysLastWeek = [$mondayLastW,$tuesdayLastW,$wednesdayLastW,$thursdayLastW,$fridayLastW];

$mondayLastWTotal = 0;
$tuesdayLastWTotal = 0;  
$wednesdayLastWTotal = 0; 
$thursdayLastWTotal = 0; 
$fridayLastWTotal = 0;

$lastWeekTotals = [$mondayLastWTotal, $tuesdayLastWTotal, $wednesdayLastWTotal, $thursdayLastWTotal, $fridayLastWTotal];


for($i = 0; $i  < count($result2->time_entries); $i++) {
    for($b = 0; $b < count($daysLastWeek); $b++) {
        foreach($allAbsences as $absence) {
            $dateStartAbsence = date('Y-m-d',strtotime($absence->start_date));
            $dateEndAbsence = date('Y-m-d',strtotime('+1 day', strtotime($absence->end_date)));
            $AbsenceDatesBetween = new DatePeriod(
                new DateTime($dateStartAbsence),
                new DateInterval('P1D'),
                new DateTime($dateEndAbsence)
           );
           foreach ($AbsenceDatesBetween as $key => $value) {
                if($value->format('Y-m-d') == $daysLastWeek[$b]) { 
                    if($absence->absencetype == 1) {
                        $lastWeekTotals[$b] = "Vacations";
                        continue 3; //após confirmado que é ausência, passa para o prox dia
                    }
                    else {
                        $lastWeekTotals[$b] = $absence->motive;
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
            if($holiday->date == $daysLastWeek[$b]) {
                $lastWeekTotals[$b] = $holiday->localName;
                continue 2;
            }
        }
        if($result2->time_entries[$i]->spent_date == $daysLastWeek[$b]) {
                $lastWeekTotals[$b] += $result2->time_entries[$i]->hours;
                if(date("F", strtotime($daysLastWeek[$b])) == date("F")) {
                    $totalHoursDone15daysThisMonth += $result2->time_entries[$i]->hours;
                    //guarda apenas as horas do mês actual das passadas duas semanas
                }

                $totalHours15days += $result2->time_entries[$i]->hours;
        }

    
    }

}

$totalHoursTodoPast2Weeks = 0;
$totalHoursTodoPast2WeeksThisMonth = 0;

$dateRangeLastWeek = new DatePeriod(
    new DateTime(date( 'Y-m-d', strtotime( '-2 week monday this week'))),
    new DateInterval('P1D'),
    new DateTime(date( 'Y-m-d', strtotime( '-1 week saturday this week')))
);


foreach ($dateRangeLastWeek as $key => $value) { 
    if($value->format('w') != 6 && $value->format('w') != 0) {
        $totalHoursTodoPast2Weeks +=8;
        if($value->format('m') == date('m')) {
            $totalHoursTodoPast2WeeksThisMonth += 8; //horas para fazer do mês actual nas ultimas 2 semanas
        }
        foreach($resultHolidays as $holiday) { 
            if($holiday->date == $value->format('Y-m-d')) {
                $totalHoursTodoPast2Weeks -= 8;
                if($value->format('m') == date('m')) {
                    $totalHoursTodoPast2WeeksThisMonth -= 8;
                }
            }
        }
     }
}


//endlastweek

//last 2 weeks vars
$last2weeks = date( 'F d', strtotime( '-2 week monday this week' ) )." | ". date( 'F d', strtotime( '-2 week sunday this week' ) )." ".date('Y');
$mondayLast2W = date( 'Y-m-d', strtotime( '-2 week monday this week'));
$tuesdayLast2W = date( 'Y-m-d', strtotime( '-2 week tuesday this week'));
$wednesdayLast2W = date( 'Y-m-d', strtotime( '-2 week wednesday this week'));
$thursdayLast2W = date( 'Y-m-d', strtotime( '-2 week thursday this week'));
$fridayLast2W = date( 'Y-m-d', strtotime( '-2 week friday this week'));

$daysLast2Weeks = [$mondayLast2W,$tuesdayLast2W,$wednesdayLast2W,$thursdayLast2W,$fridayLast2W];

$mondayLast2WTotal = 0;
$tuesdayLast2WTotal = 0;  
$wednesdayLast2WTotal = 0; 
$thursdayLast2WTotal = 0; 
$fridayLast2WTotal = 0; 

$last2WeeksTotals = [$mondayLast2WTotal, $tuesdayLast2WTotal, $wednesdayLast2WTotal, $thursdayLast2WTotal, $fridayLast2WTotal];


for($i = 0; $i  < count($result2->time_entries); $i++) {
    for($b = 0; $b < count($daysLast2Weeks); $b++) {
        foreach($allAbsences as $absence) {
            $dateStartAbsence = date('Y-m-d',strtotime($absence->start_date));
            $dateEndAbsence = date('Y-m-d',strtotime('+1 day', strtotime($absence->end_date)));
            $AbsenceDatesBetween = new DatePeriod(
                new DateTime($dateStartAbsence),
                new DateInterval('P1D'),
                new DateTime($dateEndAbsence)
           );
           foreach ($AbsenceDatesBetween as $key => $value) {
                if($value->format('Y-m-d') == $daysLast2Weeks[$b]) { 
                    if($absence->absencetype == 1) {
                        $last2WeeksTotals[$b] = "Vacations";
                        continue 3; //após confirmado que é ausência, passa para o prox dia
                    }
                    else {
                        $last2WeeksTotals[$b] = $absence->motive;
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
            if($holiday->date == $daysLast2Weeks[$b]) {
                $last2WeeksTotals[$b] = $holiday->localName;
                continue 2;
            }
        }
        if($result2->time_entries[$i]->spent_date == $daysLast2Weeks[$b]) {
                $last2WeeksTotals[$b] += $result2->time_entries[$i]->hours;
                if(date("n", strtotime($daysLast2Weeks[$b])) == date("n")) {
                    $totalHoursDone15daysThisMonth += $result2->time_entries[$i]->hours;
                     //guarda apenas as horas do mês actual das passadas duas semanas
                }
                $totalHours15days += $result2->time_entries[$i]->hours;
        }

    
    }

}


//endLast2weeks


//beginLastMonth

$monthBegin = date( 'Y-m-d', strtotime( 'first day of last month'));
$monthEnd = date( 'Y-m-d', strtotime( 'first day of this month'));

$dateRangeLastMonth = new DatePeriod(
    new DateTime($monthBegin),
    new DateInterval('P1D'),
    new DateTime($monthEnd)
);

$daysPreviousMonth = [];
$daysPreviousMonthTotals = [];
$countTr = 0;
$countTh = 0; 
$totalHoursDoneLastMonth = 0;
$totalHoursToDoLastMonth = 0;

foreach ($dateRangeLastMonth as $key => $value) { 
    if($value->format('w') != 6 && $value->format('w') != 0) {
        array_push($daysPreviousMonth, $value);
    }
}


foreach ($dateRangeLastMonth as $key => $value) { 
    if($value->format('w') != 6 && $value->format('w') != 0) {
        array_push($daysPreviousMonthTotals, 0);
    }
}


foreach ($dateRangeLastMonth as $key => $value) {
    if($value->format('w') != 6 && $value->format('w') != 0) { //retira as horas dos fim de semanas do mês actual
        $totalHoursToDoLastMonth+=8;
        foreach($resultHolidays as $holiday) { //se não for fim de semana mas fôr feriado, retira as horas
            if($holiday->date == $value->format('Y-m-d')) {
                $totalHoursToDoLastMonth-=8;
            }
        }
    }
}




for($i = 0; $i  < count($result2->time_entries); $i++) {
    for($b = 0; $b < count($daysPreviousMonth); $b++) {
        foreach($allAbsences as $absence) {
            $dateStartAbsence = date('Y-m-d',strtotime($absence->start_date));
            $dateEndAbsence = date('Y-m-d',strtotime('+1 day', strtotime($absence->end_date)));
            $AbsenceDatesBetween = new DatePeriod(
                new DateTime($dateStartAbsence),
                new DateInterval('P1D'),
                new DateTime($dateEndAbsence)
           );
           foreach ($AbsenceDatesBetween as $key => $value) {
                if($value->format('Y-m-d') == $daysPreviousMonth[$b]->format('Y-m-d')) { 
                    if($absence->absencetype == 1) {
                        $daysPreviousMonthTotals[$b] = "Vacations";
                        continue 3; //após confirmado que é ausência, passa para o prox dia
                    }
                    else {
                        $daysPreviousMonthTotals[$b] = $absence->motive;
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
            if($holiday->date == $daysPreviousMonth[$b]->format('Y-m-d')) {
                $daysPreviousMonthTotals[$b] = $holiday->localName;
                continue 2;
            }
        }
        if($result2->time_entries[$i]->spent_date == $daysPreviousMonth[$b]->format('Y-m-d')) {
                $daysPreviousMonthTotals[$b] += $result2->time_entries[$i]->hours;
                $totalHoursDoneLastMonth += $result2->time_entries[$i]->hours;
        }

    
    }

}


//endLastMonth




$hoursReportedTotal = $totalHoursDone15daysThisMonth + $totalHours; //soma das horas reportadas deste mês, ultimas duas semanas + mês actual
$hoursLeftReport = $monthlyHoursWorkDays - $hoursReportedTotal; //total que falta para reportar do mês actual

$hoursToReportPer15Days = $totalHoursTodoPast2Weeks - $totalHours15days; //total para reportar nas ultimas 2 semanas


        

return view('testeHarvest')
    ->with('harvestProfile', $result)
    ->with('month', $month)
    ->with('currentWeek', $currentWeek)
    ->with('totalsCurrentWeek', $totalsCurrentWeek)
    ->with('totalHours',$totalHours)
    ->with('last2weeks', $last2weeks)
    ->with('last2WeeksTotals', $last2WeeksTotals)
    ->with('lastWeek', $lastWeek)
    ->with('lastWeekTotals', $lastWeekTotals)
    ->with('totalHours15days', $totalHours15days)
    ->with('hoursReportedTotal', $hoursReportedTotal)
    ->with('hoursLeftReport', $hoursLeftReport)
    ->with('hoursToReportPer15Days', $hoursToReportPer15Days)
    ->with('totalHoursTodoCurrentWeek', $totalHoursTodoCurrentWeek)
    ->with('totalHoursTodoPast2Weeks', $totalHoursTodoPast2Weeks)
    ->with('totalHoursDone15daysThisMonth', $totalHoursDone15daysThisMonth)
    ->with('totalHoursTodoPast2WeeksThisMonth', $totalHoursTodoPast2WeeksThisMonth)
    ->with('monthlyHoursWorkDays', $monthlyHoursWorkDays)
    ->with('daysPreviousMonth', $daysPreviousMonth)
    ->with('daysPreviousMonthTotals', $daysPreviousMonthTotals)
    ->with('totalHoursDoneLastMonth', $totalHoursDoneLastMonth)
    ->with('totalHoursToDoLastMonth', $totalHoursToDoLastMonth)
    ->with('countTr', $countTr)
    ->with('countTh', $countTh)
    ;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
