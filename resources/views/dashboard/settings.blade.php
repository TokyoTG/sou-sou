@extends('layout.base')
@section('custom_css')
@if (Cookie::get('role') !== null && Cookie::get('role') == "admin")
    @php
        $user = $data['user'];
        $platform = $data['platform'];
    @endphp
@endif

@php

    $names = explode(' ',$user->full_name);
    $user_id = $user->id;

@endphp


@section('title')
<title>YBA | Settings </title> 
<h4>{{ $user->full_name}}</h4>
@endsection
@section('newBtn')




@endsection

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
                        <strong class="card-title">User Information</strong>
                    </div>
                    <div class="card-body">
                      
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <ul class="nav flex-column nav-tabs user-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#user-details" data-toggle="tab">Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="#user-profile" data-toggle="tab">Profile</a></li>
                                @if (Cookie::get('role') !== null && Cookie::get('role') == "admin")
                                <li class="nav-item"><a class="nav-link" href="#platform" data-toggle="tab">Platform Settings</a></li>
                                @endif
                                <li class="nav-item"><a class="nav-link" href="#reset-password" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="user-details">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Basic Informations</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Fullname</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{$user->full_name}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Email</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{$user->email}}</p>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-6">
                                                <label><b>No. of Groups</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{$user->groups_in}}</p>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-profile">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Profile</h4>
                                    <form method="POST"  action="{{route('users.update',$user_id)}}">
                                            @csrf
                                            <input name="_method" type="hidden" value="PUT">
                                            <input type="hidden" name="request_control" value="profile-update">
                                            <div class="row mb-12">
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="first_name" value="{{ $names[0] }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="last_name" value="{{$names[1]}}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Email</label>
                                                            <input class="form-control" type="text" name="email" value="{{$user->email}}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Phone Number</label>
                                                            <input class="form-control" type="text" name="phone_number" value="{{$user->phone_number}}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="clearfix"></div><br>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row mb-12">
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit"> Save <i class="fa fa-fw fa-lg fa-check-circle"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="reset-password">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Change Password</h4>
                                        <form method="POST"  action="{{route('users.update',$user_id)}}">
                                            @csrf
                                            <input name="_method" type="hidden" value="PUT">
                                            <input type="hidden" name="request_control" value="password-update">
                                            <div class="row mb-12">
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Old Password <i class="fa fa-lock"></i> </label>
                                                            <input class="form-control" type="password" name="old_password" placeholder="Enter old password">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>New Password <i class="fa fa-lock"></i> </label>
                                                            <input class="form-control" type="password" name="password" placeholder="Enter new password">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Confirm Password <i class="fa fa-lock"></i> </label>
                                                            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm new password">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row mb-12">
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit"> Save <i class="fa fa-fw fa-lg fa-check-circle"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                @if (Cookie::get('role') !== null && Cookie::get('role') == "admin")
                                        <div class="tab-pane fade" id="platform">
                                        <div class="tile user-settings">
                                            <h5 class="line-head">Change System Status</h5>
                                            <p>Pause the system from automatically creating new groups</p>
                                            <div class="row">
                                            <form method="post" action="{{route('platform')}}">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                            <input type="hidden" name="platform_id" value="{{$platform->id}}">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" value="0" id="customRadio1" name="platform_status" class="custom-control-input" {{!$platform->status ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customRadio1">{{!$platform->status ? 'Paused' : 'Pause'}}</label>
                                                    <p>
                                                        <small class="muted text">Paused: no new group will be auto created</small>   
                                                    </p>
                                                    
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="custom-control custom-radio">
                                                    <input type="radio" value="1" id="customRadio2" name="platform_status" class="custom-control-input" {{$platform->status ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customRadio2">{{$platform->status ? 'Unpaused' : 'Unpause'}}</label>
                                                    <p>
                                                            <small class="muted text">Not Paused: the system from blocking new group creation</small>
                                                    </p>
                                                    
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row mb-12">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary" type="submit"> Save <i class="fa fa-fw fa-lg fa-check-circle"></i></button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div> 
                                @endif
                                
                                
                            </div>
                        </div>
                    </div>
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