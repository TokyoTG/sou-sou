@extends('layout.base')

@section('title_page')
<title>Sou-Sou | Home </title> 
<link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection

@section('title')
    <h4>Dashboard</h4>
    @if (Cookie::get('role') !== null && Cookie::get('role') == "member")
       @if ($show_button)
            <button class="d-none d-sm-inline-block btn 
     btn-primary shadow-sm" data-toggle="modal" data-target="#myModal">
         Join Wait List</button>
       @endif
    @endif
    
@endsection



@section('contents')

@if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
        {{ Session::get('message') }}</p>
@endif

@if (Cookie::get('role') !== null && Cookie::get('role') == "admin")
    @isset($admin)
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$admin['users']}}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-user fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Groups</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{$admin['groups']}}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Wait List</div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$admin['list']}}</div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    @endisset
@endif

<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-confirm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>You about to join wait list, are sure you want to proceed ?</p>
			</div>
			<div class="modal-footer justify-content-center">
                <form action="{{ route('wait_list.store') }}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" type="submit">Proceed</button>
             </form>
			
			</div>
		</div>
	</div>
</div>
    
@endsection
