@extends('layout.base')
@section('custom_css')
    
@endsection



@section('title')
    <h4>Wait List</h4>
@endsection

@php
    function position_prepare($value){
      $str = strval($value);
      
      if(strlen($str) <= 1 ){
        
        if(gettype(strpos($str, '1')) == 'integer'){
          $res = $str."st";
          return $res;
        }
        if(gettype(strpos($str, '2')) == 'integer'){
          $res = $str."nd";
          return $res;
        }
        if(gettype(strpos($str, '3')) == 'integer'){
          $res = $str.'rd';
          return $res;
        }else{
          $res =$str. 'th';
          return $res;
        }
      }
      if(strlen($str) > 1){
        if(gettype(strpos($str, '1',1)) == 'integer'){
          $res = $str."st";
          return $res;
        }
        if (gettype(strpos($str, '2',1)) == 'integer') {
            $res = $str. "nd";
            return $res;
        }

        if ( gettype(strpos($str, '3',1)) == 'integer') {
            $res = $str.'rd';
            return $res;
        }else{
          $res =$str. 'th';
        }
      }
      return $res;
    }
@endphp
@section('contents')

  <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{count($list) > 0 ? $list[0]->group_name ." Group" : ""}}</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                @isset($list)
                  @if (count($list) > 0)
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Group Name</th>
                        <th>User Name</th>
                        <th>Position</th>
                        <th>Date of Request</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $item)
                        <tr>
                        <td>{{$item->group_name}}</td>
                          <td>{{$item->user_name}}</td>
                          <td>{{ position_prepare($item->position)}}</td>
                        <td>{{$item->created_at}}</td>
                          <td>
                            
                            <div class="btn-group mt-2 mr-1">
                              <button type="button" class="btn btn-primary dropdown-toggle"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="{{route('users.show', $item->user_id)}}">View User</a>
                                  <a class="dropdown-item" href="{{route('groups.show', $item->group_id)}}">Veiw Group</a>
                                  <a class="dropdown-item" href="#" data-group_id={{$item->id}}>Add to Group</a>
                              </div>
                          </div>
                          </td>
                        </tr>
                    @endforeach
                      
                    </tbody>
                  </table>
                  @else
                      
                  @endif
                    
                @endisset
              </div>
            </div>
</div>
            {{-- <div class="animated fadeIn">
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
            </div> --}}
@endsection

@section('custom_js')
    
@endsection