@extends('layout.base')
@section('custom_css')

@section('title')
    <h1>Group Name</h1>
@endsection
@section('newBtn')
 <li>Status <span class="badge badge-success">active</span></li>
 <li>No. of Members <span class="badge badge-primary">15</span></li>
@endsection
@section('sidebar')
     <li >
                    <a href="{{route('dashboard.index')}}"><i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Menu</li><!-- /.menu-title -->
                    <li>
                        <a href="{{route('users.index')}}"> <i class="menu-icon fa fa-users"></i>Users</a>
                    </li>
                     <li class="active">
                        <a href="{{route('groups.index')}}"> <i class="menu-icon fa fa-folder"></i>Groups</a>
                    </li>
                     <li>
                        <a href="{{route('dashboard.wait_list')}}"> <i class="menu-icon fa fa-list-alt"></i>Wait List</a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.complaints')}}"> <i class="menu-icon fa fa-list-alt"></i>Complaints</a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.settings')}}"> <i class="menu-icon fa fa-cogs"></i>Settings</a>
                    </li>
@endsection
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
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                     <td>Edinburgh</td>
                                    <td>Edinburgh</td>
                                    <td>
                                        <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route('users.show', 2)}}">View User</a>
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
@endsection

@section('custom_js')
    
@endsection