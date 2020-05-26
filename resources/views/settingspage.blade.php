@extends('layouts.template')

@section('title')
    Improove HR - Holidays/Absences
@endsection

@section('sidebarsettings')
active
@endsection

@section('content')

<div class="shadow p-1 bg-white cardboxsettings">

    <div class="container" id="settingstab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#general">General</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#personalpage">Personal Page</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#flextime">Flex-Time</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#holidays">Holidays/Absences</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#evaluations">Evaluations</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">


            {{-- GENERAL PAGE --}}
          <div id="general" class="container tab-pane active">
        <form class="form-group settingsform" action="">

        <p>Company</p>
        <hr id="companyline">

        <div id="entreprisename">
            <label for="">Company Name:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert Company Name">
        </div>

        <div id="companyaddress">
            <label for="">Company Address:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert Company Address">
        </div>

        <div id="generalemail">
            <label for="">General Email:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert General Email">
        </div>

        <div id="generalmobile">
            <label for="">General Mobile:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert General Mobile">
        </div>

        <div id="country">
            <label for="">Country:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert Country">
        </div>
        <button type="submit" class="form-group btn btn-outline-primary bsettings">Save</button>
        </form>

        <p>Alerts</p>
        <hr>

        <div id="allnotifications" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches">
            <label class="custom-control-label" for="customSwitches">All Notifications</label>
        </div>

        <div id="holidaysnoti" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches1">
            <label class="custom-control-label" for="customSwitches1">Holidays Notifications</label>
        </div>

        <div id="birthdaynoti" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches2">
            <label class="custom-control-label" for="customSwitches2">Birthdays Notifications</label>
        </div>

        <div id="evaluationsnoti" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches3">
            <label class="custom-control-label" for="customSwitches3">Evaluations Notifications</label>
        </div>

        <div id="flextimenoti" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches4">
            <label class="custom-control-label" for="customSwitches4">Flex-Time Notifications</label>
        </div>

        <div id="notworkingnoti" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches5">
            <label class="custom-control-label" for="customSwitches5">Not Working Notifications</label>
        </div>

        </div>


        {{-- FLEX-TIME --}}

        <div id="flextime" class="container tab-pane fade">
            <br>
            <div id="daysflextime">
                <label for="">Days:</label>
                <p>Monday - Friday</p>
                <a data-toggle="modal" data-target="#editFlexDays">
                    <i type="button" class="fas fa-pen"></i>
                </a>
            </div>

            <!-- Modal Change Days -->
        <div class="modal fade" id="editFlexDays" tabindex="-1" role="dialog" aria-labelledby="editEndDayLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="editEndDayLabel">Days</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="" method="POST" class="action">
                    <div class="modal-body2">
                    @csrf
                    <h5>New Days:</h5>
                    <input type="text">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
            </div>
            </div>
        </div>

            <div id="hoursflextime">
                <label>Hours per Week:</label>
                <p>40 Hours</p>
                <a data-toggle="modal" data-target="#editFlexHours">
                    <i type="button" class="fas fa-pen"></i>
                </a>
            </div>
        </div>

           <!-- Modal Change Hours -->
        <div class="modal fade" id="editFlexHours" tabindex="-1" role="dialog" aria-labelledby="editEndDayLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="editEndDayLabel">Hours Per Week</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="" method="POST" class="action">
                    <div class="modal-body2">
                    @csrf
                    <h5>New Hours:</h5>
                    <input type="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
            </div>
            </div>
        </div>

        {{-- HOLIDAYS --}}

        <div id="holidays" class="container tab-pane fade">
            <br>
            <div id="holidaysExtra">
                <label for="">Extra-Days:</label>
                <p>25 December</p>
                <div class="shadow p-1 bg-white cardbox2">
                    <a data-toggle="modal" data-target="#modalNewDay">
                    <div class="shadow p-1 bg-white cardbox3">
                        <i class="fas fa-plus"></i>
                        <h6>Add New Day</h6>
                    </div>
                </a>
                </div>
            </div>
            <div id="holidaysExtra2">
                <label for="">Holidays Limit:</label>
                <p>26 Days</p>
                <a data-toggle="modal" data-target="#editHolidaysLimit">
                    <i type="button" class="fas fa-pen"></i>
                </a>
            </div>
            <div id="holidaysExtra3">
                <label for="">Absence Justification:</label>
                <select class="form-control" name="Absence" id="absenceJustificationForm">
                    <option selected="selected">Yes</option>
                    <option >No</option>
                </select>
            </div>
        </div>

        <!-- Modal Add New Day -->
        <div class="modal fade" id="modalNewDay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Extra Day</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" class="action">
                        <div class="modal-body">
                            @csrf
                            <label for="start_date" >New Date </label>
                            <input type="date" id="start_date" name="start_date">
                            <input type="hidden" value=1 name="op">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal Add New Day -->

            <!-- Modal Limit Holidays -->
            <div class="modal fade" id="editHolidaysLimit" tabindex="-1" role="dialog" aria-labelledby="editEndDayLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="editEndDayLabel">Holidays Limit Days</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="" method="POST" class="action">
                        <div class="modal-body2">
                        @csrf
                        <h5>New Limit:</h5>
                        <input type="number">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                </div>
                </div>
            </div>
            <!-- End Modal Limit Holidays -->


        {{-- EVALUATIONS --}}

        <div id="evaluations" class="container tab-pane fade">
            <br>
            <div id="evaluations1">
                <label for="">Limit of Surveys:</label>
                <select class="form-control" name="Absence" id="limitEvaluationsForm">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option selected="selected">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div id="evaluations2">
                <label for="">Time Limit:</label>
                <select class="form-control" name="Absence" id="limitEvaluationsForm">
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option selected="selected">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                </select>
                <p>Days</p>
            </div>
        </div>


        </div>
    </div>
</div>

@endsection
