@extends('layouts.template')

@section('title')
    Improove HR - Holidays/Absences
@endsection

@section('sidebarholidays')
active
@endsection

@section('opensidebar')
open
@endsection

@section('content')

@if($errors->any())
<div class="errorVacation">
<p style="color: red;">{{$errors->first()}}</p>
</div>
@endif

<div id="">

<div id="cardbox4" class="shadow p-1 bg-white cardbox1">
    <div class="">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home">Holidays</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#home2">Employees on Holidays</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Absences</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Employees with Absences</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div id="home" class="tab-pane active"><br>

          <div class="shadow p-1 bg-white cardbox2">
                <a data-toggle="modal" data-target="#modalVacation">
                <div id="addholiday" class="shadow p-1 bg-white cardbox3">
                    <i class="fas fa-plus"></i>
                    <h5>Add New Holiday</h5>
                </div>
            </a>
            </div>

        @for($i=0;$i<count($array_vacations);$i+=4)
            <div class="shadow p-1 bg-white cardbox2" id="holbox">
                <div id="startday">
                    <h5>Start Day</h5>
                    <p class="holidayDates">{{$array_vacations[$i+1]}}</p>
                    <a class="editstart" data-toggle="modal" data-target="#editStartDay">
                        <i type="button" id="{{$array_vacations[$i]}}" onClick="reply_click(this.id)" class="fas fa-pen"></i>
                    </a>
                </div>
                <div id="endday">
                    <h5>End Day</h5>
                    <p class="holidayDates">{{$array_vacations[$i+2]}}</p>
                    <a class="editend" data-toggle="modal" data-target="#editEndDay">
                        <i type="button" id="{{$array_vacations[$i]}}" onClick="reply_click2(this.id)" class="fas fa-pen"></i>
                    </a>
                </div>

                @if($array_vacations[$i+3]=="Disapproved")

                    <div id="approval">
                    <h5>Approval</h5>
                    <p><p class="dot" style="background-color:#EC6927"></p>{{$array_vacations[$i+3]}}</p>
                </div>




                @elseif($array_vacations[$i+3]=="Concluded")

                    <div id="approval">
                    <h5>Approval</h5>
                    <p><p class="dot" style="background-color:#3B96F2"></p>{{$array_vacations[$i+3]}}</p>
                </div>

                @elseif($array_vacations[$i+3]=="Pending")

                    <div id="approval">
                    <h5>Approval</h5>
                    <p><p class="dot" style="background-color:#EBD12A"></p>{{$array_vacations[$i+3]}}</p>
                </div>



                @else

                    <div id="approval">
                    <h5>Approval</h5>
                    <p><p class="dot" style="background-color:#31DC59"></p>{{$array_vacations[$i+3]}}</p>
                </div>


                @endif


            </div>
        @endfor

        <div class="row" id="paginationholabs">
        <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
        Page <strong>1</strong> of <strong>1</strong></div></div>
        <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers scrollnumbers" id="DataTables_Table_0_paginate">
        <ul class="pagination"><li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">
        <i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
        <li class="paginate_button page-item active">
        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
        <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next">
        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">
        <i class="fa fa-angle-right" aria-hidden="true"></i></a></li></ul></div></div></div>

        </div>

            <!-- ------------------------------------------------------ TAB - EMPLOYEES ON HOLIDAYS ------------------------------------------------------ -->

            <div id="home2" class="tab-pane fade"><br>
            @if($roleuser <= 3)
<!-- <br><hr style="border-radius: 5px;border: 1px solid black; width: 80%"> -->

<!-- Dynamic Table with Export Buttons -->
<div class="block-header">
    <h3 class="block-title text-center">Holidays<small> - ALL Employees</small></h3>
</div>

<div class="block-content-full">
<!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
<table class="table js-dataTable-buttons table-responsive">
<thead class="thead-dark">
    <tr>
    <th class=" d-sm-table-cell" style="width: 5%;">NR</th>
                <th class=" d-sm-table-cell" style="width: 5%;">Name</th>
                <th class=" d-sm-table-cell" style="width: 15%;">Department</th>
                <th class=" d-sm-table-cell" style="width: 15%;">Start Date</th>
                <th class=" d-sm-table-cell" style="width: 15%;">End Date</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 15%;">Actions</th>
    </tr>
</thead>
<tbody>
@php
    $i = 1;
@endphp

