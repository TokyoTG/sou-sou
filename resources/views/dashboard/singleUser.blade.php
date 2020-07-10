@extends('layout.base')
@section('custom_css')




@endsection

@section('contents')
  <div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">          
                    <div class="card-header">
                        <strong class="card-title">User Information</strong>
                    </div>
                    <div class="card-body">
                      
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <ul class="nav flex-column nav-tabs user-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#user-details" data-toggle="tab">Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="#groups" data-toggle="tab">Groups</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="user-details">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Basic Informations</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Fullname</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ isset($user_details['first_name'])  &&  isset($user_details['last_name']) ? $user_details['first_name'] ." ". $user_details['last_name']: "full name" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Email</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ isset($user_details['email']) ? $user_details['email'] : "Email" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Status</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="badge badge-success">active</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>No. of Groups</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="badge badge-primary">3</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="groups">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">User Groups</h4>
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                           <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                     <td>
                                                <div class="btn-group mt-2 mr-1">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">View Group</a>
                                                    <a class="dropdown-item" href="#">Active Position</a>
                                                    <a class="dropdown-item" href="#">Deactivate Position</a>
                                                </div>
                                            </div>
                                            </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div>
@endsection

@section('custom_js')
    
@endsection