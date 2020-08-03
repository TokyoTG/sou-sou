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
                                                <p>{{ isset($user_details['info']->full_name)  ? $user_details['info']->full_name : "Not set" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Email</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ isset($user_details['info']->email) ? $user_details['info']->email : "Not Set" }}</p>
                                            
                                            </div>
                                            <div class="col-md-6">
                                                <label><b>Phone Number</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ isset($user_details['info']->phone_number) ? $user_details['info']->phone_number : "Not Set" }}</p>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-6">
                                                <label><b>No. of Groups</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="badge badge-primary">{{ isset($user_details['info']->groups_in) ? $user_details['info']->groups_in : "Not Set" }}</span>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="groups">
                                    <div class="tile user-settings">
                                       
                                        @isset($user_details['group_info'])
                                            @if (count($user_details['group_info']) > 0)
                                            <h4 class="line-head">User Groups</h4>
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Level</th>
                                                            <th>Task Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($user_details['group_info'] as $group)
                                                        <tr>
                                                            <td>
                                                                {{ isset($group->group_name) ? $group->group_name : "Not Set" }}
                                                                <span class="badge badge-success">{{ isset($group->status) ? $group->status : "Not Set" }}</span>
                                                            </td>
                                                            <td>
                                                                {{ isset($group->user_level) ? $group->user_level : "Not Set" }}
                                                            </td>
                                                            <td>
                                                                {{ isset($group->task_status) ? $group->task_status : "Not Set" }}
                                                            </td>
                                                            <td>
                                                                <div class="btn-group mt-2 mr-1">
                                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="{{route('groups.show',$group->group_id)}}">View Group</a>
                                                                </div>
                                                                </div>
                                                            </td>
                                                        </tr> 
                                                    @endforeach           
                                                    </tbody>
                                                </table>
                                            @else
                                            <h6>The user is not in any group</h6>
                                            @endif
                                            
                                        @endisset
                                    
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