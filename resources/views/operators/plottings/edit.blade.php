@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  <a href="/operator/plotting" class="btn btn-primary btn-md float-right"><i class="fa fa-arrow-left mr-1"></i> Back</a>
  <br><br>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
      <form action="/operator/plotting/{{ $tables->id }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <div class="col-md-6">
            <label for="">User Customer : </label>
            <input type="text" name="user_customer_id" id="user_customer_id" class="form-control @error('user_customer_id') is-invalid @enderror" placeholder="User Customer" value="{{ $tables->user_customer->name }}" readonly>
          </div>
          <div class="col-md-6">
            <label for="">User Seller : </label>
            <select name="user_seller_id" id="user_seller_id" class="form-control @error('category_name') is-invalid @enderror">
              @foreach ($seller as $item)
                <option value="{{ $item->seller_id }}" {{ ($tables->user_seller_id == $item->seller_id) ? 'selected' : '' }}>{{ $item->name }}</option>
              @endforeach
            </select>
            @error('category_name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-md">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection