@extends('layout.base')

@section('title')
    <h4>Complaints</h4>
@endsection
@section('contents')
  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Complaints</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                        </tr>
                                    </tbody>
                                </table>
              </div>
            </div>
</div>
 
@endsection

@section('custom_js')
    
@endsection