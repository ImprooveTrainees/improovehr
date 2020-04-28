<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

$mondayTotal = 0;
$tuesdayTotal = 0;  
$wednesdayTotal = 0; 
$thursdayTotal = 0; 
$fridayTotal = 0; 
$totalHours = 0;

//end Time entries Harvest

$month = date('F');
$currentWeek = date( 'F d', strtotime( 'monday this week' ) )." | ". date( 'F d', strtotime( 'sunday this week' ) )." ".date('Y'); 
$monday = date( 'Y-m-d', strtotime( 'monday this week'));
$tuesday = date( 'Y-m-d', strtotime( 'tuesday this week'));
$wednesday = date( 'Y-m-d', strtotime( 'wednesday this week'));
$thursday = date( 'Y-m-d', strtotime( 'thursday this week'));
$friday = date( 'Y-m-d', strtotime( 'friday this week'));

        
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

        return view('testeHarvest')
        ->with('harvestProfile', $result)
        ->with('harvestTimeInfo', $result2)
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
        ->with('totalHours',$totalHours);

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
