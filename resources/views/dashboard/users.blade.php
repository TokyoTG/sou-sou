@extends('layout.base')


@section('title')
    <h4>Users</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection

@section('newBtn')
 <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
     <i class="fa fa-plus my-float"></i></button>
@endsection
@section('contents')

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
    {{ Session::get('message') }}</p>
@endif
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
                    <tbody>
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
                          
                        }elseif($datediff >= 2) {
                              $join_date = $datediff." Days ago";
                        }else{
                                $join_date = "Yestarday";
                              }
                        @endphp
                             
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
                                            <a 
                                            class="dropdown-item" 
                                            href="#"
                                            data-user_id={{$user->id}}
                                            data-user_name={{$user->full_name}}
                                            onclick="showModal(this)"
                                            >Delete</a>
                                            <form action="{{ route('users.destroy',$user->id) }}" method="POST" id={{"user".$user->id}}>
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                            </form>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                         
                        @endforeach
                        </tbody> 
                         
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
                <h5 class="modal-title" id="myModalLabel">Register a New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action={{route('users.store')}}>
                    @csrf
                <div class="form-group row">
                    <input type="hidden" name="role_admin" value="admin">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="first_name" class="control-label mb-1">First Name</label>
                        <input type="text" class="form-control form-control-user" id="exampleFirstName" name="first_name" >
                    </div>
                    <div class="col-sm-6">
                        <label for="last_name" class="control-label mb-1">Last Name</label>
                        <input type="text" class="form-control form-control-user" id="exampleLastName" name="last_name" >
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="email" class="control-label mb-1">Email</label>
                       <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" >
                    </div>
                    <div class="col-sm-6">
                        <label for="phone_number" class="control-label mb-1">Phone Number</label>
                      <input type="tel" class="form-control form-control-user" id="exampleLastName" name="phone_number">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="password" class="control-label mb-1">Password</label>
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" >
                    </div>
                    <div class="col-sm-6">
                        <label for="password_confirmation" class="control-label mb-1">Confirm Password</label>
                      <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" name="password_confirmation">
                    </div>
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

<div id="user" class="modal fade">
	<div class="modal-dialog modal-confirm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
                    <i class="fa fa-times"></i>
				</div>						
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to delete <span id="u-name"></span> from users ? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" id="submit-action" onclick="submitForm()">Proceed</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('custom_js')
<script>

    let user_id;
    function showModal(element){
        let user_name = element.dataset.user_name;
        user_id =element.dataset.user_id;
        $('#u-name').text(user_name);
        $('#user').modal('show');
    }

    function submitForm(){
        $(`#user${user_id}`).submit();
    }

    
</script>
@endsection