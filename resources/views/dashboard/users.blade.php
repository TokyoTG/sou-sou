@extends('layout.base')


@section('title')
    <h4>Users</h4>
@endsection

@section('newBtn')
 <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
     <i class="fa fa-plus my-float"></i></button>
@endsection
@section('contents')


  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                @isset($users)
                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Account Number</th>
                            <th>Phone Number</th>
                            <th>No. of Groups</th>
                            <th>Reg. Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @if(count($users) > 0)
                        @foreach ($users as $user)
                        @php
    
                        $now = time(); 
                        $your_date = strtotime($user->created_at);
                        $datediff = round(($now - $your_date) / 86400);   
                        if($datediff < 1){
                            $datediff = round(($now - $your_date) / 3600);
                            $join_date = $datediff."Hours ago";
                            if($datediff > 0){
                                if($datediff > 1){
                                    $join_date = $datediff." Hours ago";
                                }else{
                                    $join_date = $datediff." Hour ago";
                                }
                            }else{
                                $datediff = round(($now - $your_date) / 60);
                               
                                if($datediff > 1){
                                 $join_date = $datediff." Minutes ago";
                                }else{
                                    $join_date = $datediff." Minute ago";
                                }
                            }
                          
                        }else {
                              $join_date = $datediff."Days";
                        }
                        @endphp
                              <tbody>
                                <tr>
                                    <td>{{$user->full_name}}</td>
                                <td>{{ isset($user->account_number)  ? $user->account_number : "Not Set"}}</td>
                                    <td>{{$user->phone_number}}</td>
                                <td>{{ isset($user->groups_in)  ? $user->groups_in : "Not Set"}}</td>
                                    <td>{{$join_date}}</td>
                                    <td>
                                        <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('users.show',$user->id)}}">View User</a>
                                            <a class="dropdown-item" href="#">Active</a>
                                            <a class="dropdown-item" href="#">Freez</a>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            </tbody> 
                        @endforeach

                         
                    </table>
                    @endif
                @endisset
                  
              </div>
            </div>
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