@extends('layouts.template')

@section('title')
    Improove HR - Absences
@endsection

@section('content')
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">

                <button class="tablink" onclick="openPage('Vacations', this, 'grey')">Vacations</button>
                <button class="tablink" onclick="openPage('Absences', this, 'grey')" id="defaultOpen">Absences</button>

                <!-- <?php
                    echo $listAbsencesTotal;
                ?> -->

                <div id="Vacations" class="tabcontent">
                    <table>
                    <tr>
                        <th>Start Date &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>End Date &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Approval</th>
                    </tr>

                @for($i=0;$i<count($array_vacations);$i+=3)
                    <tr>
                    <td> {{$array_vacations[$i]}} </td>
                    <td> {{$array_vacations[$i+1]}} </td>
                    <td> {{$array_vacations[$i+2]}} </td>
                    </tr>
                @endfor

                    </table>

                    <!-- Button trigger modal vacation -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVacation">
                    ADD NEW VACATION
                    </button>

                </div>

                <div id="Absences" class="tabcontent">

                @if($id_typeuser>1 && $id_typeuser<4)
                    <table>
                    <tr>
                        <th>User &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Start Date and Time &nbsp&nbsp|&nbsp&nbsp </th>
                        <th>End Date and Time &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Attachment &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Motive &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Approval</th>
                    </tr>


                    @foreach($listAbsencesPending as $list)
                        <tr>
                        <td> {{$list->user_name}} </td>
                        <td> {{$list->start_date}} </td>
                        <td> {{$list->end_date}} </td>
                        <td> {{$list->attachment}}</td>
                        <td> {{$list->motive}} </td>
                        <td> <button id="{{$list->id}}" onclick="getID(this.id)" type="button" class="approval_btn" data-toggle="modal" data-target="#modalApproval"></button>Approve <button class="repproval_btn"></button>Disapprove </td>
                        </tr>

                    @endforeach
                    </table>
                    <br>
                    <hr>
                    <br>

                    <table>
                    <tr>
                        <th>User &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Start Date and Time &nbsp&nbsp|&nbsp&nbsp </th>
                        <th>End Date and Time &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Attachment &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Motive &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Approval</th>
                    </tr>

                    @foreach($listAbsencesTotal as $list2)
                        <tr>
                        <td>{{$list2->user_name}}</td>
                        <td> {{$list2->start_date}} </td>
                        <td> {{$list2->end_date}} </td>
                        <td> {{$list2->attachment}}</td>
                        <td> {{$list2->motive}} </td>
                        <td> {{$list2->status}} </td>
                        </tr>

                    @endforeach
                    </table>


                @else

                <table>
                    <tr>
                        <th>Start Date and Time &nbsp&nbsp|&nbsp&nbsp </th>
                        <th>End Date and Time &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Attachment &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Motive &nbsp&nbsp|&nbsp&nbsp</th>
                        <th>Approval</th>
                    </tr>

                    @for($i=0;$i<count($array_absences);$i+=5)
                        <tr>
                        <td> {{$array_absences[$i]}} </td>
                        <td> {{$array_absences[$i+1]}} </td>
                        <td> {{$array_absences[$i+4]}} </td>
                        <td> {{$array_absences[$i+3]}} </td>
                        <td> {{$array_absences[$i+2]}} </td>
                        </tr>

                    @endfor
                    </table>

                @endif


                    <!-- Button trigger modal absence -->
                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAbsence">
                    ADD NEW ABSENCE
                    </button>

                    </div>


                </div>

                <!-- <p>{{ session('msgAbs') }}</p> -->

            </div>

        </div>


                    <!-- Modal Absences -->
                    <div class="modal fade" id="modalAbsence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">CREATE NEW ABSENCE</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/absences" method="POST" class="action">
                        <div class="modal-body">

                            @csrf

                            <label for="type">Type of Absence</label>
                            <select name="type" id="type">
                                <option value="2">Excused Absence</option>
                                <option value="3">Unexcused Absence</option>
                                <option value="4">Maternity Leave</option>
                                <option value="5">Medical Leave</option>
                            </select>

                            <br><br>

                            <label for="motive">Motive</label>
                            <input type="text" id="motive" name="motive">

                            <br><br>

                            <label for="start_date" >Start Date</label>
                            <input type="datetime-local" id="start_date" name="start_date">

                            <br><br>

                            <label for="end_date">End Date </label>
                            <input type="datetime-local" id="end_date" name="end_date">

                            <br><br>

                            <label for="attachment">Attach File</label>
                            <input type="file" id="attachment" name="attachment" accept="file_extension|pdf/*|image">

                            <br><br>

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


                    <!-- Modal Vacations -->
                    <div class="modal fade" id="modalVacation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">CREATE NEW VACATION</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/absences" method="POST" class="action">
                        <div class="modal-body">

                        @csrf

                        <label for="start_date" >Start Date </label>
                        <input type="date" id="start_date" name="start_date">

                        <br><br>

                        <label for="end_date">End Date </label>
                        <input type="date" id="end_date" name="end_date">

                        <br><br>

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
                        <form action="/absences" method="POST" class="action">
                        <div class="modal-body">

                        @csrf

                        <input type="hidden" value=3 name="op">

                        <!-- <input type="submit" value="ADD VACATION"> -->


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



    </body>
    <!-- JAVASCRIPT FOR HIDE/SHOW VACATION/ABSENCES TAB -->
    <script>
            function openPage(pageName,elmnt,color) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(pageName).style.display = "block";
            elmnt.style.backgroundColor = color;
            }

            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
    </script>
    <!-- END JAVASCRIPT FOR HIDE/SHOW TAB -->
    <!-- JAVASCRIPT FOR MODAL -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- END JAVASCRIPT FOR MODAL -->

    <!-- JAVASCRIPT POP UP MESSAGE -->
    <script>
        var msg = '{{Session::get('msgAbs')}}';
        var exist = '{{Session::has('msgAbs')}}';
        if(exist){
        alert(msg);
        }
    </script>
    <!-- END JAVASCRIPT POP UP MESSAGE -->



@endsection

