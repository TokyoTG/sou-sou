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
                                   <tbody>
                                        <tr>  
                                    <a href="#" class="notify">
                                        <div>
                                            <div class="medium text-gray-500">Admin</div>
                                            $290.29 has been deposited into your account!
                                            <div class="small text-gray-500">December 7, 2019</div>
                                             </div>
                                            </a>
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