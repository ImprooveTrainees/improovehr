@extends('layouts.template')

@section('title')
    Improove HR - Employees
@endsection

@section('sidebaremployees')
active
@endsection

@section('content')

<div class="shadow p-1 bg-white cardbox1">
    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="pills-employees-tab" data-toggle="pill" href="#pills-employees" role="tab" aria-controls="pills-employees" aria-selected="true">Your Teams</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-allEmployees-tab" data-toggle="pill" href="#pills-allEmployees" role="tab" aria-controls="pills-allEmployees" aria-selected="false">All Employees</a>
          </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-register-tab" data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register Employee</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-registerTeam-tab" data-toggle="pill" href="#pills-registerTeam" role="tab" aria-controls="pills-registerTeam" aria-selected="false">Register Team</a>
          </li>
      </ul>

{{-- Principal DIV --}}
<div class="tab-content" id="pills-tabContent">


<!-- DIV Employees List -->
<div class="tab-pane fade show active" id="pills-employees" role="tabpanel" aria-labelledby="pills-employees-tab">
<!-- Dynamic Table Full -->
<div class="block">
    <div class="block-content-full">

        {{-- Alerts --}}
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <!-- Teams -->
        @for($v = 0; $v < $tablesCount->count(); $v++)
        <h3>{{$LoggedUserTeamsArrayTeamName[$v]->description}}</h3>
        <table class="table js-dataTable-buttons table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 15%;">Photo</th>
                    <th style="width: 15%;">Name</th>
                    <th style="width: 15%;">Company</th>
                    <th style="width: 15%;">Role</th>
                    <th style="width: 15%;">Department</th>
                    <th style="width: 15%;">Time</th>
                    <th style="width: 15%;">Staff Manager</th>
                    <th style="width: 15%;">Leader</th>
                    @if($userLogged->idusertype == 1 || $userLogged->idusertype == 2 || $userLogged->idusertype == 3) <!-- se forem users com previlegios -->
                        <th style="width: 15%;">Edit</th>
                        <th style="width: 15%;">Remove from team</th>
                        <th style="width: 15%;">Delete User</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            <tr>
            @for($c = 0; $c < count($LoggedUserTeamsArrayUserId); $c++)
                    @if($LoggedUserTeamsArrayTeamId[$c]->id == $tablesCount[$v]->teamID) <!-- Enquanto a team for a mesma, ele adiciona os membros á table -->
                            @if($LoggedUserTeamsArrayUserId[$c]->photo == null)
                                    <td>No profile image</td>
                            @else
                                <td><img class='sliderResize' src={{$LoggedUserTeamsArrayUserId[$c]->photo}}></td>
                            @endif
                            <td>{{$LoggedUserTeamsArrayUserId[$c]->name}}</td>
                            @if($LoggedUserTeamsArrayUserId[$c]->officeDescricao($LoggedUserTeamsArrayUserId[$c]->id,$LoggedUserTeamsArrayUserId[$c]->country) == null)
                                <td>Por definir</td>
                            @else
                                <td>{{$LoggedUserTeamsArrayUserId[$c]->officeDescricao($LoggedUserTeamsArrayUserId[$c]->id,$LoggedUserTeamsArrayUserId[$c]->country)}}</td>
                            @endif
                            <td>{{$LoggedUserTeamsArrayUserId[$c]->contractUser->position}}</td>
                            <?php $departTeamLoggedIn = true; ?>
                            @if($LoggedUserTeamsArrayUserId[$c]->departments->first() == null)
                                <td>Por definir</td>
                                <?php $departTeamLoggedIn = false; ?>
                            @else
                                <td>{{$LoggedUserTeamsArrayUserId[$c]->departments->first()->description}}</td>
                            @endif
                            <?php
                                $actualYear = date("Y/m/d");
                                $date1=date_create($LoggedUserTeamsArrayUserId[$c]->contractUser->start_date);
                                $date2=date_create($actualYear);
                                $diff=date_diff($date1,$date2);
                                $tempoEmpresaTeamLoggedIn = $diff->format("%Y%")." years";
                            ?>
                            <td>{{$tempoEmpresaTeamLoggedIn}}</td>
                            @if(!$departTeamLoggedIn)
                                <td>Por definir</td>
                            @elseif($LoggedUserTeamsArrayUserId[$c]->name == $LoggedUserTeamsArrayUserId[$c]->managerDoUser($LoggedUserTeamsArrayUserId[$c]->departments->first()->description, $LoggedUserTeamsArrayUserId[$c]->country))
                                <td> ------- </td>
                            @else
                                <td>{{$LoggedUserTeamsArrayUserId[$c]->managerDoUser($LoggedUserTeamsArrayUserId[$c]->departments->first()->description, $LoggedUserTeamsArrayUserId[$c]->country)}}</td>
                            @endif
                            {{-- <td>{{$leaderArray[$b]}}</td> --}}
                            <td>{{$LoggedUserTeamsArrayTeamLeaders[$c]}}</td>
                            @if($userLogged->idusertype == 1)
                                <td><button onclick='modalOpen({{$LoggedUserTeamsArrayUserId[$c]->id}})' value={{$LoggedUserTeamsArrayUserId[$c]->id}}><i class='fas fa-user-edit'></i></button></td>
                                <td><a href="/remTeamMember/{{$LoggedUserTeamsArrayUserId[$c]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                <td><a href='/deleteEmployee/{{$LoggedUserTeamsArrayUserId[$c]->id}}'><i class="fas fa-user-slash"></i></a></td>
                            @elseif($userLogged->idusertype == 2)
                                @if($LoggedUserTeamsArrayUserId[$c]->idusertype != 1 && $LoggedUserTeamsArrayUserId[$c]->idusertype != 2)
                                    <td><button onclick='modalOpen({{$LoggedUserTeamsArrayUserId[$c]->id}})' value={{$LoggedUserTeamsArrayUserId[$c]->id}}><i class='fas fa-user-edit'></i></button></td>
                                    <td><a href="/remTeamMember/{{$LoggedUserTeamsArrayUserId[$c]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                    <td><a href='/deleteEmployee/{{$LoggedUserTeamsArrayUserId[$c]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                @endif

                            @elseif($userLogged->idusertype == 3)
                                @if($LoggedUserTeamsArrayUserId[$c]->idusertype != 1 && $LoggedUserTeamsArrayUserId[$c]->idusertype != 2 && $LoggedUserTeamsArrayUserId[$c]->idusertype != 3)
                                    <td><button onclick='modalOpen({{$LoggedUserTeamsArrayUserId[$c]->id}})' value={{$LoggedUserTeamsArrayUserId[$c]->id}}><i class='fas fa-user-edit'></i></button></td>
                                    <td><a href="/remTeamMember/{{$LoggedUserTeamsArrayUserId[$c]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                    <td><a href='/deleteEmployee/{{$LoggedUserTeamsArrayUserId[$c]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                @endif
                            @endif
                                        {{-- <p>{{$LoggedUserTeamsArrayTeamId[$c]->id}}</p> --}}

                        @endif
                    </tr>
                    @endfor
                </tbody>
        </table>
        @endfor
    </div>
