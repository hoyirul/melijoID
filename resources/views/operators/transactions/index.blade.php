@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
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
              <th>TXID</th>
              <th>Customer Name</th>
              <th>Seller Name</th>
              <th>Date Order</th>
              <th>Total</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tables as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->txid }}</td>
                <td>{{ $item->user_customer->name }}</td>
                <td>{{ $item->user_seller->name }}</td>
                <td>{{ $item->date_order }}</td>
                <td>Rp. {{ number_format($item->total) }}</td>
                <td class="text-center">
                  @if ($item->status == 'canceled')
                    <span class="badge py-1 px-3 badge-default">{{ $item->status }}</span>
                  @else
                    @if ($item->status == 'paid')
                      <span class="badge py-1 px-3 badge-success">{{ $item->status }}</span>
                    @elseif ($item->status == 'unpaid')
                      <span class="badge py-1 px-3 badge-danger">{{ $item->status }}</span>
                    @elseif($item->status == 'processing')
                      <span class="badge py-1 px-3 badge-warning">{{ $item->status }}</span>
                    @else
                      <span class="badge py-1 px-3 badge-info">{{ $item->status }}</span>
                    @endif
                  @endif                  
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