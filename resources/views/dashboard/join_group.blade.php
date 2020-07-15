@extends('layout.base')

@section('title')
    <h4>Available Groups</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection

@section('newBtn')
   @if(Cookie::get('role') !== null && Cookie::get('role') == "admin")
 <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
     <i class="fa fa-plus my-float"></i></button>
@endif
@endsection
@section('contents')

  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Groups</h6>
            </div>
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
                {{ Session::get('message') }}</p>
            @endif
            <div class="card-body">
              <div class="table-responsive">
                @if(Cookie::get('groups_in') !== null && Cookie::get('groups_in') < 4)
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
                                        @if ($group->members_number  <= 14 && $group->status == "open" ) 
                                            <a 
                                            class="dropdown-item" href="#" 
                                            onclick="showModal(this)"
                                            data-group_id={{$group->id}}
                                            data-group_name ={{$group->name}}
                                            >
                                            Join Group
                                            </a>
                                        @endif
                                       
                                            </div>
                                        </div>
                                        </td>
                                    </tr>
                                @endforeach
                        @else
                        You are in 4 groups already,you cannot join any more group.
                        @endif
                        </tbody>
                    </table>
                @endisset
               @else
                  You cannot join any more group
               @endif
    
           </div>
            </div>
</div>


<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-confirm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>You about to join <span ><strong id="g-name">GROUP NAME</strong> Group</span> , are sure you want to proceed ?</p>
			</div>
			<div class="modal-footer justify-content-center">
                <form action="{{ route('wait_list.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="group_id" id="input-group">
                    <input type="hidden" name="group_name" id="input-name">
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
        function showModal(element){
            let group_id = element.dataset.group_id;
            let group_name = element.dataset.group_name;
            $('#g-name').text(group_name);
            $('#input-group').val(group_id);
            $('#input-name').val(group_name);
            $('#myModal').modal('show');
        }
    </script>
@endsection