</div>
<!-- END Dynamic Table Full -->
</div>

{{-- ALL EMPLOYEES TAB --}}
<div class="tab-pane fade show" id="pills-allEmployees" role="tabpanel" aria-labelledby="pills-allEmployees-tab">
    <div class="block">
        <div class="block-content-full">
            <div id="allEmployees">
                <h3>All Employees Table</h3>

        <table class="table js-dataTable-buttons table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th >Photo</th>
                    <th>Name</th>
                    <th class="d-sm-table-cell">Company</th>
                    <th class="d-sm-table-cell">Role</th>
                    <th style="width: 15%;">Department</th>
                    <th style="width: 15%;">Time</th>
                    <th style="width: 15%;">Staff Manager</th>
                    @if($userLogged->idusertype == 1 || $userLogged->idusertype == 2 || $userLogged->idusertype == 3) <!-- se forem users com previlegios -->
                        <th>Edit</th>
                        <th>Delete User</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <?php echo $msg ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>
</div>
{{-- END ALL EMPLOYEES TAB --}}


<!-- DIV Register New Employee -->
        <div class="tab-pane fade marginLeft" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
            <div id="insertNewTeam">
            <p>Register Employee</p>
            <hr>
            <form method="POST" class="form-group" action="/newEmployeeRegister">
                @csrf

                <div class="form-group newname">
                    <label for="form-group newname">Name:</label>
                    <input type="text" name="name" class="form-control" placeholder="Insert Name" required>
                </div>

                <div class="form-group email">
                    <label for="form-group email">Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Insert Email" required>
                </div>

                <div class="form-group departmentEmployeesAlign">
                    <label for="form-group departmentEmployeesAlign">Department:</label>
                    <select class="form-control" name="Department" required>
                            @foreach($departmentList as $department)
                             <option value={{$department->id}}>{{$department->description}}</option>
                             @endforeach
                      </select>
                </div>

                <div class="form-group roleregister">
                    <label for="form-group roleregister">Role:</label>
                    <select class="form-control" name="role" id="exampleRole" required>
                             <option>Manager</option>
                             <option value="Project Manager">Project Manager</option>
                             <option value="Front End Developer">Front-End Developer</option>
                             <option value="Back End Developer">Back-End Developer</option>
                             <option>Human Resources</option>
                             <option id="otherrole" value="other">Other</option>
                      </select>
                </div>

                <div class="form-group" id="rolenew">
                    <label>Other Role:</label>
                    <input type="text" name="otherRole" class="form-control" placeholder="Insert New Role">
                </div>

                <div class="form-group registerButton">
                    <button type="submit" class="form-group btn btn-outline-primary bprofile">Save</button>
                </div>
            </form>
        </div>
        </div>
