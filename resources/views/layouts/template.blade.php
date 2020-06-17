<?php
        namespace App\Http\Controllers;
        use App\notifications;
        use App\NotificationsUsers;
        use App\notifications_reminders;
        use Illuminate\Http\Request;
        use Auth;
        use DB;
        use App\User;
        $listNotifications = NotificationsUsers::orderBy('created_at', 'desc')->get();
        $notificationMessages = notifications::All();
        $allReminders = notifications_reminders::All();
        $id_user = Auth::user()->id;

        use App\sliderView;
        use App\settings_general;
        $settingsAlerts = settings_general::orderBy('created_at', 'desc')->first();
        $notificationsBirthdays = sliderview::where('Type', 'Birthday')->get();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">


        <title>@yield('title')</title>

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset ('assets/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset ('assets/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset ('assets/media/favicons/apple-touch-icon-180x180.png') }}">
        <link href="{{ asset ('https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet') }}">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Fonts and OneUI framework -->
        <link rel="stylesheet" href="{{ asset ('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset ('assets/css/oneui.min.css') }}">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
        <!-- END Stylesheets -->
        <link rel="stylesheet" href="{{asset ('main/main.css') }}">

        <link rel="stylesheet" href="{{asset ('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{asset ('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
        {{-- <link rel="stylesheet" href="{{asset ('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous') }}"> --}}
        <link rel="stylesheet" href="{{asset ('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css') }}" />
         <!-- Calendar -->
        <link href="{{asset ('assets/fullcalendar/core/main.css') }}" rel='stylesheet' />
        <link href="{{asset ('assets/fullcalendar/daygrid/main.css') }}" rel='stylesheet' />
        <link href="{{asset ('assets/fullcalendar/timegrid/main.css') }}" rel='stylesheet' />
        <link href="{{asset ('assets/fullcalendar/list/main.css') }}" rel='stylesheet' />

        <script src="{{asset('assets/fullcalendar/core/main.js') }}"></script>
        <script src="{{asset('assets/fullcalendar/daygrid/main.js') }}"></script>
        <script src="{{asset('assets/fullcalendar/timegrid/main.js') }}"></script>
        <script src="{{asset('assets/fullcalendar/interaction/main.js') }}"></script>
        <script src="{{asset('assets/fullcalendar/list/main.js') }}"></script>
        <script src="{{asset('https://kit.fontawesome.com/041a9ee086.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('https://code.jquery.com/jquery-3.4.1.min.js') }}" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    </head>
    <body>
        <!-- Page Container -->
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed">
            <!-- Side Overlay-->
            <aside id="side-overlay" class="font-size-sm">
                <!-- Side Header -->
                <div class="content-header border-bottom">
                    <!-- User Avatar -->
                    <a class="img-link mr-1" href="javascript:void(0)">
                        <img class="img-avatar img-avatar32" src="assets/media/avatars/avatar10.jpg" alt="">
                    </a>
                    <!-- END User Avatar -->

                    <!-- User Info -->
                    {{-- <div class="ml-2">
                        <a class="link-fx text-dark font-w600" href="javascript:void(0)">Administrator</a>
                    </div>
                    <!-- END User Info --> --}}

                    <!-- Close Side Overlay -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <a class="ml-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                    <!-- END Close Side Overlay -->
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="content-side">
                    <!-- Side Overlay Tabs -->
                    <div class="block block-transparent pull-x pull-t">
                        <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#so-section1">
                                    <i class="fa fa-fw fa-link text-gray mr-1"></i> Section 1
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#so-section2">
                                    <i class="fa fa-fw fa-link text-gray mr-1"></i> Section 2
                                </a>
                            </li>
                        </ul>
                        <div class="block-content tab-content overflow-hidden">
                            <!-- Section 1 -->
                            <div class="tab-pane pull-x fade fade-left show active" id="so-section1" role="tabpanel">
                                <div class="block">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">Section 1</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                                <i class="si si-refresh"></i>
                                            </button>
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <p>
                                            ...
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- END Section 1 -->

                            <!-- Section 2 -->
                            <div class="tab-pane pull-x fade fade-right" id="so-section2" role="tabpanel">
                                <div class="block">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">Section 2</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                                <i class="si si-refresh"></i>
                                            </button>
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <p>
                                            ...
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- END Section 2 -->
                        </div>
                    </div>
                    <!-- END Side Overlay Tabs -->
                </div>
                <!-- END Side Content -->
            </aside>
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            <!--
                Sidebar Mini Mode - Display Helper classes

                Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                    If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

                Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
                Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
                Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
            -->
            <nav id="sidebar" aria-label="Main Navigation">
                <!-- Side Header -->
                <div class="content-header bg-white-5">
                    <!-- Logo -->
                    <a class="font-w600 text-dual" href="">
                    <img src="{{asset ('img/icon-improove.png') }}" alt="" srcset="" style="width: 30px;">
                        <span class="smini-hide">
                            <span class="font-w700 font-size-h5">Improove HR</span>
                        </span>
                    </a>
                    <!-- END Logo -->

                    <!-- Options -->
                    <div>
                        <!-- Color Variations -->
                        <div class="dropdown d-inline-block ml-3">
                            <a class="text-dual font-size-sm" id="sidebar-themes-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="si si-drop"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right font-size-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">
                                <!-- Color Themes -->
                                <!-- Layout API, functionality initialized in Template._uiHandleTheme() -->
                                <a class="dropdown-item d-flex align-items-center justify-content-between" data-toggle="theme" data-theme="default" href="#">
                                    <span>Default</span>
                                    <i class="fa fa-circle text-default"></i>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" data-toggle="theme" data-theme="assets/css/themes/amethyst.min.css" href="#">
                                    <span>Amethyst</span>
                                    <i class="fa fa-circle text-amethyst"></i>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" data-toggle="theme" data-theme="assets/css/themes/city.min.css" href="#">
                                    <span>City</span>
                                    <i class="fa fa-circle text-city"></i>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" data-toggle="theme" data-theme="assets/css/themes/flat.min.css" href="#">
                                    <span>Flat</span>
                                    <i class="fa fa-circle text-flat"></i>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" data-toggle="theme" data-theme="assets/css/themes/modern.min.css" href="#">
                                    <span>Modern</span>
                                    <i class="fa fa-circle text-modern"></i>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" data-toggle="theme" data-theme="assets/css/themes/smooth.min.css" href="#">
                                    <span>Smooth</span>
                                    <i class="fa fa-circle text-smooth"></i>
                                </a>
                                <!-- END Color Themes -->

                                <div class="dropdown-divider"></div>

                                <!-- Sidebar Styles -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <a class="dropdown-item" data-toggle="layout" data-action="sidebar_style_light" href="#">
                                    <span>Sidebar Light</span>
                                </a>
                                <a class="dropdown-item" data-toggle="layout" data-action="sidebar_style_dark" href="#">
                                    <span>Sidebar Dark</span>
                                </a>
                                <!-- Sidebar Styles -->

                                <div class="dropdown-divider"></div>

                                <!-- Header Styles -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <a class="dropdown-item" data-toggle="layout" data-action="header_style_light" href="#">
                                    <span>Header Light</span>
                                </a>
                                <a class="dropdown-item" data-toggle="layout" data-action="header_style_dark" href="#">
                                    <span>Header Dark</span>
                                </a>
                                <!-- Header Styles -->
                            </div>
                        </div>
                        <!-- END Themes -->

                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="d-lg-none text-dual ml-3" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                            <i class="fa fa-times"></i>
                        </a>
                        <!-- END Close Sidebar -->
                    </div>
                    <!-- END Options -->
                </div>
                <!-- END Side Header -->

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <div id="log_name">
                        <h5>Welcome,</h5>
                        <h6>{{ Auth::user()->name}}</h6>
                    </div>
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('sidebarhome')" href="/admin">
                                <i class="fas fa-home"></i>
                                <span class="nav-main-link-name" style="margin-left: 7%;">Home</span>
                            </a>
                        </li>
                        <li class="nav-main-item @yield('opensidebar')">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="fas fa-user"></i>
                                <span class="nav-main-link-name" style="margin-left: 7%;">Personal Page</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('sidebarpersonal')" href="/personal">
                                        <span class="nav-main-link-name">Personal Info</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('sidebarprofessional')" href="/professional">
                                        <span class="nav-main-link-name">Professional Info</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('sidebarflextime')" href="/harvest">
                                        <span class="nav-main-link-name">Flex-Time</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('sidebarholidays')" href="/holidays">
                                        <span class="nav-main-link-name">Holidays/Absences</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('sidebaremployees')" href="/employees">
                                <i class="fas fa-users"></i>
                                <span class="nav-main-link-name" style="margin-left: 6%;">Employees</span>
                            </a>
                        </li>
                        <li class="nav-main-item @yield('openEvaluations')">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="fas fa-user"></i>
                                <span class="nav-main-link-name" style="margin-left: 7%;">Evaluations</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('sidebarCreateEvaluation')" href="/evals">
                                        <span class="nav-main-link-name">Create Evaluation (RH)</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('sidebarCompleteSurvey')" href="/indexUserEvals">
                                        <span class="nav-main-link-name">Complete Survey (User)</span>
                                    </a>
                                </li>


                                 <li class="nav-main-item @yield('Results')">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                        <span class="nav-main-link-name" style="margin-left: 7%;">Survey Results (RH)</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link @yield('sidebarShowResults')" href="/evalsResultsIndex">
                                                <span class="nav-main-link-name">Show Results</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link @yield('showOther')" href="">
                                                <span class="nav-main-link-name">Results</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>



                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('sidebarFinalAverage')" href="/finalAverageAllSurveys">
                                        <span class="nav-main-link-name">Show Final Results from all Surveys (RH)</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('sidebarreports')" href="/reports">
                                <i class="fas fa-file-import"></i>
                                <span class="nav-main-link-name" style="margin-left: 6%;">Reports</span>
                            </a>
                        </>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('sidebarsettings')" href="/settingspage">
                                <i class="fas fa-cog"></i>
                                <span class="nav-main-link-name" style="margin-left: 6%;">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END Side Navigation -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Right Section -->
                    <div class="d-flex align-items-center">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <!-- END Toggle Sidebar -->

                        {{-- <!-- User Dropdown -->
                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn btn-sm btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded" src="assets/media/avatars/avatar10.jpg" alt="Header Avatar" style="width: 18px;">
                                <span class="d-none d-sm-inline-block ml-1">Adam</span>
                                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-user-dropdown">
                                <div class="p-3 text-center bg-primary">
                                    <img class="img-avatar img-avatar48 img-avatar-thumb" src="assets/media/avatars/avatar10.jpg" alt="">
                                </div>
                                <div class="p-2">
                                    <h5 class="dropdown-header text-uppercase">User Options</h5>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                        <span>Inbox</span>
                                        <span>
                                            <span class="badge badge-pill badge-primary">3</span>
                                            <i class="si si-envelope-open ml-1"></i>
                                        </span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                        <span>Profile</span>
                                        <span>
                                            <span class="badge badge-pill badge-success">1</span>
                                            <i class="si si-user ml-1"></i>
                                        </span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                        <span>Settings</span>
                                        <i class="si si-settings"></i>
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <h5 class="dropdown-header text-uppercase">Actions</h5>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                        <span>Lock Account</span>
                                        <i class="si si-lock ml-1"></i>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                        <span>Log Out</span>
                                        <i class="si si-logout ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END User Dropdown --> --}}



                        <!-- Toggle Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
{{-- Button for Options --}}
                        {{-- <button type="button" class="btn btn-sm btn-dual ml-2" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>
                        </button> --}}

                        <!-- END Toggle Side Overlay -->
                    </div>
                    <!-- END Right Section -->
                    <!-- Left Section -->
                    <div class="d-flex align-items-center">
                        <!-- Toggle Mini Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        {{-- <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
                            <i class="fa fa-fw fa-ellipsis-v"></i>
                        </button> --}}
                        <!-- END Toggle Mini Sidebar -->
                        <!-- Open Search Section (visible on smaller screens) -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-sm btn-dual d-sm-none" data-toggle="layout" data-action="header_search_on">
                            <i class="si si-magnifier"></i>
                        </button>
                        <!-- END Open Search Section -->

                        <!-- Search Form (visible on larger screens) -->
                        <form class="d-none d-sm-inline-block" method="POST" id="searchpp">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-alt searchpp" placeholder="Search..." id="page-header-search-input2" name="page-header-search-input2">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-body border-0">
                                        <i class="si si-magnifier"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <!-- END Search Form -->
                        <!-- Notifications Dropdown -->
                        <?php
                            // use App\notifications;
                            // use App\settings_general;
                            // use App\sliderView;
                            // $settingsAlerts = settings_general::orderBy('created_at', 'desc')->first();
                            // $allNotificationsUser = notifications::orderby('created_at', 'desc')->limit(6)->get(); //notificacoes da DB
                            // $notificationsBirthdays = sliderview::where('Type', 'Birthday')->get();
                            // $notificationsHolidays = sliderview::where('Type', 'Absence')->where('Absence Type', 1)->get();

                        ?>
                        <div onclick="readNotifications()" class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn btn-sm btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="si si-bell"></i>
                                <span id="txtHint">  </span>

                                <?php

                                $countNotif=0;

                                foreach($notificationMessages as $listNotif) {

                                    if($listNotif->read_at=='') {

                                        foreach($listNotifications as $notif) {

                                            if($notif->notificationId == $listNotif->id) {

                                                if($notif->receiveUserId == $id_user) {

                                                    foreach($allReminders as $rem) {

                                                        if($rem->notifications_users_id == $notif->id) {

                                                            $countNotif++;

                                                        }

                                                    }

                                                    $countNotif++;

                                                }

                                            }

                                        }

                                    }

                                }

                                ?>
                                @if($countNotif>0)
                                    <span id="countNotifIdAjax" class="badge badge-primary badge-pill">{{$countNotif}}</span>
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-2 bg-primary text-center">
                                    <h5 class="dropdown-header text-uppercase text-white">Notifications</h5>
                                </div>
                                <ul class="nav-items mb-0">

                                    <form method="GET" id="notificationsReadForm"> <!-- a form tem de estar fora para apanhar todos os values para o ajax, para fazer tudo parte de uma só form -->
                                        @csrf
                                    @foreach($listNotifications as $notUser) <!-- Notificacoes -->
                                        @if($id_user == $notUser->receiveUserId)
                                            <?php $notification = notifications::find($notUser->notificationId); ?>
                                            @if($notification->read_at=='')
                                            <li style="background-color: lightgrey">
                                            @else

                                            <li>
                                            @endif
                 
                                                <input type="hidden" name="notfsRead[]" value={{$notification->id}}>
                                                @if($settingsAlerts->alert_evaluations == 1) <!-- Se as notificacoes das avals tiverem ligadas -->
                                                    @if($notification->type == "EvaluationAssigned") <!-- Notificacoes avaliacoes -->
                                                            <a class="text-dark media py-2" href="/indexUserEvals"> <!-- pagina das avals -->
                                                                <div class="mr-2 ml-3">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </div>
                                                                <div class="media-body pr-2">
                                                                    <div class="font-w600">{{$notification->description}}</div>
                                                                    <small class="text-muted">{{$notification->created_at}}</small>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if($settingsAlerts->alert_birthdays == 1)
                                                    @if($notification->type == "Birthday") <!-- Notificacoes avaliacoes -->
                                                            <a class="text-dark media py-2" href="javascript:void(0)"> <!-- pagina das avals -->
                                                                <div class="mr-2 ml-3">
                                                                    <i class="fas fa-birthday-cake"></i>
                                                                </div>
                                                                <div class="media-body pr-2">
                                                                    <div class="font-w600">{{$notification->description}}</div>
                                                                    <small class="text-muted">{{$notification->created_at}}</small>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if($settingsAlerts->alert_flextime == 1)
                                                    @if($notification->type == "Flextime") <!-- Notificacoes avaliacoes -->
                                                            <a class="text-dark media py-2" href="/harvest"> <!-- pagina das avals -->
                                                                <div class="mr-2 ml-3">
                                                                    <i class="fas fa-user-clock"></i>
                                                                </div>
                                                                <div class="media-body pr-2">
                                                                    <div class="font-w600">{{$notification->description}}</div>
                                                                    <small class="text-muted">{{$notification->created_at}}</small>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endif
                                             @endif
                                                @if($settingsAlerts->alert_holidays == 1)
                                                    @if($notification->type == "Vacations" || $notification->type == "Absences")
                                                        <a class="text-dark media py-2" href="/holidays">
                                                            <div class="mr-2 ml-3" >
                                                                <i class="fas fa-clock"></i>
                                                            </div>
                                                            <div class="media-body pr-2">
                                                                <small class="font-w600">{{$notification->description}}</small>
                                                                <small class="text-muted">{{$notification->created_at}}</small>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    @elseif($notification->type == "Approval")
                                                            <a class="text-dark media py-2" href="/holidays">
                                                                <div class="mr-2 ml-3">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </div>
                                                                <div class="media-body pr-2">
                                                                    <small class="font-w600">{{$notification->description}}</small>
                                                                    <small class="text-muted">{{$notification->created_at}}</small>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                           
                                        @endif

                                    @endforeach
                                </form>

                                    @foreach($allReminders as $reminder) <!-- Reminders -->
                                    <?php $notificationUser = NotificationsUsers::find($reminder->notifications_users_id);  ?>
                                        @if($notificationUser->receiveUserId == $id_user)
                                            @if($settingsAlerts->alert_evaluations == 1)

                                            @if($reminder->read_at=='')
                                             <li style="background-color: lightgrey">
                                            @else

                                            <li>
                                            @endif
                                                    <a class="text-dark media py-2" href="/indexUserEvals"> <!-- pagina das avals -->
                                                        <div class="mr-2 ml-3">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </div>
                                                        <div class="media-body pr-2">
                                                            <div class="font-w600">{{$reminder->description}}</div>
                                                            <small class="text-muted">{{$reminder->created_at}}</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach

                                   



                                {{-- @foreach($listNotifications as $listNot)

                                @if($id_user==$listNot->receiveUserId)

                                @foreach($notificationMessages as $msg)

                                @if($listNot->notificationId==$msg->id)

                                @if($msg->type == "Vacations" || $msg->type == "Absences")

                                @if($msg->read_at=='')
                                <li style="background-color: lightgrey">
                                @else

                                <li>
                                @endif
                                            <a class="text-dark media py-2" href="/holidays">
                                                <div class="mr-2 ml-3" >
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                                <div class="media-body pr-2">
                                                    <small class="font-w600">{{$msg->description}}</small>
                                                </div>
                                            </a>
                                </li>

                                @elseif($msg->type == "Approval")

                                @if($msg->read_at=='')
                                <li style="background-color: lightgrey">
                                @else

                                <li>
                                @endif
                                            <a class="text-dark media py-2" href="/holidays">
                                                <div class="mr-2 ml-3">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </div>
                                                <div class="media-body pr-2">
                                                    <small class="font-w600">{{$msg->description}}</small>
                                                </div>
                                            </a>
                                </li>


                                @endif

                                @endif
                                @endforeach



                                @endif


                                @endforeach --}}



                                </ul>
                                <div class="p-2 border-top">
                                    <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-arrow-down mr-1"></i> Load More..
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END Notifications Dropdown -->

                        <!-- LOGOUT -->
                        <div>
                            <button type="button" class="btn btn-sm btn-dual" id="logout" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">Logout</button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        <!-- END LOGOUT -->
                    </div>
                    <!-- END Left Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Search -->
                <div id="page-header-search" class="overlay-header bg-white">
                    <div class="content-header">
                        <form class="w-100" method="POST">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                    <button type="button" class="btn btn-danger" data-toggle="layout" data-action="header_search_off">
                                        <i class="fa fa-fw fa-times-circle"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Header Search -->

                <!-- Header Loader -->
                <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-white">
                    <div class="content-header">
                        <div class="w-100 text-center">
                            <i class="fa fa-fw fa-circle-notch fa-spin"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">

                @yield('content')
                
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-body-light">
                {{-- <div class="content py-3">
                    <div class="row font-size-sm">
                        <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-right">
                            Crafted with <i class="fa fa-heart text-danger"></i> by <a class="font-w600" href="https://1.envato.market/ydb" target="_blank">pixelcave</a>
                        </div>
                        <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-left">
                            <a class="font-w600" href="https://1.envato.market/AVD6j" target="_blank">OneUI 4.4</a> &copy; <span data-toggle="year-copy"></span>
                        </div>
                    </div>
                </div> --}}
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->
        <script>
            function readNotifications() {
                // var xmlhttp = new XMLHttpRequest();
                // xmlhttp.onreadystatechange = function() {
                // if (this.readyState == 4 && this.status == 200) {
                //      document.getElementById("txtHint").innerHTML = this.responseText;
                // }
                // };
                // xmlhttp.open("GET", "/readNotification", true);
                // xmlhttp.send();


               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/readNotification') }}",
                  method: 'get',
                  data: $("#notificationsReadForm").serialize(), //apanha todos os valores da form
                  success: function(result){
                     document.getElementById("txtHint").innerHTML = result;
                     document.getElementById('countNotifIdAjax').innerHTML = null; //pões as notifs a 0 depois de abertas
                  }});
            //  document.getElementById('notificationsReadForm').submit();
           


            }
            
        </script>
        <!-- OneUI JS -->
        <script src="{{ asset ('assets/js/oneui.core.min.js') }}"></script>
        <script src="{{ asset ('assets/js/oneui.app.min.js') }} "></script>

        <script src="{{ asset ('assets/js/plugins/datatables/jquery.dataTables.min.js ') }}"></script>
        <script src="{{ asset ('assets/js/plugins/datatables/dataTables.bootstrap4.min.js ') }}"></script>
        <script src="{{ asset ('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js ') }}"></script>
        <script src="{{ asset ('assets/js/plugins/datatables/buttons/buttons.print.min.js ') }}"></script>
        <script src="{{ asset ('assets/js/plugins/datatables/buttons/buttons.html5.min.js ') }}"></script>
        <script src="{{ asset ('assets/js/plugins/datatables/buttons/buttons.flash.min.js ') }}"></script>
        <script src="{{ asset ('assets/js/plugins/datatables/buttons/buttons.colVis.min.js ') }}"></script>

        <!-- Page JS Code -->
        <script src="{{ asset ('assets/js/pages/be_tables_datatables.min.js ') }}"></script>

        <script src="{{ asset ('js/myscripts.js ') }}"></script>
    </body>
</html>