@foreach($listVacationsTotal as $list)

    <tr>
        <td >
            {{$i}}
        </td>
        <td >
            <a href="be_pages_generic_blank.html">{{$list->name}}</a>
        </td>
        <td >
                    <a href="be_pages_generic_blank.html">{{$list->depDescription}}</a>
                </td>
        <td data-type="date" >
            {{$list->start_date}}
        </td>
        <td data-type="date" >
            {{$list->end_date}}
        </td>
        <td class="font-w600 font-size-sm">
            {{$list->status}}
        </td>

        @if($list->status=='Concluded')

        <td data-field="Actions" data-autohide-disabled="false">
            <span style="overflow: visible; position: relative;">
            <div class="dropdown" style="float: left;">
                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                    <i class="fas fa-cog"></i></a>
            <div class="dropdown-menu dropdown-menu-right">						    	<a class="dropdown-item" href="#"><i class="far fa-edit"></i> Edit Details</a>
                <a class="dropdown-item" href="#"><i class="fas fa-leaf"></i> Update Status</a>
                <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Generate Report</a>
            </div>
        </div>
        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
                    <i class="far fa-edit"></i></a>

            </span>
        </td>

        @else
            <td data-field="Actions" data-autohide-disabled="false">
                <span style="overflow: visible; position: relative;">
                <div class="dropdown" style="float: left;">
                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                        <i class="fas fa-cog"></i></a>
                <div class="dropdown-menu dropdown-menu-right">						    	<a class="dropdown-item" href="#"><i class="far fa-edit"></i> Edit Details</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-leaf"></i> Update Status</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Generate Report</a>
                </div>
            </div>

            @if($roleuser < 3)
                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
                    <i class="far fa-edit"></i></a>
                    <a data-toggle="modal" data-target="#modalApproval" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                        <i type="button" id="{{$list->absencedId}}" onClick="reply_click5(this.id)" class="fas fa-check"></i>
                    </a>
                    <a data-toggle="modal" data-target="#modalDisapproval" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                    <i type="button" id="{{$list->absencedId}}" onClick="reply_click6(this.id)" class="fas fa-times"></i>
                    </a>
            @endif
                </span>
            </td>


        @endif

    </tr>

    @php
        $i++;
    @endphp

@endforeach
</tbody>
</table>
</div>
@endif
</div>

        {{-- TAB ABSENCES --}}

<div id="menu1" class=" tab-pane fade"><br>
 <!-- Tab panes -->

 <div class="shadow p-1 bg-white cardbox2" id="newAbsenceadd">
          <a data-toggle="modal" data-target="#modalAbsence">
          <div id="addabsence" class="shadow p-1 bg-white cardbox3">
              <i class="fas fa-plus"></i>
              <h5>Add New Absence</h5>
          </div>
      </a>
</div>

