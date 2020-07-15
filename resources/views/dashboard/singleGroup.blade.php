@extends('layout.base')
@section('custom_css')

@section('title')
    <h4>Group Name</h4>
@endsection
@section('newBtn')
<p class="d-none d-sm-inline-block ">Status <span class="badge badge-success">active</span></p> 
<p class="d-none d-sm-inline-block ">No. of Members <span class="badge badge-primary">{{count($members)}}</span></p>
@endsection

@section('contents')
  <div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">          
                    <div class="card-header">
                        <strong class="card-title">Group Members</strong>
                    </div>
                    <div class="card-body">
                    @isset($members)
                        @if(count($members)>0)
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Group Name</th>
                                        <th>Level</th>
                                        <th>User Name</th>
                                        <th>Status</th>
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
                            <td>{{$member->status}}</td>
                                    <td>
                                        <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('users.show', $member->user_id)}}">View User</a>
                                        @if(Cookie::get('role') !== null && Cookie::get('role') == "admin")   
                                        <a class="dropdown-item" href="#">Change Status</a>
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
    </div><!-- .animated -->
</div>
@endsection

@section('custom_js')
    
@endsection