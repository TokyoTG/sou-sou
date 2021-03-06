@extends('layout.base')

@include('partials.auth_check')
@section('title')
<title>YBA | Groups </title> 
    @if (is_admin())
       <h4>Groups</h4>   

    @elseif(is_member())
    <h4>My Groups</h4>
    
    @endif
  <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection



@section('newBtn')
@if(is_admin())
 <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
     <i class="fa fa-plus my-float"></i></button>
     
@endif
@endsection
@section('contents')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
    {{ Session::get('message') }}</p>
@endif
  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Groups</h6>
            </div>

            <div class="card-body">
              <div >
                @if(is_admin())
                {{-- <====================== START OF ADMIN GROUP TABLE==================> --}}
                @isset($groups)
                    @if (count($groups) > 0)
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>No. of Members</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                <form action="{{ route('groups.update',$group->id) }}" method="POST" id={{"update".$group->id}}>
                                        @csrf
                                        <input type="hidden" name="group_status" class="input-status">
                                        <input type="hidden" name="group_name" class="input-name">
                                        <input type="hidden" name="request" class="request">
                                        <input name="_method" type="hidden" value="PUT">
                                 </form>
                                 <form action="{{ route('groups.destroy',$group->id) }}" method="POST" id={{"delete".$group->id}}>
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>

                                <form action="{{ route('groups.update',$group->id) }}" method="POST" id={{"split".$group->id}}>
                                    @csrf
                                    <input name="_method" type="hidden" value="PUT">
                                    <input type="hidden" name="request" class="request">
                                </form>
                                <td>{{ isset($group->name) ? $group->name : "Not Set" }}</td>
                                <td>{{ isset($group->members_number) ? $group->members_number : "Not Set" }}</td>
                                <td>{{ isset($group->status) ? $group->status : "Not Set" }}</td>
                                <td>
                                    <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            
                                            <a class="dropdown-item" href="{{route('groups.show', $group->id)}}">View Group</a>


                                            <a class="dropdown-item"
                                            href="#" data-group_id={{$group->id}}
                                            data-group_name ={{$group->name}}
                                            data-request = {{ $group->status == 'open' ? 'closed' : "open" }}
                                            onclick="showModal(this,'close-group')"
                                            >{{ $group->status == 'open' ? 'Close Group' : "Open Group" }}</a>

                                            <a class="dropdown-item" 
                                            href="#" data-group_id={{$group->id}}
                                            data-group_name ={{$group->name}}
                                             onclick="showModal(this,'rename-group')"
                                            >Rename</a>


                                            <a class="dropdown-item" 
                                            href="#" data-group_id={{$group->id}}
                                            data-group_name ={{$group->name}}
                                             onclick="showModal(this,'split-group')"
                                            >Split</a> 
                                             

                                            <a class="dropdown-item" 
                                            href="#" data-group_id={{$group->id}}
                                            data-group_name ={{$group->name}}
                                             onclick="showModal(this,'delete-group')"
                                            >Delete</a>   
                                            
                                            
                                        </div>
                                     </div>
                                    </td>
                                </tr>
                            @endforeach
                    @else
                        No Groups to display
                    @endif
                        </tbody>
                    </table>
                @endisset
                
{{-- 
<--====================== END OF ADMIN GROUP TABLE==================>-> --}}
               @elseif(is_member())
               {{-- <======================USERS GROUP TABLE==================> --}}
               @isset($groups)
                   @if (count($groups) > 0)
                   <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Task Status</th>
                            <th>View Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                        <tr>
                        <td>{{$group->group_name}}</td>
                        <td>{{$group->user_level}}</td>
                        <td>{{$group->task_status}}</td>
                        <td > <a href="{{route('groups.show', $group->group_id)}}"> View <i class="fa fa-eye"></i> </a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                   @else
                       <p>You not in any group yet, join the waiting list please.</p>
                   @endif
               @endisset
               
                     
                
               {{-- <======================USERS GROUP TABLE==================>   --}}
               @endif
           </div>
            </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Create New Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{route('groups.store')}}">
                @csrf
                <div class="form-group">
                    <label for="name" class="control-label mb-1">Group Name</label>
                    <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false">
                </div>
                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Create Group</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div id="delete-group" class="modal fade">
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
				<p>Do you really want to delete <strong class="g-name">GROUP NAME</strong> group? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" onclick="deleteGroup()">Proceed</button>
			</div>
		</div>
	</div>
</div>


<div id="split-group" class="modal fade">
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
				<p>Do you really want to split <strong class="g-name">GROUP NAME</strong> group? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" onclick="splitGroup()">Proceed</button>
			</div>
		</div>
	</div>
</div>



<div id="close-group" class="modal fade">
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
				<p>Do you really want to <span id="request-option"></span> <strong class="g-name">GROUP NAME</strong> group? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" onclick="updateGroup()">Proceed</button>
			</div>
		</div>
	</div>
</div>

<div id="rename-group" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Rename Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new_name" class="control-label mb-1">Enter New name for <span class="g-name"></span></label>
                    <input id="new_name"  type="text" class="form-control" aria-required="true" aria-invalid="false">
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-block"  onclick="renameGroup()">Rename Group</button>
                    </div>
                </div>
             
            </div>
            <div class="modal-footer">
            </div>
  
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>


@endsection

@section('custom_js')
    <script>
        let group_id;
        let group_name;
        function showModal(element,modalName){
             group_id = element.dataset.group_id;
             group_name = element.dataset.group_name;
            let option = element.dataset.request;
            let request  = element.textContent.split(' ')[0].toLowerCase();
            $('#request-option').text(request);
            $('.g-name').text(group_name);
            $('.input-status').val(option);

            $(`#${modalName}`).modal('show');
        }

        function updateGroup(){
            $('.request').val('status');
            $(`#update${group_id}`).submit();
        }

        function splitGroup(){
            $('.request').val('split');
            $(`#update${group_id}`).submit();
        }

        function renameGroup(){
            $('.request').val('rename');
            let new_name = $("#new_name").val();
            $('.input-name').val(new_name);
            $(`#update${group_id}`).submit();
        }

        function deleteGroup(){
            $(`#delete${group_id}`).submit();
            console.log('hi')
        }
    </script>
@endsection