@for($i=0;$i<count($array_absences);$i+=7)

      <div class="shadow p-1 bg-white cardbox2" id="absbox">
          <div id="startdayab">
              <h5>Start Day</h5>
              <p class="holidayDates">{{$array_absences[$i+1]}}</p>
              <a data-toggle="modal" data-target="#editStartDatetime">
                  <i type="button" id="{{$array_absences[$i]}}" onClick="reply_click3(this.id)" class="fas fa-pen"></i>
              </a>
          </div>
          <div id="enddayab">
              <h5>End Day</h5>
              <p class="holidayDates">{{$array_absences[$i+2]}}</p>
              <a data-toggle="modal" data-target="#editEndDatetime">
                  <i type="button" id="{{$array_absences[$i]}}" onClick="reply_click4(this.id)" class="fas fa-pen"></i>
              </a>
          </div>

          @if($array_absences[$i+3]=="Disapproved")

          <div id="approvalab">
              <h5>Approval</h5>
              <p class="dot" style="background-color:#EC6927" id="approvaldot"></p><p>{{$array_absences[$i+3]}}</p>
          </div>

            @elseif($array_absences[$i+3]=="Concluded")

            <div id="approvalab">
                        <h5>Approval</h5>
                        <p class="dot" style="background-color:#3B96F2" id="approvaldot"></p><p>{{$array_absences[$i+3]}}</p>
                    </div>

            @elseif($array_absences[$i+3]=="Pending")

            <div id="approvalab">
            <h5>Approval</h5>
            <p class="dot" style="background-color:#EBD12A" id="approvaldot"></p><p>{{$array_absences[$i+3]}}</p>
            </div>

            @else

            <div id="approvalab">
                        <h5>Approval</h5>
                        <p class="dot" style="background-color:#31DC59" id="approvaldot"></p><p>{{$array_absences[$i+3]}}</p>
                    </div>


            @endif


          <div id="attachment">
            <h5>Attachment</h5>

        @if($array_absences[$i+4]!="")

            {{-- <div class="attachContainer"> --}}
            <p class="attachamentText">{{$array_absences[$i+4]}}</p>
            <a id="addattachment" type="button" id="{{$array_absences[$i]}}" onClick="reply_click9(this.id)" data-toggle="modal" data-target="#justificationModal">
                  <i class="fas fa-pen iconSize"></i>
              </a>
              {{-- </div> --}}

        @else

            <div class="shadow p-1 bg-white cardboxjust">
                <a type="button" id="{{$array_absences[$i]}}" onClick="reply_click9(this.id)" data-toggle="modal" data-target="#justificationModal">
                    <p>Justification</p>
                    <i class="fas fa-plus"></i>
            </a>
            </div>

        @endif

        </div>

        <div id="type">
            <h5>Motive</h5>

        @if($array_absences[$i+6]==6)

            <div class="shadow p-1 bg-white cardboxjust1">
                <a id="addmotive" type="button" id="{{$array_absences[$i]}}" onClick="reply_click10(this.id)" data-toggle="modal" data-target="#typeModal">
                    <p id="addtype">Add</p>
                    <i class="fas fa-plus"></i>
            </a>
            </div>

        @else

            @if($array_absences[$i+6]==2)

                <p>Excused Absence</p>

            @elseif($array_absences[$i+6]==3)

                <p>Unexcused Absence</p>

            @elseif($array_absences[$i+6]==4)

                <p>Maternity Leave</p>

            @elseif($array_absences[$i+6]==5)

                <p>Medical Leave</p>

            @endif

            <a type="button" id="{{$array_absences[$i]}}" onClick="reply_click10(this.id)" data-toggle="modal" data-target="#typeModal">
                  <i class="fas fa-pen"></i>
              </a>

        @endif

        </div>



      </div>

    @endfor

    <div class="row" id="paginationholabs">
        <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
        Page <strong>1</strong> of <strong>1</strong></div></div>
        <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers scrollnumbers" id="DataTables_Table_0_paginate">
        <ul class="pagination"><li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">
        <i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
        <li class="paginate_button page-item active">
        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
        <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next">
        <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">
        <i class="fa fa-angle-right" aria-hidden="true"></i></a></li></ul></div></div></div>

    </div>

<!-- ------------------------------------------------------ TAB - ABSENCES WITH ABSENCES ------------------------------------------------------ -->

    <div id="menu2" class="tab-pane fade"><br>

<!-- <br><hr style="border-radius: 5px;border: 1px solid black; width: 80%"> -->
@if($roleuser <= 3)
<!-- Dynamic Table with Export Buttons -->
<div class="block-header">
  <h3 class="block-title text-center">Absences<small> - ALL Employees</small></h3>
</div>
<div class="block-content-full">
  <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
  <table class="table js-dataTable-buttons table-responsive">
      <thead class="thead-dark">
          <tr>
          <th class="title" >NR</th>
                      <th style="width: 15%;">Name</th>
                      <th style="width: 15%;">Department</th>
                      <th style="width: 15%;">Start Date</th>
                      <th style="width: 15%;">End Date</th>
                      <th style="width: 15%;">Attachment</th>
                      <th style="width: 15%;">Type</th>
                      <th style="width: 15%;">Status</th>
                      <th style="width: 15%;">Actions</th>

          </tr>
      </thead>
      <tbody>

      @php
                $j = 1;
      @endphp

      @foreach($listAbsencesTotal as $list2)


          <tr>
              <td >
                  {{$j}}
              </td>
              <td >
                  <a href="be_pages_generic_blank.html">{{$list2->name}}</a>
              </td>
              <td >
                          <a href="be_pages_generic_blank.html">{{$list2->depDescription}}</a>
                      </td>
              <td data-type="date" class="d-sm-table-cell font-size-sm">
                  {{$list2->start_date}}
              </td>
              <td data-type="date" class="d-sm-table-cell font-size-sm">
                 {{$list2->end_date}}
              </td>
              <td class="font-w600 font-size-sm">
                <a href="javascript:void(0)">{{$list2->attachment}}</a>
            </td>
            <td >
                {{$list2->description}}
            </td>
            <td class="font-w600 font-size-sm">
                {{$list2->status}}
            </td>

            @if($list2->status=='Concluded')

            <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell" style="display: grid;
              grid-auto-columns: max-content;">
                  <span style="overflow: visible; position: relative;">
                  <div class="dropdown" style="float: left;">
                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                          <i class="fas fa-cog"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">						    	<a class="dropdown-item" href="#"><i class="far fa-edit"></i> Edit Details</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-leaf"></i> Update Status</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Generate Report</a>
                  </div>
              </div>
                  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
                      <i class="far fa-edit"></i></a>

                  </span>
              </td>

            @else

            <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell" style="display: grid;
              grid-auto-columns: max-content;">
                  <span style="overflow: visible; position: relative;">
                  <div class="dropdown" style="float: left;">
                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                          <i class="fas fa-cog"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">						    	<a class="dropdown-item" href="#"><i class="far fa-edit"></i> Edit Details</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-leaf"></i> Update Status</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Generate Report</a>
                  </div>
              </div>
              @if($roleuser < 4)
                  <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
                      <i class="far fa-edit"></i></a>
                      <a data-toggle="modal" data-target="#modalApproval" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                          <i type="button" id="{{$list2->absencedId}}" onClick="reply_click7(this.id)" class="fas fa-check"></i>
                      </a>
                      <a data-toggle="modal" data-target="#modalDisapproval" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                      <i type="button" id="{{$list2->absencedId}}" onClick="reply_click8(this.id)" class="fas fa-times"></i>
                      </a>

                      @endif
                  </span>
              </td>

            @endif

          </tr>

        @php
                $j++;
        @endphp

        @endforeach
      </tbody>
  </table>
