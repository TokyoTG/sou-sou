@extends('layout.base')

@section('title')
<title>YBA | Verify Gifts </title> 
<link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
    <h4>Verify Gifts</h4>
@endsection
@section('contents')
  <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Gifts to Verify</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @isset($pay_data)
                                    @if (count($pay_data) > 0)
                                         <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>User Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @foreach ($pay_data as $item)
                                            <tr>
                                            <td>{{$item->user_name}}</td>
                                            <td>{{$item->completed ? "Completed" : "Not Completed"}} <span class="badge badge-{{$item->verified ?"success"  :"secondary" }}">{{$item->verified ? "Verified" : "Not Verified"}}</span></td>
                                       
                                            <td>
                                                <div class="btn-group mt-2 mr-1">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                    </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{route('users.show',$item->user_id)}}">View User</a>
                                                    @if (!$item->verified)
                                                        <a 
                                                        class="dropdown-item" href="#" 
                                                        data-user_id={{$item->id}}
                                                        onclick="showModal(this)"
                                                        >
                                                        Mark as Verified
                                                        </a>  
                                                    @endif
                                                   
                                                 </div>
                                                 <form action="{{ route('tasks.update',$item->id) }}" method="POST" id="tasks{{$item->id}}">
                                                    @csrf
                                                    @method("PUT")
                                                    <input type="hidden" name="user_id" value="{{$item->user_id}}">
                                                    <input type="hidden" name="group_id" value="{{$item->group_id}}">
                                                    <input type="hidden" name="request" value="verification">
                                            </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                    @else
                                       <p>You dont have any gifts to verify</p> 
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
                        <p>You about to confirm this gift <span id="u-name"></span> as verified, are sure you want to proceed ?</p>
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