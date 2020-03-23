<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use App\sliderView;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $cDays = DB::table('users')
        //     ->join('contracts', 'contracts.iduser', '=', 'users.id')
        //     ->select(DB::raw('users.name', 'Contract Begin', 'null', 'contracts.start_date', 'null'));

        // $bDays = DB::table('users')
        //  ->select(DB::raw('users.name', 'Birthday', 'null', 'birthDate', 'null'));

        //  $absDays = DB::table('users')
        //  ->join('absences', 'users.id', '=', 'absences.iduser')
        //  ->join('absence_types', 'absences.absencetype', '=', 'absence_types.id')
        //  ->where('absences.status','=','Approved')
        //  ->select(DB::raw('users.name', 'Absence', 'absences.motive', 'absences.start_date', 'absences.end_date'));

        // $query2 = DB::table('users')
        // ->select(DB::raw('Name', 'Type', 'Absence Motive', 'Date', 'DateEnd Absence'))
        // ->union($cDays)
        // ->union($bDays)
        // ->union($absDays)
        // ->get();

    
        $eventos = DB::table('sliderView')
        ->select('*')
        ->get();
        
        $actualDate = date("Y/m/d");
        $msg = "";
        for($i = 1; $i < count($eventos); $i++) {
            $today = date("Y/m/d");
            $today = date('Y-m-d', strtotime($today));
            $eventDate = date('Y-m-d',strtotime($eventos[$i]->Date));
            if($eventDate < $today) { //filtro para mostrar apenas todos os eventos futuros da data actual
                continue;
            }
            if($eventos[$i]->{"DateEnd Absence"} != null) {
                $absenceDateEnd = date('Y-m-d',strtotime($eventos[$i]->{"DateEnd Absence"}));
            }
            else {
                $absenceDateEnd = "";
            }
            if($eventos[$i]->Type == "Birthday") {
                if($eventDate == $actualDate) {
                    $msg .= $eventos[$i]->Photo."<br>";
                    $msg .= "Happy birthday ".$eventos[$i]->Name."!"."<br>";
                }
                else {
                    $msg .= $eventos[$i]->Photo."<br>";
                    $msg .= $eventos[$i]->Name."'s birthday!"."<br>";
                    $msg .= "Date: ".$eventos[$i]->Date;
                    
                }
                $msg .= "<br>";
                $msg .= "<br>";               
            }
            else if($eventos[$i]->Type == "Absence" && $eventos[$i]->{"Absence Motive"} == "") {
                $msg .= $eventos[$i]->Photo."<br>";
                $msg .= $eventos[$i]->Name . "<br>" . "Vacations: ".$eventDate;
                $msg .= " - ". $absenceDateEnd;
                $msg .= "<br>";
                $msg .= "<br>";
            }
            else if($eventos[$i]->Type == "Contract Begin") {
                if($eventDate == $actualDate) {
                    $msg .= $eventos[$i]->Photo."<br>";
                    $msg .=  "Today is ".$eventos[$i]->Name. "'s company birthday!";
                }
                else {
                    $msg .= $eventos[$i]->Photo."<br>";
                    $msg .= $eventos[$i]->Name."'s company birthday!";
                    $msg .= "<br>";
                    $msg .= "Date: ".$eventDate;
                }
                $msg .= "<br>";
                $msg .= "<br>";

            }
            else {
                $msg .= $eventos[$i]->Photo."<br>";
                $msg .= "Name: ".$eventos[$i]->Name."<br>";
                // $msg .= "Type: ".$eventos[$i]->Type."<br>";
                if($eventos[$i]->{"Absence Motive"} == null){
                    $msg .= "";
                }
                else {
                    $msg .= $eventos[$i]->{"Absence Motive"}."<br>";
                }
                $msg .= "Date: ".$eventDate."<br>";
                $msg .= "End Date: ".$absenceDateEnd."<br>";
                $msg .= "<br>";
                $msg .= "<br>";
            }
            
        }

        //
        // $bdays = DB::table('users')->orderBy('birthDate', 'desc')->get();

        // $bdaysDates = [];
        // foreach($bdays as $birthdate){
        //     array_push($bdaysDates, $birthdate->name);
        //     array_push($bdaysDates, $birthdate->birthDate);
        // }


        // $contractsBegin = DB::table('users')
        // ->join('contracts','users.id','=','contracts.iduser')
        // ->select('users.name', 'contracts.start_date')
        // ->orderBy('contracts.start_date', 'desc')
        // ->get();
        // $contractDates = [];

        // foreach($contractsBegin as $contdate){
        //     array_push($contractDates, $contdate->name);
        //     array_push($contractDates, $contdate->start_date);
        // }

        // $absences = DB::table('users')
        // ->join('absences', 'users.id', '=', 'absences.iduser')
        // ->join('absence_types', 'absences.absencetype', '=', 'absence_types.id')
        // ->where('absences.status', '=', 'Approved')
        // ->select('users.name', 'absence_types.description','absences.status','absences.motive','absences.start_date','absences.end_date')
        // ->orderBy('absences.start_date', 'desc')
        // ->get();

        // $absenceDates = [];

        // foreach($absences as $abs){
        //     array_push($absenceDates, $abs->name);
        //     array_push($absenceDates, $abs->motive);
        //     $dtBegin = new DateTime($abs->start_date);
        //     $dtEnd = new DateTime($abs->end_date);
        //     $dtBeginYear = $dtBegin->format('Y-m-d'); //converte o datetime em date
        //     $dtEndYear = $dtEnd->format('Y-m-d'); //converte o datetime em date
        //     array_push($absenceDates, $dtBeginYear);
        //     array_push($absenceDates, $dtEndYear);
        // }



        return view('testeSlider')->with('msg', $msg);
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
