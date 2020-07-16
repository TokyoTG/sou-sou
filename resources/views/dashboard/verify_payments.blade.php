@extends('layout.base')

@section('title')
    <h4>Verify Payments</h4>
@endsection
@section('contents')
  <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Payments to Verify</strong>
                            </div>
                            <div class="card-body">
                                @isset($pay_data)
                                    @if (count($pay_data) > 0)
                                         <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Group Name</th>
                                                    <th>User Name</th>
                                                    <th>User Level</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @foreach ($pay_data as $item)
                                            <tr>
                                            <td>{{$item->group_name}}</td>
                                            <td>{{$item->user_name}}</td>
                                            <td>{{$item->user_level}}</td>
                                            <td>
                                                <div class="btn-group mt-2 mr-1">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                    </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                 <a class="dropdown-item" href="#">View User</a>
                                                    <a 
                                                    class="dropdown-item" href="#" 
                                                    >
                                                    Mark as Verified
                                                    </a>
                                                 </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                    @else
                                       <p>You dont have any payments to verify</p> 
                                    @endif
                                    
                                @endisset
                               
                                        
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>
@endsection

@section('custom_js')
    
@endsection