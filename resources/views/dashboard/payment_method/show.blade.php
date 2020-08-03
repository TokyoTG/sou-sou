@extends('layout.base')

@section('title')
<title>YBA | Method</title> 
    <h4>Method</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
    <a href="{{route('gift_methods.index')}}" class="btn btn-primary">Back</a>
@endsection


@section('contents')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
    {{ Session::get('message') }}</p>
@endif
  <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{$method->platform}}</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                               
                                   <h5>{{$method->platform}}</h5>
                                   <p> Details: <br> {{$method->details}}</p>
                                    <p>Contact Details: <br> {{$method->contact}}</p>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>
@endsection

@section('custom_js')
   
@endsection