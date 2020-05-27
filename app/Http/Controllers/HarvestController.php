<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\absence;
use App\settings_general;
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


        $workHoursSettings = settings_general::orderBy('created_at', 'desc')->first();

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


//end Holidays API

$month = date('F');


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


//endcurrentweek

$totalHours15days = 0;
$totalHoursDone15daysThisMonth = 0;




//last week vars
$lastWeek = date( 'F d', strtotime( '-1 week monday this week' ) )." | ". date( 'F d', strtotime( '-1 week sunday this week' ) )." ".date('Y');

$daysLastWeek = [];
$lastWeekTotals = [];

for($b = $workHoursSettings->flextime_startDay-1; $b < $workHoursSettings->flextime_endDay; $b++) 
{
    array_push($daysLastWeek,date('Y-m-d', strtotime( '-1 week monday this week +'.$b.' days')));
    array_push($lastWeekTotals, 0);
}






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



//endlastweek

//last 2 weeks vars
$last2weeks = date( 'F d', strtotime( '-2 week monday this week' ) )." | ". date( 'F d', strtotime( '-2 week sunday this week' ) )." ".date('Y');

$daysLast2Weeks = [];
$last2WeeksTotals = [];

for($b = $workHoursSettings->flextime_startDay-1; $b < $workHoursSettings->flextime_endDay; $b++) 
{
    array_push($daysLast2Weeks,date('Y-m-d', strtotime( '-2 week monday this week +'.$b.' days')));
    array_push($last2WeeksTotals, 0);
}




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

$dateRangeLastWeek = new DatePeriod(
    new DateTime($daysLast2Weeks[0]),
    new DateInterval('P1D'),
    new DateTime(date( "Y-m-d", strtotime(end($daysLastWeek) . '+1 day')))
);


foreach ($dateRangeLastWeek as $key => $value) { 
    if($value->format('w') != 6 && $value->format('w') != 0) { // se não for weekend
        foreach($workingDays as $wDays) { //e for um dia de trabalho definido nas settings
            if($value->format('w') == $wDays) {
                foreach($allAbsences as $abs) { // e não for férias
                    $dateStartAbsence = date('Y-m-d',strtotime($abs->start_date));
                    $dateEndAbsence = date('Y-m-d',strtotime('+1 day', strtotime($abs->end_date)));
                    $AbsenceDatesBetween = new DatePeriod(
                        new DateTime($dateStartAbsence),
                        new DateInterval('P1D'),
                        new DateTime($dateEndAbsence)
                   );
                   foreach($AbsenceDatesBetween as $key => $value2) {
                       if($value->format('Y-m-d') == $value2->format('Y-m-d') && $abs->absencetype == 1) {
                           $monthlyHoursWorkDays-= $workHoursSettings->flextime_dailyHours; //tira as horas do total do mês que o user deveria fazer, quando o user está de férias
                           continue 4;
                       }
                   }
                }
                $totalHoursTodoPast2Weeks += $workHoursSettings->flextime_dailyHours;
                if($value->format('m') == date('m')) {
                    $totalHoursTodoPast2WeeksThisMonth += $workHoursSettings->flextime_dailyHours; //horas para fazer do mês actual nas ultimas 2 semanas
                }
                foreach($resultHolidays as $holiday) {  // e nao fôr feriado
                    if($holiday->date == $value->format('Y-m-d')) {
                        $totalHoursTodoPast2Weeks -= $workHoursSettings->flextime_dailyHours;
                        if($value->format('m') == date('m')) {
                            $totalHoursTodoPast2WeeksThisMonth -= $workHoursSettings->flextime_dailyHours;
                        }
                    }
                }
            } 
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
        $totalHoursToDoLastMonth+= $workHoursSettings->flextime_dailyHours;
        foreach($resultHolidays as $holiday) { //se não for fim de semana mas fôr feriado, retira as horas
            if($holiday->date == $value->format('Y-m-d')) {
                $totalHoursToDoLastMonth-= $workHoursSettings->flextime_dailyHours;
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
    ->with('workHoursSettings', $workHoursSettings)
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