<!-- END DIV Register New Employee -->


    {{-- REGISTER TEAM TAB--}}
        <div class="tab-pane fade" id="pills-registerTeam" role="tabpanel" aria-labelledby="pills-registerTeam-tab">

            <div id="insertNewTeam">
                <p>New Team</p>
                <hr>
                <form method="get" action="/newTeam">
                    @csrf
                <div id="newTeamName">
                    <label for="">Insert team name:</label>
                    <input name="teamName" type="text" class="form-control" required>
                </div>

                <div id="teamLeader">
                    <label for="">Select team leader:</label>
                    <select name="teamLeader" class="form-control">
                        @foreach($userLeaders as $leader)
                            @if($userLogged->idusertype == 1)
                                <option value={{$leader->id}}>{{$leader->name}}</option>
                            @else
                                @if($userLogged->country == $leader->country)
                                    <option value={{$leader->id}}>{{$leader->name}}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary bprofile" id="btnCreateTeam">Create team</button>
                </form>
            </div>

        <div id="teamManagement">
            <p>Team Management</p>
            <hr>
            <form method="get" action="/showTeam">
                @csrf
                @if($allTeams->count() == 0)
                   <p>There are no teams to manage!</p>
                @else
                <div id="selectTeam">
                    <label>Select team:</label>
                    <select id="selectTeamID" name="teamDetailsId" class="form-control">
                        @foreach($allTeams as $team)
                            <option value={{$team->id}}>{{$team->description}}<i class="fas fa-times"></i></option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <button type="submit" id="showTeamDetails" class="btn btn-outline-primary bprofile">Show team details</button>
            </form>
        </div>

        <div id="addMembers">
            @if(isset($selectedTeamMembersArray)) <!-- Caso retorne as vars da form executada -->
                <p>New Members</p>
                <hr>
                <label>Add member(s):</label>
                <form method="get" action="/addTeamMember">
                    @csrf
                        <input class="form-control" type="hidden" name="teamID" value={{$teamDetailsId}}>
                @foreach($users as $user)
                <div id="teamMembers">
                    <input class="form-control" type="checkbox" name="usersTeam[]" value={{$user->id}}>
                    <label for={{$user->name}}>{{$user->name}}</label>
                </div>
                @endforeach

                <div id="addLeader">
                    <label>Leader:</label>
                    <select name="leaderCheck" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <button type="submit" id="btnAddMembers" class="btn btn-outline-primary">Add members</button>
                </div>
            </form>
        </div>
        <!-- Logged User Teams -->
        <div id="yourTeams">
                <h4>{{$teamName}}</h4>
                <table class="table js-dataTable-full">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" style="width: 80px;">Photo</th>
                            <th>Name</th>
                            <th class="d-sm-table-cell" style="width: 30%;">Company</th>
                            <th class="d-sm-table-cell" style="width: 15%;">Role</th>
                            <th style="width: 15%;">Department</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 15%;">Staff Manager</th>
                            <th style="width: 15%;">Leader</th>
                            @if($userLogged->idusertype == 1 || $userLogged->idusertype == 2 || $userLogged->idusertype == 3) <!-- se forem users com previlegios -->
                                <th>Edit</th>
                                <th>Remove from team</th>
                                <th>Delete User</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @for($b = 0; $b < count($selectedTeamMembersArray); $b++)
                        <tr>
                                @if($selectedTeamMembersArray[$b]->photo == null)
                                     <td>No profile image</td>
                                @else
                                    <td><img class='sliderResize' src={{$selectedTeamMembersArray[$b]->photo}}></td>
                                @endif
                                <td>{{$selectedTeamMembersArray[$b]->name}}</td>
                                @if($selectedTeamMembersArray[$b]->officeDescricao($selectedTeamMembersArray[$b]->id,$selectedTeamMembersArray[$b]->country) == null)
                                    <td>Por definir</td>
                                @else
                                    <td>{{$selectedTeamMembersArray[$b]->officeDescricao($selectedTeamMembersArray[$b]->id,$selectedTeamMembersArray[$b]->country)}}</td>
                                @endif
                                <td>{{$selectedTeamMembersArray[$b]->contractUser->position}}</td>
                                <?php $depart = true; ?>
                                @if($selectedTeamMembersArray[$b]->departments->first() == null)
                                    <td>Por definir</td>
                                    <?php $depart = false; ?>
                                @else
                                    <td>{{$selectedTeamMembersArray[$b]->departments->first()->description}}</td>
                                @endif
                               <?php
                                 $actualYear = date("Y/m/d");
                                 $date1=date_create($selectedTeamMembersArray[$b]->contractUser->start_date);
                                 $date2=date_create($actualYear);
                                 $diff=date_diff($date1,$date2);
                                 $tempoEmpresaTeam = $diff->format("%Y%")." years";
                               ?>
                               <td>{{$tempoEmpresaTeam}}</td>
                               @if(!$depart)
                                    <td>Por definir</td>
                               @elseif($selectedTeamMembersArray[$b]->name == $selectedTeamMembersArray[$b]->managerDoUser($selectedTeamMembersArray[$b]->departments->first()->description, $selectedTeamMembersArray[$b]->country))
                                    <td> ------- </td>
                               @else
                                    <td>{{$selectedTeamMembersArray[$b]->managerDoUser($selectedTeamMembersArray[$b]->departments->first()->description, $selectedTeamMembersArray[$b]->country)}}</td>
                               @endif
                                <td>{{$leaderArray[$b]}}</td>
                               @if($userLogged->idusertype == 1)
                                    <td><button onclick='modalOpen({{$selectedTeamMembersArray[$b]->id}})' value={{$selectedTeamMembersArray[$b]->id}}><i class='fas fa-user-edit'></i></button></td>
                                    <td><a href="/remTeamMember/{{$selectedTeamMembersArray[$b]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                    <td><a href='/deleteEmployee/{{$selectedTeamMembersArray[$b]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                @elseif($userLogged->idusertype == 2)
                                    @if($selectedTeamMembersArray[$b]->idusertype != 1 && $selectedTeamMembersArray[$b]->idusertype != 2)
                                        <td><button onclick='modalOpen({{$selectedTeamMembersArray[$b]->id}})' value={{$selectedTeamMembersArray[$b]->id}}><i class='fas fa-user-edit'></i></button></td>
                                        <td><a href="/remTeamMember/{{$selectedTeamMembersArray[$b]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                        <td><a href='/deleteEmployee/{{$selectedTeamMembersArray[$b]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                    @endif

                                @elseif($userLogged->idusertype == 3)
                                    @if($selectedTeamMembersArray[$b]->idusertype != 1 && $selectedTeamMembersArray[$b]->idusertype != 2 && $selectedTeamMembersArray[$b]->idusertype != 3)
                                        <td><button onclick='modalOpen({{$selectedTeamMembersArray[$b]->id}})' value={{$selectedTeamMembersArray[$b]->id}}><i class='fas fa-user-edit'></i></button></td>
                                        <td><a href="/remTeamMember/{{$selectedTeamMembersArray[$b]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                        <td><a href='/deleteEmployee/{{$selectedTeamMembersArray[$b]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                    @endif
                                @endif

                        </tr>
                        @endfor
                    </tbody>
                </table>
        @endif
        </div>
        <!-- End Logged User Teams -->

        {{-- END REGISTER TEAM TAB --}}
    </div>
{{-- END pills-tabContent Principal --}}
</div>
{{-- END cardbox1 --}}
</div>



