<?php

namespace App\Http\Controllers;

use App\NotificationsUsers;
use App\notifications_reminders;
use App\notifications;
use Carbon\Carbon;


use Illuminate\Http\Request;

class NotificationsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function readNotification(Request $request)
    {
        //
        $msg = "";
        $notificationRead = filter_input(INPUT_GET, 'notfsRead', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        //filtra o input do ajax para array (porque queremos um conjunto de valores)
        foreach($notificationRead as $notfRead) {
            $notification = notifications::find($notfRead);
            if($notification->read_at == null) {   //se tiver nulo
                $notification->read_at = Carbon::now()->addHour()->toDateTimeString();
                $notification->save();
            }
    
        }
      



        // $msg = "";
        // $notificationRead = $request->input('notfsRead');
        //  foreach($notificationRead as $notfRead) {
        //          $msg .= $notfRead . "<br>";
        //     }
        //     echo $msg;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function readReminder(Request $request)
    {
        //
        $msg = "";
        $reminderRead = filter_input(INPUT_GET, 'remindersRead', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        //filtra o input do ajax para array (porque queremos um conjunto de valores)
        foreach($reminderRead as $remRead) {
            $reminder = notifications_reminders::find($remRead);
            if($reminder->read_at == null) {   //se tiver nulo
                $reminder->read_at = Carbon::now()->addHour()->toDateTimeString();
                $reminder->save();
            }
    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NotificationsUsers  $notificationsUsers
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationsUsers $notificationsUsers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NotificationsUsers  $notificationsUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationsUsers $notificationsUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NotificationsUsers  $notificationsUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationsUsers $notificationsUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NotificationsUsers  $notificationsUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationsUsers $notificationsUsers)
    {
        //
    }
}
