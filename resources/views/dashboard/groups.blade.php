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

@section('title')
    <h1>Groups</h1>
@endsection
@section('newBtn')
    <li><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"> New
     <i class="fa fa-plus my-float"></i></button>
@endsection
@section('contents')


  <div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                                
                    <div class="card-header">
                        <strong class="card-title">All Groups</strong>
                    </div>
                    <div class="card-body">
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
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>
                                        <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{route('groups.show', 2)}}">View Group</a>
                                            <a class="dropdown-item" href="#">Active</a>
                                            <a class="dropdown-item" href="#">Deactivate</a>
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
                <form >
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
@endsection

@section('custom_js')
    
@endsection