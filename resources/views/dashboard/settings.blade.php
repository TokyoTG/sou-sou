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
    <li>
    <a href="{{route('groups.index')}}"> <i class="menu-icon fa fa-folder"></i>Groups</a>
</li>
    <li>
    <a href="{{route('dashboard.wait_list')}}"> <i class="menu-icon fa fa-list-alt"></i>Wait List</a>
</li>
<li>
    <a href="{{route('dashboard.complaints')}}"> <i class="menu-icon fa fa-list-alt"></i>Complaints</a>
</li>
<li class="active">
    <a href="{{route('dashboard.settings')}}"> <i class="menu-icon fa fa-cogs"></i>Settings</a>
</li>
@endsection
@section('contents')

@endsection

@section('custom_js')
    
@endsection