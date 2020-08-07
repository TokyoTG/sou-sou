@extends('layout.base')

@section('title')
<title>YBA | Gift Methods </title> 
    <h4>Gift Methods</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection

@section('newBtn')
<button class="d-sm-inline-block btn 
btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
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
                                  
                                   
                                        @isset($platforms)
                                           @if (count($platforms) > 0)
                                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Platform</th>
                                                            <th>Details</th>
                                                            <th>Contact Details</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                    @foreach ($platforms as $item)
                                                    <tr>
                                                        <td>{{$item->platform}}</td>
                                                        <td>{{$item->details}}</td>
                                                        <td>{{$item->contact}}</td>
                                                        <td>
                                                            <div class="btn-group mt-2 mr-1">
                                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="{{route('gift_methods.show',$item->id)}}">View Method</a>
                                                                <a class="dropdown-item" href="{{route('gift_methods.edit',$item->id)}}">Edit Method</a>
                                                                <a 
                                                                class="dropdown-item" 
                                                                href="#"
                                                                data-platform_id={{$item->id}}
                                                                onclick="showDelete(this)"
                                                                >Delete</a>
                                                                <form action="{{ route('gift_methods.destroy',$item->id) }}" method="POST" id={{"platform".$item->id}}>
                                                                    @csrf
                                                                    <input name="_method" type="hidden" value="DELETE">
                                                                </form>
                                                            </div>
                                                        </div>
                                                        </td>
                                                    </tr> 
                                                    @endforeach
                                                </tbody>
                                            </table>
                                           @else
                                               <p>You dont have any gift method, click on the top left button add</p>
                                           @endif 
                                        @endisset
                                        
                                     
                                    
                                   
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>


        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Gift Method</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action={{route('gift_methods.store')}}>
                            @csrf
                            <div class=" input-group mb-3">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" name="level" for="level">Chose Platform</label>
                                </div>
                                <select class="custom-select"  name="platform" onchange="showOthers(this)">
                                  <option disabled selected value="">Select One</option>
                                  <option value="CashApp">CashApp</option>
                                  <option value="Venmo">Venmo</option>
                                  <option value="Zelle">Zelle</option>
                                  <option value="others">Others</option>
                                </select>
                            </div>
                            <div class="form-group" style="display: none" id="others">
                                <label for="others" class="control-label mb-1">Platform Name</label>
                                <input  name="others" type="text" class="form-control" aria-invalid="false">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea2" class="control-label mb-1">Contact Details</label>
                                <textarea class="form-control" id="exampleFormControlTextarea2" name="contact" rows="3"></textarea>
                            </div>
                           
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Platform Details</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="details" rows="3"></textarea>
                              </div>
                        <div class="form-group">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Add Method</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    
        
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>


        
<div id="delete-method" class="modal fade">
	<div class="modal-dialog modal-confirm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
                    <i class="fa fa-times"></i>
				</div>						
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to delete this gift method? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" onclick="deleteMethod()">Proceed</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('custom_js')
    <script>
        let user_id;
        let method_id;
         function showModal(element){
            user_id = element.dataset.user_id;
        $('#myModal').modal('show');
    }

    function submitForm(){
        $(`#tasks${user_id}`).submit();
    }


    function showOthers(element){
        let selected = element.value;
        if(selected == 'others'){
            $('#others').css('display','block');
        }else{
            $('#others').css('display','none');
        }
    }

    function showDelete(element){
        method_id = element.dataset.platform_id;
        $('#delete-method').modal('show');
    }

    function deleteMethod(){
            $(`#platform${method_id}`).submit();
        }
    </script>
@endsection