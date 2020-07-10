@extends('layout.base')

@section('title')
    <h4>Notifications</h4>
@endsection
@section('contents')
  <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">All Notifications</strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sender Name</th>
                                            <th>Message</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                             <td>
                                        <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
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
@endsection

@section('custom_js')
    
@endsection