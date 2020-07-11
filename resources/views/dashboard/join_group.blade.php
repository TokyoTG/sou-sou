@extends('layout.base')

@section('title')
    <h4>Available Groups</h4>
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
            <div class="card-body">
              <div class="table-responsive">
                @if(Cookie::get('groups_in') !== null && Cookie::get('groups_in') < 4)
                {{-- <====================== START OF ADMIN GROUP TABLE==================> --}}
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
                                  <button type="button" class="btn btn-primary dropdown-toggle"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{route('groups.show', 2)}}">View Group</a>
                                      <a class="dropdown-item" href="#">Join</a>
                                  </div>
                              </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
               @else
                  You cannot join any more group
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