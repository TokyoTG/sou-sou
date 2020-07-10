@extends('layout.base')
@section('custom_css')

@section('title')
    <h1>User Name</h1>
@endsection
@section('newBtn')
<p class="d-none d-sm-inline-block ">Status <span class="badge badge-success">active</span></p> 
<p class="d-none d-sm-inline-block ">No. of Groups <span class="badge badge-primary">3</span></p>

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