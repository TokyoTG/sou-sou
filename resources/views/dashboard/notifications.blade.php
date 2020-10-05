@extends('layout.base')

@section('title')
<title>YBA | Tasks </title> 
    <h4>Tasks</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
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
                                    @isset($tasks)
                                    @if (count($tasks) > 0)
                                    @php
                                    $count = 0;
                                    @endphp
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Time left</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($tasks as $item)
                                            @php
                                                 $now = time(); 
                                                 $your_date = strtotime($item->created_at);
                                                 $datediff =180 - round(($now - $your_date) / 60);
                                                 if($datediff > 1){
                                                     $display = $datediff." minutes left";
                                                 }else{
                                                    $display = $datediff." minute left";
                                                 }
                                            @endphp
                                                <tr>
                                                <td>{{$item->title}}</td>
                                                <td>{{$item->completed ?  "Task Completed":$display}}</td>
                                                <td>{{$item->completed ? "Completed" : "Not Completed"}} <span class="badge badge-{{$item->verified ?"success"  :"secondary" }}">{{$item->verified ? "Verified" : "Not Verified"}}</span></td>
                                                <td>
                                                    <div class="btn-group mt-2 mr-1">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                        </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('tasks.show',$item->id)}}">View Task</a>
                                                        @if (!$item->completed)
                                                            <a 
                                                            class="dropdown-item" href="#"
                                                            data-user_id={{$item->id}}
                                                            onclick="showModal(this)"
                                                            >
                                                            Mark as Completed
                                                            </a> 
                                                        @endif
                                                      
                                                    </div>
                                                <form action="{{ route('tasks.update',$item->id) }}" method="POST" id="tasks{{$item->id}}">
                                                        @csrf
                                                        @method("PUT")
                                                <input type="hidden" name="time_left" value="{{$datediff}}">
                                                        <input type="hidden" name="request" value="completion">
                                                </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                       <p>You do not have any task yet</p> 
                                    @endif
                                    
                                @endisset
                                   
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
                        <p>You about to gift <span id="u-name"></span> as completed, are sure you want to proceed ?</p>
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