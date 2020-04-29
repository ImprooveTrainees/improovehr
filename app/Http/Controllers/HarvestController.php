<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sliderView;

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



        $allAbsences = sliderView::All()->where('Absence Type', '!=', 'null');
        foreach($allAbsences as $absence) {
            echo $absence->{'Absence Type'};
        }


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

$mondayTotal = 0;
$tuesdayTotal = 0;  
$wednesdayTotal = 0; 
$thursdayTotal = 0; 
$fridayTotal = 0; 
$totalHours = 0;

for($i = 0; $i  < count($result2->time_entries); $i++) {
    if($result2->time_entries[$i]->spent_date == $monday) {
        $mondayTotal += $result2->time_entries[$i]->hours;
        $totalHours += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $tuesday) {
        $tuesdayTotal += $result2->time_entries[$i]->hours;
        $totalHours += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $wednesday) {
        $wednesdayTotal += $result2->time_entries[$i]->hours;
        $totalHours += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $thursday) {
        $thursdayTotal += $result2->time_entries[$i]->hours;
        $totalHours += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $friday) {
        $fridayTotal += $result2->time_entries[$i]->hours;
        $totalHours += $result2->time_entries[$i]->hours;
    
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

$mondayLastWTotal = 0;
$tuesdayLastWTotal = 0;  
$wednesdayLastWTotal = 0; 
$thursdayLastWTotal = 0; 
$fridayLastWTotal = 0;
for($i = 0; $i  < count($result2->time_entries); $i++) {
    if($result2->time_entries[$i]->spent_date == $mondayLastW) {
        $mondayLastWTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $tuesdayLastW) {
        $tuesdayLastWTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $wednesdayLastW) {
        $wednesdayLastWTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $thursdayLastW) {
        $thursdayLastWTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $fridayLastW) {
        $fridayLastWTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
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

$mondayLast2WTotal = 0;
$tuesdayLast2WTotal = 0;  
$wednesdayLast2WTotal = 0; 
$thursdayLast2WTotal = 0; 
$fridayLast2WTotal = 0; 

for($i = 0; $i  < count($result2->time_entries); $i++) {
    if($result2->time_entries[$i]->spent_date == $mondayLast2W) {
        $mondayLast2WTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $tuesdayLast2W) {
        $tuesdayLast2WTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $wednesdayLast2W) {
        $wednesdayLast2WTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $thursdayLast2W) {
        $thursdayLast2WTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
    }
    if($result2->time_entries[$i]->spent_date == $fridayLast2W) {
        $fridayLast2WTotal += $result2->time_entries[$i]->hours;
        $totalHours15days += $result2->time_entries[$i]->hours;
    
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
    ->with('monday', $monday)
    ->with('tuesday', $tuesday)
    ->with('wednesday', $wednesday)
    ->with('thursday', $thursday)
    ->with('friday', $friday)
    ->with('mondayTotal',$mondayTotal)
    ->with('tuesdayTotal',$tuesdayTotal)
    ->with('wednesdayTotal',$wednesdayTotal)
    ->with('thursdayTotal',$thursdayTotal)
    ->with('fridayTotal',$fridayTotal)
    ->with('totalHours',$totalHours)
    ->with('last2weeks', $last2weeks)
    ->with('lastWeek', $lastWeek)
    ->with('mondayLastWTotal', $mondayLastWTotal)
    ->with('tuesdayLastWTotal', $tuesdayLastWTotal)
    ->with('wednesdayLastWTotal', $wednesdayLastWTotal)
    ->with('thursdayLastWTotal', $thursdayLastWTotal)
    ->with('fridayLastWTotal', $fridayLastWTotal)
    ->with('mondayLast2WTotal',$mondayLast2WTotal)
    ->with('tuesdayLast2WTotal',$tuesdayLast2WTotal)
    ->with('wednesdayLast2WTotal',$wednesdayLast2WTotal)
    ->with('thursdayLast2WTotal',$thursdayLast2WTotal)
    ->with('fridayLast2WTotal',$fridayLast2WTotal)
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
