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
              <th>Bukti</th>
              <th>Date Order</th>
              <th>Total</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tables as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->txid }}</td>
                <td class="text-center">
                  <a href="{{ asset('storage/'.$item->evidence_of_transfer) }}" class="text-center btn btn-sm btn-info" target="_blank">{{ 'check' }}</a>
                </td>
                <td>{{ $item->header_transaction->date_order }}</td>
                <td>Rp. {{ number_format($item->header_transaction->total) }}</td>
                <td>{{ $item->status }}</td>
                <td class="text-center">
                  <a href="/operator/payment/{{ $item->txid }}/paid" class="text-center btn btn-sm btn-success" onclick="return confirm('Apakah anda yakin?')">{{ 'paid' }}</a>
                  <a href="/operator/payment/{{ $item->txid }}/unpaid" class="text-center btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')">{{ 'unpaid' }}</a>
                  <a href="/operator/payment/{{ $item->txid }}/processing" class="text-center btn btn-sm btn-warning" onclick="return confirm('Apakah anda yakin?')">{{ 'processing' }}</a>
                  <a href="/operator/payment/{{ $item->txid }}/waiting" class="text-center btn btn-sm btn-info" onclick="return confirm('Apakah anda yakin?')">{{ 'waiting' }}</a>
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