<!-- Trigger/Open The Modal -->
<!-- The Modal Edit Employee -->
<div class="modal" id="editProfessionaInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document" id="modalEmployees">
    <!-- Modal content -->
    <div class="modal-content" id="modalEmployees2">
        <div class="modal-header">
            <span class="close">&times;</span>
        </div>
      <div class="modal-body">
          <div id="infoModal">
        <form id="professionalEditForm" action="/editProfessionalInfo">
                @csrf
                <div class="froleLabel">
                    <label for="form-group newname">Role:</label>
                </div>
            <select class="form-control" name="roleEditProf" id="exampleRole2" required>
                    <option>Manager</option>
                    <option value="Project Manager">Project Manager</option>
                    <option value="Front End Developer">Front-End Developer</option>
                    <option value="Back End Developer">Back-End Developer</option>
                    <option>Human Resources</option>
                    <option value="other">Other</option>
            </select>

                <div id="rolenew2">
                    <label>Other Role:</label>
                    <input type="text" name="otherRole" class="form-control" placeholder="Insert New Role">
                </div>
                <div class="typeContract">
                    <label for="form-group newname">Type of contract:</label>
                </div>
            <select class="form-control" name="contractTypeEdit">
            @foreach($contractTypes as $cont)
                <option value={{$cont->id}}>{{$cont->description}}</option>
            @endforeach
            </select>
            <div class="departmentEmployees">
                <label for="form-group newname">Department:</label>
            </div>
            <select class="form-control" name="departmentTypeEdit">
                @foreach($departments as $dep)
                    <option value={{$dep->id}}>{{$dep->description}}</option>
                @endforeach
            </select>
            <div class="beginContract">
                <label for="newname">Contract begin:</label>
            </div>
            <input class="form-control" name="dateBeginEditProf" type="date">
            <div class="endContract">
                <label for="newname">End of contract:</label>
            </div>
            <input class="form-control" name="dateEndEditProf" type="date">
            <div class="emailContract">
                <label for="newname">Company Email:</label>
            </div>
            <input class="form-control" name="companyMailProfInfo" type="text">
            <div class="mobileCompany">
                <label for="newname">Company Mobile:</label>
            </div>
            <input class="form-control" name="companyMobileProfInfo" type="number">
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" type="submit" id="saveEmployees">Save</button>
                </div>
        </form>
    </div>
      </div>
    </div>
    </div>
</div>


<script>
function confirmDelete() {

    if(!confirm("Are You Sure you want to delete this user?"))
      event.preventDefault();

}

    </script>

@endsection
