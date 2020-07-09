@extends('layout.base')
@section('custom_css')
  @endsection

@section('sidebar')
<li >
<a href="{{route('dashboard.index')}}"><i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
</li>
<li class="menu-title">Menu</li><!-- /.menu-title -->
<li>
    <a href="{{route('users.index')}}"> <i class="menu-icon fa fa-users"></i>Users</a>
</li>
    <li >
    <a href="{{route('groups.index')}}"> <i class="menu-icon fa fa-folder"></i>Groups</a>
</li>
    <li>
    <a href="{{route('dashboard.wait_list')}}"> <i class="menu-icon fa fa-list-alt"></i>Wait List</a>
</li>
<li class="active">
    <a href="{{route('dashboard.complaints')}}"> <i class="menu-icon fa fa-list-alt"></i>Complaints</a>
</li>
<li>
    <a href="{{route('dashboard.settings')}}"> <i class="menu-icon fa fa-cogs"></i>Settings</a>
</li>
@endsection


@section('title')
    <h1>Complaints</h1>
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
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>$320,800</td>
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