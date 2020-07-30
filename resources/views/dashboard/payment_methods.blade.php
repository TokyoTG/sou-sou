@extends('layout.base')

@section('title')
<title>YBA | Payment Methods </title> 
    <h4>Tasks</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection

@section('newBtn')
<button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
    <i class="fa fa-plus my-float"></i></button>
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
                                <strong class="card-title">All Tasks</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                  
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Platform</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                    
                                   
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>


@endsection

@section('custom_js')
    <script>
        let user_id;
         function showModal(element){
            user_id = element.dataset.user_id;
        // let user_name = element.dataset.user_name;
        // $('#u-name').text(user_name);
        $('#myModal').modal('show');
    }

    function submitForm(){
        $(`#tasks${user_id}`).submit();
    }
    </script>
@endsection