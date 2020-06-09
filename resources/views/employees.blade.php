@extends('layouts.template')

@section('title')
    Improove HR - Employees
@endsection

@section('sidebaremployees')
active
@endsection

@section('content')

<div class="shadow p-1 bg-white cardbox1">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="pills-employees-tab" data-toggle="pill" href="#pills-employees" role="tab" aria-controls="pills-employees" aria-selected="true">Employees</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-register-tab" data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a>
        </li>
      </ul>

    {{-- Principal DIV --}}
      <div class="tab-content" id="pills-tabContent">


<!-- DIV Employees List -->
<div class="tab-pane fade show active" id="pills-employees" role="tabpanel" aria-labelledby="pills-employees-tab">
<!-- Dynamic Table Full -->
<div class="block">
    <div class="block-content block-content-full">

        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif


        <!-- Teams -->
            <h3>Teams</h3>

            <h4>New Team</h4>

            <form method="get" action="/newTeam">
                @csrf
            Insert team name: <input name="teamName" type="text">
            Select team leader: 
            <select name="teamLeader">
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

            <button type="submit">Create team</button>
            </form>

            <h4>Team Management</h4>
        <form method="get" action="/showTeam">
            @csrf
            @if($allTeams->count() == 0)
                There are no teams to manage!
            @else
            <strong>Select team:</strong>
            <select id="selectTeamID" name="teamDetailsId">
                @foreach($allTeams as $team)
                    <option value={{$team->id}}>{{$team->description}}<i class="fas fa-times"></i></option>
                @endforeach
            </select>
            @endif
            <button type="submit">Show team details</button>
        </form>

            {{-- @if($bla == true)
              asdasd
                 

            @endif --}}
        @if(isset($selectedTeamMembersArray)) <!-- Caso retorne as vars da form executada -->
            <strong>Add member(s):</strong> <br>
            
            <form method="get" action="/addTeamMember">
                @csrf
                <input type="hidden" name="teamID" value={{$teamDetailsId}}>
            @foreach($users as $user)
                    <input type="checkbox" name="usersTeam[]" value={{$user->id}}>
                    <label for={{$user->name}}>{{$user->name}}</label>
            @endforeach
            <strong>Leader:</strong> 
            <select name="leaderCheck">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            <br>
            <button type="submit">Add members</button>
            </form>
                <h4>Team Name: {{$teamName}}</h4>
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">Photo</th>
                            <th>Name</th>
                            <th class="d-none d-sm-table-cell" style="width: 30%;">Company</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Role</th>
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
                                        <td><button onclick='modalOpen({{$selectedTeamMembersArray[$b]->id}})' value={{$selectedTeamMembersArray[$b]->id}}><i class='fas fa-user-edit'></i></button></td>~
                                        <td><a href="/remTeamMember/{{$selectedTeamMembersArray[$b]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                        <td><a href='/deleteEmployee/{{$selectedTeamMembersArray[$b]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                    @endif
                                @endif 
                                    
                        </tr>
                        @endfor
                    </tbody>
                </table>


        @endif
       

        @for($v = 0; $v < $tablesCount->count(); $v++)
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">Photo</th>
                    <th>Name</th>
                    <th class="d-none d-sm-table-cell" style="width: 30%;">Company</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Role</th>
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
                            {{-- <td>{{$leaderArray[$b]}}</td> --}}~
                            <td>Lider?</td>
                            @if($userLogged->idusertype == 1) 
                                <td><button onclick='modalOpen({{$LoggedUserTeamsArrayUserId[$c]->id}})' value={{$LoggedUserTeamsArrayUserId[$c]->id}}><i class='fas fa-user-edit'></i></button></td>
                                <td><a href="/remTeamMember/{{$LoggedUserTeamsArrayUserId[$c]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                <td><a href='/deleteEmployee/{{$LoggedUserTeamsArrayUserId[$c]->id}}'><i class="fas fa-user-slash"></i></a></td>
                            @elseif($userLogged->idusertype == 2) 
                                @if($LoggedUserTeamsArrayTeamId[$c]->idusertype != 1 && $LoggedUserTeamsArrayTeamId[$c]->idusertype != 2) 
                                    <td><button onclick='modalOpen({{$LoggedUserTeamsArrayTeamId[$c]->id}})' value={{$LoggedUserTeamsArrayTeamId[$c]->id}}><i class='fas fa-user-edit'></i></button></td>
                                    <td><a href="/remTeamMember/{{$LoggedUserTeamsArrayTeamId[$c]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                    <td><a href='/deleteEmployee/{{$LoggedUserTeamsArrayTeamId[$c]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                @endif
                            
                            @elseif($userLogged->idusertype == 3) 
                                @if($LoggedUserTeamsArrayTeamId[$c]->idusertype != 1 && $LoggedUserTeamsArrayTeamId[$c]->idusertype != 2 && $LoggedUserTeamsArrayTeamId[$c]->idusertype != 3) 
                                    <td><button onclick='modalOpen({{$LoggedUserTeamsArrayTeamId[$c]->id}})' value={{$LoggedUserTeamsArrayTeamId[$c]->id}}><i class='fas fa-user-edit'></i></button></td>~
                                    <td><a href="/remTeamMember/{{$LoggedUserTeamsArrayTeamId[$c]->id}}"><i class="fas fa-user-minus"></i></a></td>
                                    <td><a href='/deleteEmployee/{{$LoggedUserTeamsArrayTeamId[$c]->id}}'><i class="fas fa-user-slash"></i></a></td>
                                @endif
                            @endif 
                                        {{-- <p>{{$LoggedUserTeamsArrayTeamId[$c]->id}}</p> --}}
                                
                        @endif
                    @endfor
                </tr>
                </tbody>
                     </table>
        @endfor
    

        {{-- @for($v = 0; $v < $tablesCount->count(); $v++)
        <p>table</p>
            @for($c = 0; $c < count($LoggedUserTeamsArrayUserId); $c++)
                    @if($LoggedUserTeamsArrayTeamId[$c]->id == $tablesCoun[$v]->teamID) 
                        <p>{{$LoggedUserTeamsArrayUserId[$c]->id}}</p>
                       
                 
                    @endif
            @endfor
          <p> end table</p>
       @endfor --}}


        <!-- Teams -->


        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">Photo</th>
                    <th>Name</th>
                    <th class="d-none d-sm-table-cell" style="width: 30%;">Company</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Role</th>
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
                {{-- <tr>
                    <td class="text-center font-size-sm">1</td>
                    <td class="font-w600 font-size-sm">
                        <a href="be_pages_generic_blank.html">Albert Ray</a>
                    </td>
                    <td class="d-none d-sm-table-cell font-size-sm">
                        client1<em class="text-muted">@example.com</em>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="badge badge-info">Manager</span>
                    </td>
                    <td>
                        <em class="text-muted font-size-sm">2 days ago</em>
                    </td>
                </tr>
                <tr>
                    <td class="text-center font-size-sm">2</td>
                    <td class="font-w600 font-size-sm">
                        <a href="be_pages_generic_blank.html">Megan Fuller</a>
                    </td>
                    <td class="d-none d-sm-table-cell font-size-sm">
                        client2<em class="text-muted">@example.com</em>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="badge badge-warning">Human Resources</span>
                    </td>
                    <td>
                        <em class="text-muted font-size-sm">7 days ago</em>
                    </td>
                </tr>
                <tr>
                    <td class="text-center font-size-sm">3</td>
                    <td class="font-w600 font-size-sm">
                        <a href="be_pages_generic_blank.html">Thomas Riley</a>
                    </td>
                    <td class="d-none d-sm-table-cell font-size-sm">
                        client3<em class="text-muted">@example.com</em>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="badge badge-success">Developer</span>
                    </td>
                    <td>
                        <em class="text-muted font-size-sm">2 days ago</em>
                    </td>
                </tr>
                <tr>
                    <td class="text-center font-size-sm">4</td>
                    <td class="font-w600 font-size-sm">
                        <a href="be_pages_generic_blank.html">Jose Mills</a>
                    </td>
                    <td class="d-none d-sm-table-cell font-size-sm">
                        client4<em class="text-muted">@example.com</em>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="badge badge-primary">Marketer</span>
                    </td>
                    <td>
                        <em class="text-muted font-size-sm">4 days ago</em>
                    </td>
                </tr>
                <tr>
                    <td class="text-center font-size-sm">5</td>
                    <td class="font-w600 font-size-sm">
                        <a href="be_pages_generic_blank.html">Barbara Scott</a>
                    </td>
                    <td class="d-none d-sm-table-cell font-size-sm">
                        client5<em class="text-muted">@example.com</em>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="badge badge-warning">Human Resources</span>
                    </td>
                    <td>
                        <em class="text-muted font-size-sm">8 days ago</em>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>
<!-- END Dynamic Table Full -->
    </div>

<!-- DIV Register New Employee -->
        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
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
                             <option selected="selected" value="Front End Developer">Front-End Developer</option>
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
                    <button type="submit" class="form-group btn btn-outline-primary registeremployee">Save</button>
                </div>
            </form>
        </div>
      </div>

</div>


<!-- Trigger/Open The Modal -->

  <!-- The Modal -->
<div id="editProfessionaInfoModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
        <form id="professionalEditForm" action="/editProfessionalInfo">
            @csrf
            Role:
        <select class="form-control" name="roleEditProf" id="exampleRole" required>
                <option>Manager</option>
                <option value="Project Manager">Project Manager</option>
                <option selected="selected" value="Front End Developer">Front-End Developer</option>
                <option value="Back End Developer">Back-End Developer</option>
                <option>Human Resources</option>
                <option value="other">Other</option>
        </select>
        pôr hidden div (other role)
        <br>
        Type of contract: <br>
        <select name="contractTypeEdit">
        @foreach($contractTypes as $cont)
            <option value={{$cont->id}}>{{$cont->description}}</option>
        @endforeach
        </select>
        Department:  <br>
        <select name="departmentTypeEdit">
            @foreach($departments as $dep)
                <option value={{$dep->id}}>{{$dep->description}}</option>
            @endforeach
        </select>

        Contract begin: <br>
        <input name="dateBeginEditProf" type="date">

        End of contract: <br>
        <input name="dateEndEditProf" type="date">
        <br>
        Company Email: <br>
        <input name="companyMailProfInfo" type="text">
        <br>
        Company Mobile: <br>
        <input name="companyMobileProfInfo" type="number">
        <br>
        <button type="submit">Save</button>
    </form>
</div>

</div>


<style>
.sliderResize {
    height: 50px;
    width: 60px;
}


.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  margin-left:7%;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>



<script>

function modalOpen(idUser) {
    var modal = document.getElementById("editProfessionaInfoModal");
    // Get the button that opens the modal
    var btn = document.getElementById("editUserModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal

    modal.style.display = "block";

    var form = document.getElementById('professionalEditForm');
    var hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("value",  idUser);
    hiddenInput.setAttribute("id",  "idUser");
    hiddenInput.setAttribute("name",  "idUser");
    form.appendChild(hiddenInput); //cria hidden input com o id do user, que vem do argumento da funcao

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    document.getElementById("idUser").remove(); //remove o hidden value do user quando fecha
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.getElementById("idUser").remove(); //remove o hidden value do user quando fecha
        }
    }


}





</script>





@endsection
