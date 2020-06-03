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

                
                <div class="form-group departmentEmployeesAlign">
                    <label for="form-group departmentEmployeesAlign">Department:</label>
                    <select class="form-control" name="Department" required>
                            @foreach($departmentList as $department)
                             <option value={{$department->id}}>{{$department->description}}</option>
                             @endforeach
                      </select>
                </div>
                
                <div class="form-group roleregister">
                <button type="submit" class="form-group btn btn-outline-primary registeremployee">Save</button>
                </div>
            </form>
        </div>
      </div>
      
</div>


<!-- Trigger/Open The Modal -->
<button id="editUserModal">Open Modal</button>

  <!-- The Modal -->
<div id="editProfessionaInfoModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <p>Some text in the Modal..</p>
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
// Get the modal
var modal = document.getElementById("editProfessionaInfoModal");

// Get the button that opens the modal
var btn = document.getElementById("editUserModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
    </script>
    
    



@endsection
