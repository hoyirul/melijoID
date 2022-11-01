@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  <a href="/operator/promo/create" class="btn btn-primary btn-md float-right"><i class="fa fa-plus mr-1"></i> Add Data</a>
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
              <th>Promo Code</th>
              <th>Promo Title</th>
              <th>Promo End</th>
              <th>Promo Total</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tables as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->promo_code }}</td>
                <td>{{ $item->promo_title }}</td>
                <td>{{ $item->promo_end }}</td>
                <td>Rp. {{ number_format($item->promo_total) }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                  <form action="/operator/promo/{{ $item->promo_code }}" onsubmit="return confirm('Are you sure to delete data?')" method="post">
                    @csrf
                    @method('DELETE')
  
                    <a href="/operator/promo/{{ $item->promo_code }}/edit" class="btn btn-sm btn-info">
                      <span class="fa fa-fw fa-edit mx-1"></span>
                      Edit
                    </a>
  
                    <button type="submit" class="btn btn-sm btn-danger">
                      <span class="fa fa-fw fa-trash mx-1"></span>
                    Delete
                    </button>
                  </form>
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