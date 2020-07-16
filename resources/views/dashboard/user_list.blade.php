@extends('layout.base')

@section('title')
    <h4>Wait List</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
@endsection

@section('newBtn')
   @if(Cookie::get('role') !== null && Cookie::get('role') == "admin")
 <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" data-toggle="modal" data-target="#myModal"> New
     <i class="fa fa-plus my-float"></i></button>
@endif
@endsection
@section('contents')

  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Wait List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                {{-- <====================== START OF ADMIN GROUP TABLE==================> --}}
                    @isset($user_list)
                        @if (count($user_list) > 0)
                        @php
                            $counter = 0;

                        @endphp
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Duration on List</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_list as $list)
                                @php
    
                                $now = time(); 
                                $your_date = strtotime($list->created_at);
                                $datediff = round(($now - $your_date) / 86400);   
                                if($datediff < 1){
                                    $datediff = round(($now - $your_date) / 3600);
                                    $join_date = $datediff."Hours ago";
                                    if($datediff > 0){
                                        if($datediff > 1){
                                            $join_date = $datediff." Hours ago";
                                        }else{
                                            $join_date = $datediff." Hour ago";
                                        }
                                    }else{
                                        $datediff = round(($now - $your_date) / 60);
                                       
                                        if($datediff > 1){
                                         $join_date = $datediff." Minutes ago";
                                        }else{
                                            $join_date = $datediff." Minute ago";
                                        }
                                    }
                                  
                                }elseif($datediff >= 2) {
                                      $join_date = $datediff." Days ago";
                                }else{
                                        $join_date = "Yestarday";
                                      }
                                @endphp
                                    <tr>
                                    <td>{{++$counter}}</td>
                                    <td>{{"Joined ".$join_date}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        You are not in the waiting list
                        @endif
                      
                @endisset
    
           </div>
            </div>
</div>


<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-confirm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>You about to join <span ><strong id="g-name">GROUP NAME</strong> Group</span> , are sure you want to proceed ?</p>
			</div>
			<div class="modal-footer justify-content-center">
                <form action="{{ route('wait_list.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="group_id" id="input-group">
                    <input type="hidden" name="group_name" id="input-name">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button  class="btn btn-primary" type="submit">Proceed</button>
             </form>
			
			</div>
		</div>
	</div>
</div>


@endsection

@section('custom_js')
    <script>
        function showModal(element){
            let group_id = element.dataset.group_id;
            let group_name = element.dataset.group_name;
            $('#g-name').text(group_name);
            $('#input-group').val(group_id);
            $('#input-name').val(group_name);
            $('#myModal').modal('show');
        }
    </script>
@endsection