@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  {{-- <a href="/operator/plotting/create" class="btn btn-primary btn-md float-right"><i class="fa fa-plus mr-1"></i> Add Data</a> --}}
  <br><br>
  <!-- DataTales Example -->
  @if(session('success'))
    <div class="alert alert-success">
      {{session('success')}}
    </div>
  @endif
  @if(session('danger'))
    <div class="alert alert-danger">
      {{session('danger')}}
    </div>
  @endif
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="20px">#</th>
              <th>Customer</th>
              <th>Customer Address</th>
              <th>Seller</th>
              <th>Rute Seller</th>
              {{-- <th>Seller Address</th> --}}
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tables as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->user_customer->name }}</td>
                <td>
                  @foreach (\App\Http\Controllers\Operator\PlottingController::get_ward($item->user_customer->user_id) as $row)
                      {{ \App\Http\Controllers\Operator\PlottingController::get_ward_name($row->address->ward) }}
                  @endforeach
                </td>
                <td>
                  {{ ($item->user_seller == null) ? null : $item->user_seller->name }}
                </td>
                <td>
                  @foreach (\App\Http\Controllers\Operator\PlottingController::get_ward(($item->user_seller == null) ? null : $item->user_seller->user_id) as $row)
                      {{ \App\Http\Controllers\Operator\PlottingController::get_ward_name(($row->address == null) ? null : $row->address->ward) }},
                  @endforeach
                </td>
                <td>{{ $item->created_at }}</td>
                <td class="text-center">
                  <a href="/operator/plotting/{{ $item->id }}/edit" class="btn btn-sm btn-primary">
                    <span class="fa fa-fw fa-edit mx-1"></span>
                    Plotting
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection