@extends('layout.base')
@section('custom_css')

@section('title')
    <h1>User Name</h1>
@endsection
@section('newBtn')


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
                      
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <ul class="nav flex-column nav-tabs user-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#user-details" data-toggle="tab">Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="#user-profile" data-toggle="tab">Profile</a></li>
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
                                                <p>{{ isset($user_details['first_name'])  &&  isset($user_details['last_name']) ? $user_details['first_name'] ." ". $user_details['last_name']: "full name" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Email</b></label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ isset($user_details['email']) ? $user_details['email'] : "Email" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b>Status</b></label>
                                            </div>
                                            <div class="col-md-6">
                                               @isset($user_details['is_active'])
                                                    @if (  $user_details['is_active'] )
                                                    Activated
                                                @else
                                                    Not Activated
                                                @endif
                                               @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-profile">
                                    <div class="tile user-settings">
                                        <h4 class="line-head">Profile</h4>
                                        <form method="POST"  action="">
                                            @csrf
                                            <div class="row mb-12">
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="first_name" value="{{ isset($user_details['first_name']) ? $user_details['first_name'] : "Not Set" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="last_name" value="{{ isset($user_details['last_name']) ? $user_details['last_name'] : "Not Set" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Email</label>
                                                            <input class="form-control" type="text" name="email" value="{{ isset($user_details['email']) ? $user_details['email'] : "Not set" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Phone Number</label>
                                                            <input class="form-control" type="text" name="phone_number" value="{{ isset($user_details['phone_number']) ? $user_details['phone_number'] : "not set" }}">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <input type="text" value="profile_update" name="control" hidden>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row mb-12">
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                    
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