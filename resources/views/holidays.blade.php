@extends('layouts.template')

@section('title')
    Improove HR - Holidays/Absences
@endsection

@section('content')

<div id="table_hol">


<div class="shadow p-1 bg-white cardbox1">
    <div class="container">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home">Holidays</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Absences</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div id="home" class="container tab-pane active"><br>
            <div class="shadow p-1 bg-white cardbox2">
                <div id="startday">
                    <h5>Start Day</h5>
                    <p>12/10/2019</p>
                    <a data-toggle="modal" data-target="#editstartday">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
                <div id="endday">
                    <h5>End Day</h5>
                    <p>14/10/2019</p>
                    <a data-toggle="modal" data-target="#editendday">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
                <div id="approval">
                    <h5>Approval</h5>
                    <p><p class="dot"></p>Approved</p>
                </div>
            </div>

            <div class="shadow p-1 bg-white cardbox2">
                <a data-toggle="modal" data-target="#exampleModal">
                <div class="shadow p-1 bg-white cardbox3">
                    <i class="fas fa-plus"></i>
                    <h5>Add New Holiday</h5>
                </div>
            </a>
            </div>
        <br><hr style="border-radius: 5px;border: 1px solid black; width: 80%">

            <!-- Dynamic Table with Export Buttons -->
            <div class="block-header">
                <h3 class="block-title text-center">Holidays<small> - ALL Employees</small></h3>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                    <thead>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 5%;">NR</th>
                            <th class="d-none d-sm-table-cell" style="width: 20%;">Name</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Start Date</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">End Date</th>
                            <th style="width: 15%;">Role</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                1
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Amanda Powell</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                2
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Alice Moore</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                4/11/2019
                            </td>
                            <td class="d-none d-sm-table-cell font-size-sm">
                                10/11/2019
                            </td>
                            <td class="font-size-sm">
                                Developer
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                3
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Danielle Jones</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/10/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/10/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                4
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Carl Wells</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                5
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Amanda Powell</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                6
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Brian Cruz</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                7
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Brian Cruz</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                8
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Sara Fields</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                9
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Jose Wagner</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Manager
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                10
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Danielle Jones</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Human Resources
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                11
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Danielle Jones</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Developer
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                12
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Alice Moore</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Developer
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                13
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Jose Wagner</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Developer
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                14
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="be_pages_generic_blank.html">Jose Wagner</a>
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                20/12/2019
                            </td>
                            <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                                24/12/2019
                            </td>
                            <td class="font-size-sm">
                                Human Resources
                            </td>
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
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                    <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->



        {{-- TAB ABSENCES --}}

