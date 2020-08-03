@extends('layout.base')

@section('title')
<title>YBA | Task</title> 
    <h4>Task</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
<a href="{{route('tasks.index')}}" class="btn btn-primary">Back</a>
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
                                <strong class="card-title">{{$task->title}}</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                               
                                   <h5>{{$task->title}}</h5>
                                   <p>{{$task->message}}</p>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>


        <div id="myModal" class="modal fade">
            <div class="modal-dialog modal-confirm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header flex-column">
                        <h4 class="modal-title w-100">Are you sure?</h4>	
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>You about to mark gifting <span id="u-name"></span> as completed, are sure you want to proceed ?</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button  class="btn btn-primary" onclick="submitForm()">Proceed</button>
                    </div>
                </div>
            </div>
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