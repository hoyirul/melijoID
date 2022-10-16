@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  <a href="/operator/operator" class="btn btn-primary btn-md float-right"><i class="fa fa-arrow-left mr-1"></i> Back</a>
  <br><br>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
      <form action="/operator/operator" method="post">
        @csrf
        <div class="form-group row">
          <div class="col-md-6">
            <label for="name">Full Name : </label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ old('name') }}">
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> 
          <div class="col-md-6">
            <label for="email">Email : </label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>          
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="phone">Phone : </label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ old('phone') }}">
            @error('phone')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> 
          <div class="col-md-6">
            <label for="role_id">Role : </label>
            <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror">
              @foreach ($roles as $item)
                <option value="{{ $item->id }}" {{ ($item->id == old('role_id')) ? 'selected' : '' }}>{{ $item->role_name }}</option>
              @endforeach
            </select>
            @error('role_id')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>          
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="password">Password : </label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> 
          <div class="col-md-6">
            <label for="confirmation_password">Confirm Password : </label>
            <input type="password" name="confirmation_password" id="confirmation_password" class="form-control @error('confirmation_password') is-invalid @enderror" placeholder="Confirmation Password">
            @error('confirmation_password')
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