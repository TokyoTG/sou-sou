@extends('layout.base')
@section('custom_css')

@section('title')
    <h1>User Name</h1>
@endsection
@section('newBtn')
 <li>Status <span class="badge badge-success">active</span></li>
 <li>No. of Groups <span class="badge badge-primary">3</span></li>
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
                        <strong class="card-title">User Information</strong>
                    </div>
                    <div class="card-body">
                      
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div>
@endsection

@section('custom_js')
    
@endsection