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
                                    @php
                                        $group_name = $top_user_data['group_name'];
                                        $full_name = $top_user_data['full_name'];
                                        $gift_methods = $top_user_data['gift_methods'];
                                    @endphp
                                   <h5>{{$task->title}}</h5>
                                   <p>Hello  {{ Cookie::get('full_name') }},</p>
                                   <p>In order to keep your fire position you are required to bless the water on the {{$group_name}} flower. The person to send your gift to is {{$full_name}}. Here are the preferred methods of receiving gifts:</p>
                                  @foreach ($gift_methods as $index=>$item)
                                     <p>Platform Name:  <strong>{{$item->platform}}</strong></p>
                                        <li>Platform Details: {{$item->details}}</li>
                                        <li>Platform Contact: {{$item->contact}}</li>
                                        <br>
                                  @endforeach
                                   {{-- <p?>{{$task->message}}</p?> --}}
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