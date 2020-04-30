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


        //Profile info harvest
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.harvestapp.com/v2/users/me');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        
        $headers = array();
        $headers[] = 'Authorization: Bearer 2275709.pt.c6eIYJ4rw1djonReSiOhr9RfEdZCvvtVb_oBG0UaDhbaOx54c9dpzDrO9QgpG-SNuPutMguXIVx-b8UVE-tI9Q';
        $headers[] = 'Harvest-Account-Id: 1270741';
        $headers[] = 'User-Agent: ImprooveHR(andre.lopes@gmail.com)';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

      
        $result = json_decode($result); //transforma json em objecto
        //End profile info Harvest


        //Time entries Harvest
        $ch2 = curl_init();

        curl_setopt($ch2, CURLOPT_URL, 'https://api.harvestapp.com/v2/time_entries?user_id=3206639&');
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers2 = array();
        $headers2[] = 'Harvest-Account-Id: 1270741';
        $headers2[] = 'Authorization: Bearer 2275709.pt.c6eIYJ4rw1djonReSiOhr9RfEdZCvvtVb_oBG0UaDhbaOx54c9dpzDrO9QgpG-SNuPutMguXIVx-b8UVE-tI9Q';
        $headers2[] = 'User-Agent: ImprooveHR(andre.lopes@gmail.com)';
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

        $result2 = curl_exec($ch2);
        if (curl_errno($ch2)) {
            echo 'Error:' . curl_error($ch2);
        }
        curl_close($ch2);

        $result2 = json_decode($result2);



//end Time entries Harvest

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
$absenceExist = false;

for($i = 0; $i  < count($result2->time_entries); $i++) {
    for($b = 0; $b < count($daysCurrentWeek); $b++) {
        foreach($allAbsences as $absence) {
            $dateStartAbsence = date('Y-m-d',strtotime($absence->start_date));
            $dateEndAbsence = date('Y-m-d',strtotime($absence->end_date));
            $AbsenceDatesBetween = new DatePeriod(
                new DateTime($dateStartAbsence),
                new DateInterval('P1D'),
                new DateTime($dateEndAbsence)
           );
           foreach ($AbsenceDatesBetween as $key => $value) {
                if($value->format('Y-m-d') == $daysCurrentWeek[$b]) { 
                    $totalsCurrentWeek[$b] = $absence->motive;
                    $absenceExist = true;
                    //pega em todos os dias da absence (inclusive os que estão no meio) e 
                    //compara com o dia da semana do harvest. Caso se verifique que algum deles é igual, 
                    //é porque o user esteve ausente esses dias.
                }
                else if($result2->time_entries[$i]->spent_date == $daysCurrentWeek[$b]) {
                        $totalsCurrentWeek[$b] += $result2->time_entries[$i]->hours;
                        $totalHours += $result2->time_entries[$i]->hours;
                }
            }
             
            
        }

    
    }

}
//

$totalHours15days = 0;

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
        if($result2->time_entries[$i]->spent_date == $daysLastWeek[$b]) {
            $lastWeekTotals[$b] += $result2->time_entries[$i]->hours;
            $totalHours15days += $result2->time_entries[$i]->hours;
        }
    }
} 
//

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
        if($result2->time_entries[$i]->spent_date == $daysLast2Weeks[$b]) {
            $last2WeeksTotals[$b] += $result2->time_entries[$i]->hours;
            $totalHours15days += $result2->time_entries[$i]->hours;
        }
    }
    
}


//


$hoursReportedTotal = $totalHours15days + $totalHours;
$hoursLeftReport = 160 - $hoursReportedTotal;

$hoursToReportPer15Days = (160 / 2) - $totalHours15days;


        

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
    ->with('hoursToReportPer15Days', $hoursToReportPer15Days);

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
