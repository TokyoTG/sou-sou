@extends('layout.base')
@section('custom_css')


@endsection
@section('title')
<title>YBA | Flower</title> 
<link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
    <h4>Flower Name</h4>
@endsection
@section('newBtn')
<p class="d-none d-sm-inline-block ">Status <span class="badge badge-success">active</span></p> 
<p class="d-none d-sm-inline-block ">No. of Members <span class="badge badge-primary">{{count($members)}}</span></p>
@endsection



@section('contents')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
    {{ Session::get('message') }}</p>
@endif
  <div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">       
                    <div class="card-header">
                        <strong class="card-title">Flower Members</strong>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                    @isset($members)
                        @if(count($members)>0)
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Flower Name</th>
                                        <th>Level</th>
                                        <th>User Name</th>
                                        <th>Task Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            <tbody>
                        @endif

                        @foreach ($members as $member)
                             <tr>
                             <td>{{$member->group_name}}</td>
                             <td>{{$member->user_level}}</td>
                            <td>{{isset($member->user_name) ? $member->user_name : 'Not set' }}</td>
                            
                            <td>{{$member->task_status}}</td>
                                    <td>
                                        <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('users.show', $member->user_id)}}">View User</a>
                                        @if(Cookie::get('role') !== null && Cookie::get('role') == "admin")   
                                        <a class="dropdown-item" href="#"
                                        data-member_id={{$member->id}}
                                     data-member_name ={{$member->user_name}}
                                         onclick="showModal(this,'delete-user')"
                                        >Remove User</a>
                                        <form action="{{ route('group_users.destroy',$member->id) }}" method="POST" id={{"delete".$member->id}}>
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input type="hidden" name="group_name" value={{$member->group_name}}>
                                            <input type="hidden" name="group_id" value={{$member->group_id}}>
                                            <input type="hidden" name="user_id" value={{$member->user_id}}>
                                        </form>
                                        @endif
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                        @endforeach
                    @endisset 
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div>

<div id="delete-user" class="modal fade">
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
				<p>Do you really want to remove <strong class="g-name">GROUP NAME</strong> from flower? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" onclick="deleteGroup()">Proceed</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('custom_js')
    <script>
          let member_id;
        let member_name;
        function showModal(element,modalName){
             member_id = element.dataset.member_id;
             member_name = element.dataset.member_name;
            $('.g-name').text(member_name);
            $(`#${modalName}`).modal('show');
        }


        function deleteGroup(){
            $(`#delete${member_id}`).submit();
            console.log('hi')
        }
    </script>
@endsection