</div>
@endif
<!-- END Dynamic Table with Export Buttons -->
</div>
</div>
</div>
</div>
</div>

                     <!-- Modal Vacations -->
                     <div class="modal fade" id="modalVacation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">NEW HOLIDAY</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/holidays" method="POST" class="action">
                        <div class="modal-body">

                        @csrf

                        <label for="start_date" >Start Date </label>
                        <input type="date" id="start_date" name="start_date">

                        <br><br>

                        <label for="end_date">End Date </label>
                        <input type="date" id="end_date" name="end_date">

                        <br><br>
                        <input type="hidden" value={{$vacation_days_available}} name="vacationDays">
                        <input type="hidden" value=1 name="op">

                        <!-- <input type="submit" value="ADD VACATION"> -->

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                        </form>
                        </div>
                    </div>
                    </div>

                    <!-- End Modal Vacations -->


                    <!-- Modal Absences -->
                    <div class="modal fade" id="modalAbsence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">NEW ABSENCE</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/holidays" method="POST" class="action">
                        <div class="modal-body">

                            @csrf

                            <label for="start_date" >Start Date</label>
                            <input type="datetime-local" id="start_date" name="start_date">

                            <br><br>

                            <label for="end_date">End Date </label>
                            <input type="datetime-local" id="end_date" name="end_date">


                            <input type="hidden" value=2 name="op">

                            <!-- <input type="submit" value="ADD ABSENCE"> -->


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                        </form>
                        </div>
                    </div>
                    </div>

                    <!-- End Modal Absences -->

   <!-- Modal Start Day-->
   <div class="modal fade" id="editStartDay" tabindex="-1" role="dialog" aria-labelledby="editStartDayLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editStartDayLabel">Start Day</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/holidays" method="POST" class="action">
            <div class="modal-body">

            @csrf

            <h5>New Day</h5>
            <input type="date" name="upd_start_date" id="upd_start_date">

            <input type="hidden" value=3 name="op">

            <input id="updateDate" type="hidden" name="upd">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
      </div>
    </div>
  </div>


   <!-- Modal End Day -->
<div class="modal fade" id="editEndDay" tabindex="-1" role="dialog" aria-labelledby="editEndDayLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editEndDayLabel">End Day</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/holidays" method="POST" class="action">
            <div class="modal-body">

            @csrf

            <h5>New Day</h5>
            <input type="date" name="upd_end_date" id="upd_end_date">

            <input type="hidden" value=4 name="op">

            <input id="updateDate2" type="hidden" name="upd">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
      </div>
    </div>
  </div>

   <!-- Modal Start Date and Time-->
   <div class="modal fade" id="editStartDatetime" tabindex="-1" role="dialog" aria-labelledby="editStartDatetimeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editStartDatetimeLabel">Start Date and Time</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/holidays" method="POST" class="action">
            <div class="modal-body">

            @csrf

            <h5>New Day</h5>
            <input type="datetime-local" name="upd_start_datetime" id="upd_start_datetime">

            <input type="hidden" value=5 name="op">

            <input id="updateDate3" type="hidden" name="upd">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
      </div>
    </div>
  </div>

   <!-- Modal End Date and Time-->
   <div class="modal fade" id="editEndDatetime" tabindex="-1" role="dialog" aria-labelledby="editEndDatetimeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editEndDatetimeLabel">End Date and Time</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/holidays" method="POST" class="action">
            <div class="modal-body">

            @csrf

            <h5>New Day</h5>
            <input type="datetime-local" name="upd_end_datetime" id="upd_end_datetime">

            <input type="hidden" value=6 name="op">

            <input id="updateDate4" type="hidden" name="upd">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
      </div>
    </div>
  </div>