<div id="menu1" class="container tab-pane fade"><br>
 <!-- Tab panes -->
      <div class="shadow p-1 bg-white cardbox2">
          <div id="startdayab">
              <h5>Start Day</h5>
              <p>12/10/2019</p>
              <a data-toggle="modal" data-target="#editstartday">
                  <i class="fas fa-pen"></i>
              </a>
          </div>
          <div id="enddayab">
              <h5>End Day</h5>
              <p>14/10/2019</p>
              <a data-toggle="modal" data-target="#editendday">
                  <i class="fas fa-pen"></i>
              </a>
          </div>
          <div id="approvalab">
              <h5>Approval</h5>
              <p><p class="dot"></p>Approved</p>
          </div>
          <div id="attachment">
            <h5>Attachment</h5>
            <div class="shadow p-1 bg-white cardboxjust">
                <a data-toggle="modal" data-target="#justificationModal">
                    <p>Justification</p>
                    <i class="fas fa-plus"></i>
            </a>
            </div>
        </div>
        <div id="type">
            <h5>Type</h5>
            <div class="shadow p-1 bg-white cardboxjust1">
                <a data-toggle="modal" data-target="#typeModal">
                    <p>Type</p>
                    <i class="fas fa-plus"></i>
            </a>
            </div>
        </div>
      </div>

      <div class="shadow p-1 bg-white cardbox2">
          <a data-toggle="modal" data-target="#exampleModal">
          <div class="shadow p-1 bg-white cardbox3">
              <i class="fas fa-plus"></i>
              <h5>Add New Absence</h5>
          </div>
      </a>
      </div>
  <br><hr style="border-radius: 5px;border: 1px solid black; width: 80%">

      <!-- Dynamic Table with Export Buttons -->
      <div class="block-header">
          <h3 class="block-title text-center">Absences<small> - ALL Employees</small></h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
              <thead>
                  <tr>
                      <th class="d-none d-sm-table-cell" style="width: 5%;">NR</th>
                      <th class="d-none d-sm-table-cell" style="width: 20%;">Name</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Start Date</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">End Date</th>
                      <th style="width: 15%;">Attachment</th>
                      <th style="width: 15%;">Type</th>
                      <th style="width: 15%;">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="font-w600 font-size-sm">
                          1
                      </td>
                      <td class="font-w600 font-size-sm">
                          <a href="be_pages_generic_blank.html">Amanda Powell</a>
                      </td>
                      <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                          20/12/2019
                      </td>
                      <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                          24/12/2019
                      </td>
                      <td class="font-w600 font-size-sm">
                        <a href="javascript:void(0)">justification.pdf</a>
                    </td>
                    <td class="font-w600 font-size-sm">
                        Sick
                    </td>
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
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                  <i class="fas fa-check"></i>
                              </a>
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                              <i class="fas fa-times"></i>
                              </a>
                          </span>
                      </td>
                  </tr>
                  <tr>
                      <td class="font-w600 font-size-sm">
                          2
                      </td>
                      <td class="font-w600 font-size-sm">
                          <a href="be_pages_generic_blank.html">Alice Moore</a>
                      </td>
                      <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                          4/11/2019
                      </td>
                      <td class="d-none d-sm-table-cell font-size-sm">
                          10/11/2019
                      </td>
                      <td class="font-w600 font-size-sm">
                        <a href="javascript:void(0)">justification.pdf</a>
                    </td>
                    <td class="font-w600 font-size-sm">
                        Sick
                    </td>
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
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                  <i class="fas fa-check"></i>
                              </a>
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                              <i class="fas fa-times"></i>
                              </a>
                          </span>
                      </td>
                  </tr>
                  <tr>
                      <td class="font-w600 font-size-sm">
                          3
                      </td>
                      <td class="font-w600 font-size-sm">
                          <a href="be_pages_generic_blank.html">Danielle Jones</a>
                      </td>
                      <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                          20/10/2019
                      </td>
                      <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                          24/10/2019
                      </td>
                      <td class="font-w600 font-size-sm">
                        <a href="javascript:void(0)">justification.pdf</a>
                    </td>
                    <td class="font-w600 font-size-sm">
                        Sick
                    </td>
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
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                  <i class="fas fa-check"></i>
                              </a>
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                              <i class="fas fa-times"></i>
                              </a>
                          </span>
                      </td>
                  </tr>
                  <tr>
                      <td class="font-w600 font-size-sm">
                          4
                      </td>
                      <td class="font-w600 font-size-sm">
                          <a href="be_pages_generic_blank.html">Carl Wells</a>
                      </td>
                      <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                          20/12/2019
                      </td>
                      <td data-type="date" class="d-none d-sm-table-cell font-size-sm">
                          24/12/2019
                      </td>
                      <td class="font-w600 font-size-sm">
                        <a href="javascript:void(0)">justification.pdf</a>
                    </td>
                    <td class="font-w600 font-size-sm">
                        Sick
                    </td>
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
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                  <i class="fas fa-check"></i>
                              </a>
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                              <i class="fas fa-times"></i>
                              </a>
                          </span>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
</div>
</div>
</div>
</div>

 <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Holiday</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>Start Day</h5>
            <input type="date">
            <h5>End Day</h5>
            <input type="date">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>



   <!-- Modal End Day-->
<div class="modal fade" id="editendday" tabindex="-1" role="dialog" aria-labelledby="editenddayLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editenddayLabel">End Day</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>New Day</h5>
            <input type="date">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>


   <!-- Modal Start Day-->
   <div class="modal fade" id="editstartday" tabindex="-1" role="dialog" aria-labelledby="editenddayLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editstartdayLabel">Start Day</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>New Day</h5>
            <input type="date">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

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
        <div class="modal-body">
            <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile01"
                    aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Save</button>
        </div>
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
        <div class="modal-body">
            <select class="browser-default custom-select" style="width: 250px">
                <option selected value="1">Sick</option>
                <option value="2">Personal</option>
                <option value="3">Vacations</option>
                <option value="3">Family</option>
              </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

@endsection
