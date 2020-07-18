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
         Join Wait List <i class="fa fa-plus my-float"></i></button>
       @endif
    @endif
    
@endsection



@section('contents')

@if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
        {{ Session::get('message') }}</p>
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