<!-- Modal Approval -->
<div class="modal fade" id="modalApproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to approve this absence?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="/holidays" method="POST" class="action">
    <div class="modal-body">

    @csrf

    <input type="hidden" value=7 name="op">

    <input id="updateStatus1" type="hidden" value="" name="upd">

    <!-- <input type="submit" value="ADD VACATION"> -->

    <!-- <p id="texto"></p> -->

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Yes</button>
    </div>

    </form>
    </div>
</div>
</div>

<!-- End Modal Approval -->


<!-- Modal Disapproval -->
<div class="modal fade" id="modalDisapproval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to disapprove this absence?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="/holidays" method="POST" class="action">
    <div class="modal-body">

    @csrf

    <input type="hidden" value=8 name="op">

    <input id="updateStatus2" type="hidden" value="" name="upd">

    <!-- <input type="submit" value="ADD VACATION"> -->

    <!-- <p id="texto"></p> -->

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Yes</button>
    </div>

    </form>
    </div>
</div>
</div>

<!-- End Modal Disapproval -->


   <!-- Modal Justification -->
<div class="modal fade" id="justificationModal" tabindex="-1" role="dialog" aria-labelledby="justificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="justificationModalLabel">Justification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/holidays" method="POST" class="action">
        <div class="modal-body">

        @csrf

            <div class="input-group">
                <div class="custom-file">

                  <input type="file" class="custom-file-input" id="inputGroupFile01" name="inputGroupFile01"
                    aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>

                <input type="hidden" value=9 name="op">

                <input id="updateAttachment" type="hidden" value="" name="upd">

              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>


     <!-- Modal Type -->
<div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="typeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="typeModalLabel">Absence Type</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/holidays" method="POST" class="action">
        <div class="modal-body">

        @csrf

            <select class="browser-default custom-select" style="width: 250px" name="typeUpd" id="typeUpd">
                <option selected value="2">Excused Absence</option>
                <option value="3">Unexcused Absence</option>
                <option value="4">Maternity Leave</option>
                <option value="5">Medical Leave</option>
              </select>

              <h5 class="modal-title" id="typeModalLabel">Motive</h5>

              <input id="motive" name="motive" type="text">

              <input type="hidden" value=10 name="op">

                <input id="updateType" type="hidden" value="" name="upd">


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<!-- JAVASCRIPT UPDATE RECORD -->
      <script>
    function reply_click(clicked_id)
        {
            document.getElementById("updateDate").value = clicked_id;

        }

        // $(document).ready( function () {
        //     $('#table_id').DataTable({
        //         responsive: true
        //     });
        // });

        // $(document).ready( function () {
        //     $('#table_id2').DataTable({
        //         responsive: true
        //     });
        // });

    </script>

<script>
    function reply_click2(clicked_id2)
        {
            document.getElementById("updateDate2").value = clicked_id2;

        }

    </script>

<script>
    function reply_click3(clicked_id3)
        {
            document.getElementById("updateDate3").value = clicked_id3;

        }

    </script>

<script>
    function reply_click4(clicked_id4)
        {
            document.getElementById("updateDate4").value = clicked_id4;

        }

    </script>

<script>
    function reply_click5(clicked_id5)
        {
            document.getElementById("updateStatus1").value = clicked_id5;

        }

    </script>

<script>
    function reply_click6(clicked_id6)
        {
            document.getElementById("updateStatus2").value = clicked_id6;

        }

    </script>

    <script>
    function reply_click7(clicked_id7)
        {
            document.getElementById("updateStatus1").value = clicked_id7;

        }

    </script>

<script>
    function reply_click8(clicked_id8)
        {
            document.getElementById("updateStatus2").value = clicked_id8;

        }

    </script>

<script>
    function reply_click9(clicked_id9)
        {
            document.getElementById("updateAttachment").value = clicked_id9;

        }

    </script>

<script>
function reply_click10(clicked_id10)
        {
            document.getElementById("updateType").value = clicked_id10;

        }

    </script>

<!-- END JAVASCRIPT UPDATE RECORD -->

@endsection
