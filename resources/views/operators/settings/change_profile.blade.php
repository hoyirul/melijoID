@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  <a href="/operator/category" class="btn btn-primary btn-md float-right"><i class="fa fa-arrow-left mr-1"></i> Back</a>
  <br><br>
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
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
      <form action="/operator/update_profile" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group row">
          <div class="col-md-6">
            <label for="email">Email : </label>
            <input type="text" readonly name="email" value="{{ Auth::user()->email }}" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="email">
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="username">Username : </label>
            <input type="text" name="username" readonly id="username" value="{{ Auth::user()->username }}" class="form-control @error('username') is-invalid @enderror" placeholder="Username">
            @error('username')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="name">Full Name : </label>
            <input type="name" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ $tables->name }}">
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="phone">Phone : </label>
            <input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ $tables->phone }}">
            @error('phone')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        
        <div class="form-group">
          <label for="image">Photo Profile : </label>
          <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="image">
          @if (Auth::user()->image == null)
            <span class="text-danger">No profile photo yet!</span>
          @else
            <a href="{{ asset('storage/'.Auth::user()->image) }}" target="_blank">Show</a>
          @endif
          @error('image')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-md">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection