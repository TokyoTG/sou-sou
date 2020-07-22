@extends('layout.base')
@section('custom_css')
    
@include('partials.auth_check')

@endsection



@section('title')
    <h4>Wait List</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection

@php

  $list = $data['list'];
  $groups = $data['groups'];


    function position_prepare($value){
      $str = strval($value);
      
      if(strlen($str) <= 1 ){
        
        if(gettype(strpos($str, '1')) == 'integer'){
          $res = $str."st";
          return $res;
        }
        if(gettype(strpos($str, '2')) == 'integer'){
          $res = $str."nd";
          return $res;
        }
        if(gettype(strpos($str, '3')) == 'integer'){
          $res = $str.'rd';
          return $res;
        }else{
          $res =$str. 'th';
          return $res;
        }
      }
      if(strlen($str) > 1){
        if(gettype(strpos($str, '1',1)) == 'integer'){
          $res = $str."st";
          return $res;
        }
        if (gettype(strpos($str, '2',1)) == 'integer') {
            $res = $str. "nd";
            return $res;
        }

        if ( gettype(strpos($str, '3',1)) == 'integer') {
            $res = $str.'rd';
            return $res;
        }else{
          $res =$str. 'th';
        }
      }
      return $res;
    }
@endphp


@section('newBtn')
   @if(is_admin())
 <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" onclick="generateModal()">Generate Group</button>
@endif
@endsection
@section('contents')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
    {{ Session::get('message') }}</p>
@endif
  <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{count($list) > 0 ? $list[0]->group_name ." Group" : ""}}</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                @isset($list)
                  @if (count($list) > 0)
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>User Name</th>
                        <th>Position</th>
                        <th>Date of Request</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $item)
                        <tr>
                          <td>{{$item->user_name}}</td>
                          <td>{{ position_prepare($item->position)}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <div class="btn-group mt-2 mr-1">
                              <button type="button" class="btn btn-primary dropdown-toggle"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                                   <a class="dropdown-item" href="{{route('users.show', $item->user_id)}}">View User</a>
                                  <a class="dropdown-item" href="#"
                                  data-user_id={{$item->id}}
                                  onclick="showModal(this,'addUser')"
                                  data-user_name={{$item->user_name}}
                                    
                                  >Add to Group</a>

                                  {{-- //START ADD USER TO GROUP FORM --}}
                                  <form action="{{route('group_users.store')}}" method="post" id={{"add".$item->id}}>
                                    @csrf
                                    <input type="hidden" name="user_level" class="user-level">
                                    <input type="hidden" name="group_name" class="group_name">
                                    <input type="hidden" name="list_id" value={{$item->id}}>
                                    <input type="hidden" name="user_id" value={{$item->user_id}}>
                                    <input type="hidden" name="user_name" value={{$item->user_name}}>
                                  </form>


                                  {{-- //END ADD USER TO GROUP FORM --}}


                                  {{-- //CHANGE USER POSITION FORM --}}
                                  <form action="{{route('wait_list.update',$item->id)}}" method="post" id={{"update".$item->id}}>
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="input-position" class="input-position">
                                    <input type="hidden" name="old_position"  class="old_position" value={{$item->position}}>
                                  </form>

                                  {{-- //REMOVE USER FORM --}}
                                  <form action="{{ route('wait_list.destroy',$item->id) }}" method="POST" id={{"delete".$item->id}}>
                                    @csrf
                                    @method('DELETE')
                                  </form>
                                  <a class="dropdown-item"
                                  href="#"
                                  onclick="showModal(this,'myModal')"
                                    data-user_id={{$item->id}}
                                    data-user_name={{$item->user_name}}
                                    >Change Position</a>

                                  {{-- //REMOVE USER --}}
                                  <a class="dropdown-item" href="#"
                                  data-user_id={{$item->id}}
                                  onclick="showModal(this,'remove_user')"
                                  data-user_name={{$item->user_name}}
                                  >Remove User</a>
                              </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  @else
                      <p>There are no users on the waiting list</p>
                  @endif
                    
                @endisset
              </div>
            </div>
</div>
    

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">Change Postion</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <label for="position" class="control-label mb-1">Enter New Position for <span class="u-name"></span></label>
                  <input id="position" name="position" type="text" class="form-control" aria-required="true" aria-invalid="false">
              </div>
              <div class="form-group">
                  <div class="col-12">
                      <button type="button" class="btn btn-primary btn-block"  onclick="updatePostion()">Change Position</button>
                  </div>
              </div>
           
          </div>
          <div class="modal-footer">
          </div>

      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div id="remove_user" class="modal fade">
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
				<p>Do you really want to remove <strong class="u-name">GROUP NAME</strong> from wait list ? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button  class="btn btn-primary" onclick="deleteUser()">Proceed</button>
			</div>
		</div>
	</div>
</div>


<div id="addUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">Add <span class="u-name"> </span> to Group</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <p >Please choose one to continue </p>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" name="group" for="level">Chose group</label>
                    </div>
                    <select class="custom-select" id="group-name" name="group-name">
                      <option disabled selected value="">Select One</option>
                      @if (count($groups) > 0)
                          @foreach ($groups as $item)
                          <option value={{$item->name}}>{{$item->name}}</option>
                          @endforeach
                      @else
                          All available groups are closed
                      @endif
                    </select>
                  </div>
                  <p >Please choose one to continue </p>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" name="level" for="level">Chose level</label>
                    </div>
                    <select class="custom-select" id="level">
                      <option disabled selected value="">Select One</option>
                     
                      <option value="water">Water</option>
                      <option value="earth">Earth</option>
                      <option value="air">Air</option>
                      <option value="fire">Fire</option>
                    </select>
                    </div>
              </div>
              <div class="form-group">
                  <div class="col-12">
                      <button type="button" class="btn btn-primary btn-block"  onclick="addUser()">Add User</button>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
          </div>

      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>


<div id="generate" class="modal fade">
	<div class="modal-dialog modal-confirm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>You about to create a new group from wait list, are sure you want to proceed ?</p>
			</div>
			<div class="modal-footer justify-content-center">
                <form action="{{ route('generate') }}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" type="submit">Proceed</button>
             </form>
			
			</div>
		</div>
	</div>
</div>
@endsection

@section('custom_js')
    <script>
         let user_id;
        let user_name;
        function showModal(element,modalName){
             user_id = element.dataset.user_id;
             user_name = element.dataset.user_name;
            let option = element.dataset.request;
            let request  = element.textContent.split(' ')[0].toLowerCase();
            $('#request-option').text(request);
            $('.u-name').text(" "+user_name);
            $('.input-status').val(option);
            $(`#${modalName}`).modal('show');
        }

        function generateModal(){
          $(`#generate`).modal('show');
        }

        function updatePostion(){
            let position = $("#position").val();
            $('.input-position').val(position);
            $(`#update${user_id}`).submit();
        }

        function deleteUser(){
            $(`#delete${user_id}`).submit();
            
        }

        function addUser(){
          let level = $("#level").val();
          let group = $('#group-name').val();
          $('.user-level').val(level);
          $('.group_name').val(group);
          $(`#add${user_id}`).submit();
        }
    </script>
@endsection