@extends('admin.user.layout')

@section('content')

@php
    $page_title = "Users | Bioskin";
@endphp

<div class="content-header"></div>

<div class="page-header">
  <h3 class="mt-2" id="page-title">Users</h3>
          <hr>
      </div>

        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
    
                <li>{{$error}}</li>
                    
                @endforeach
            </ul>
        </div>
        @endif
    
        @if(\Session::has('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> </h5>
          {{ \Session::get('success') }}
        </div>

       
        @endif

        

        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><span class='fa fa-plus'></span> Create User</a>

        <div class="w-25 float-right">
            <form action="{{ route('searchUser')}}" method="get">
                <div class="input-group">
                    <input type="text" name="key" class="form-control" placeholder="Search by email or username">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
            </form>
          </div>

        <div class="row w-100">
 
          <div class="col-md-12 col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Username</th>
                                <th>Department</th>
                                <th>Date Registered</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                @php
                                    $customer_name = $item->firstname . " " . $item->middlename   . " " . $item->lastname;
                                    $customer =  "<b>" . $customer_name . "</b><br>";
                                    $customer .= '<a href="mailto: '. $item->email .'" target="_blank"><span>'. $item->email .'</span></a>'; 

                                    $dept = "";
                                    if($item->access_rights == 1) {
                                        $dept = "Sales Admin";
                                    }
                                    elseif($item->access_rights == 2) {
                                        $dept = "Customer";
                                    }
                                    elseif($item->access_rights == 3) {
                                        $dept = "Sales Department";
                                    }
                                    elseif($item->access_rights == 4) {
                                        $dept = "Accounting";
                                    }
                                    elseif($item->access_rights == 5) {
                                        $dept = "Production";
                                    }
                                    elseif($item->access_rights == 6) {
                                        $dept = "Finish Goods";
                                    }
                                    elseif($item->access_rights == 7) {
                                        $dept = "Logistics/Warehousing";
                                    }
                                    elseif($item->access_rights == 8) {
                                        $dept = "CSR";
                                    }
                                    $status = "";
                                    if ( $item->status == 1 ) {
                                        $status = '<span class="badge badge-success">Active</span>';
                                    }
                                    else if ( $item->status == 0 ) {
                                        $status = '<span class="badge badge-danger">Blocked</span>';
                                    }
                                @endphp
                                <tr>
                                    <td>{!! $customer !!}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $dept }}</td>
                                    <td>{{ date('F d, Y h:i A', strtotime($item->created_at)) }}</td>
                                    <td>{!! $status !!}</td>
                                    <td><a class="btn btn-sm" data-id="'. $user->id .'" href="{{ route('users.edit',$item->id) }}"><i class="fa fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $users->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>

        <!-- /.row (main row) -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('admin.user.modals')

@endsection