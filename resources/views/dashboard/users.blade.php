@extends('layout.base')


@section('title')
    <h1>Users</h1>
@endsection

@section('newBtn')
 <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
     <i class="fa fa-plus my-float"></i></button>
@endsection
@section('contents')


  <div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                                
                    <div class="card-header">
                        <strong class="card-title">All Users</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Account Number</th>
                                    <th>Phone Number</th>
                                    <th>Position</th>
                                    <th>Reg. Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                     <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>
                                        <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('users.show', 2)}}">View User</a>
                                            <a class="dropdown-item" href="#">Active</a>
                                            <a class="dropdown-item" href="#">Deactivate</a>
                                            <a class="dropdown-item" href="#">Delete</a>
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
    </div><!-- .animated -->
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Create New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form >
                <div class="form-group">
                    <label for="full_name" class="control-label mb-1">Full Name</label>
                    <input id="full_name" name="full_name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                </div>
                <div class="form-group">
                    <label for="account_number" class="control-label mb-1">Accout Number</label>
                    <input id="account_number" name="account_number" type="text" class="form-control" aria-required="true" aria-invalid="false">
                </div>
                         <div class="form-group">
                    <label for="phone_number" class="control-label mb-1">Phone Number</label>
                    <input id="phone_number" name="phone_number" type="text" class="form-control" aria-required="true" aria-invalid="false">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label mb-1">Password</label>
                    <input id="password" name="password" type="text" class="form-control" aria-required="true" aria-invalid="false">
                </div>
                  <div class="form-group">
                    <label for="confirm_password" class="control-label mb-1">Confirm Password</label>
                    <input id="confirm_password" name="confirm_password" type="text" class="form-control" aria-required="true" aria-invalid="false">
                </div>
                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Create User</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection

@section('custom_js')
    
@endsection