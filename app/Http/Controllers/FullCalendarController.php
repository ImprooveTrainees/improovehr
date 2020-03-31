<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sliderView;
use Redirect,Response;

class FullCalendarController extends Controller
{
    public function index()
    {
      
        $events = sliderView::all();
        return view('testeCalendar', compact('events'));
        
    }
    
   
   

}