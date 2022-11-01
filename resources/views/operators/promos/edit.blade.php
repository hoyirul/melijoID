@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  <a href="/operator/promo" class="btn btn-primary btn-md float-right"><i class="fa fa-arrow-left mr-1"></i> Back</a>
  <br><br>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
      <form action="/operator/promo/{{ $tables->promo_code }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <div class="col-md-6">
            <label for="">Promo Code : </label>
            <input type="text" readonly name="promo_code" id="promo_code" class="form-control @error('promo_code') is-invalid @enderror" placeholder="Promo Code" value="{{ $tables->promo_code }}">
            @error('promo_code')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="">Promo Title : </label>
            <input type="text" name="promo_title" id="promo_title" class="form-control @error('promo_title') is-invalid @enderror" placeholder="Promo Title" value="{{ $tables->promo_title }}">
            @error('promo_title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="">Promo End : </label>
            <input type="date" name="promo_end" id="promo_end" class="form-control @error('promo_end') is-invalid @enderror" placeholder="Promo End" value="{{ $tables->promo_end }}">
            @error('promo_end')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="">Promo Total : </label>
            <input type="number" name="promo_total" id="promo_total" class="form-control @error('promo_total') is-invalid @enderror" placeholder="Promo Total" value="{{ $tables->promo_total }}">
            @error('promo_total')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-12">
            <label for="">Promo Description : </label>
            <textarea name="promo_description" id="promo_description" name="promo_description" class="form-control @error('promo_description') is-invalid @enderror" placeholder="Promo Description">{{ $tables->promo_description }}</textarea>
            @error('promo_description')
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