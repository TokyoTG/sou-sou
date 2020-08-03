@extends('layout.base')

@section('title')
<title>YBA | Method</title> 
    <h4>Edit Method</h4>
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/mystyle.css')}}">
    <a href="{{route('gift_methods.index')}}" class="btn btn-primary">Back</a>
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
                                <strong class="card-title">{{$method->platform}}</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <div class="col-lg-8">
                                        <form method="POST" action={{route('gift_methods.update', $method->id)}}>
                                            @csrf
                                            @method('PUT')
                                            <div class=" input-group mb-3">
                                                <div class="input-group-prepend">
                                                <label class="input-group-text" name="level" for="level">Chose Platform</label>
                                                </div>
                                                <select class="custom-select" id="options"  name="platform" onchange="showOthers(this)">
                                                <option disabled selected value="">Select One</option>
                                                <option 
                                                        <?php
                                                            if($method->platform == "CashApp"){
                                                                 echo 'selected';
                                                            }
                                                        ?>
                                                        value="CashApp"
                                                >CashApp</option>
                                                <option 
                                                value="Venmo"
                                                <?php
                                                        if($method->platform == "Venmo"){
                                                            echo 'selected';
                                                        }
                                                ?>
                                                >Venmo</option>
                                                <option 
                                                value="Zelle"
                                                <?php
                                                        if($method->platform == "Zelle"){
                                                            echo 'selected';
                                                        }
                                                ?>
                                                >Zelle</option>
                                                <option 
                                                value="others"
                                                <?php
                                                    if($method->platform != "CashApp" && $method->platform != "Zelle" && $method->platform != "Venmo"){
                                                        echo 'selected';
                                                    }
                                                ?>
                                                id="selected-others"
                                                >Others</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="display: none" id="others">
                                                <label for="others" class="control-label mb-1">Platform Name</label>
                                            <input  name="others" type="text" class="form-control" aria-invalid="false" value="{{$method->platform}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Platform Details</label>
                                                <textarea class="form-control" 
                                               
                                                id="exampleFormControlTextarea1" name="details" rows="3">{{$method->details}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea2">Platform Contact Details</label>
                                                <textarea class="form-control" 
                                               
                                                id="exampleFormControlTextarea2" name="contact" rows="3">{{$method->contact}}</textarea>
                                            </div>
                                        <div class="form-group">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                                            </div>
                                        </div>
                                        </form> 
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

<script>

    let options = $('#options');

    if(options.val() ==  'others'){
        $('#others').css('display','block');
    }
    
    
    function showOthers(element){
        let selected = element.value;
        if(selected == 'others'){
            $('#others').css('display','block');
        }else{
            $('#others').css('display','none');
        }
    }
    
</script>


@endsection