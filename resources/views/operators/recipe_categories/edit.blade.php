@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  <a href="/operator/recipe_category" class="btn btn-primary btn-md float-right"><i class="fa fa-arrow-left mr-1"></i> Back</a>
  <br><br>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
      <form action="/operator/recipe_category/{{ $tables->id }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="">Category Name : </label>
          <input type="text" name="recipe_category_name" id="recipe_category_name" class="form-control @error('recipe_category_name') is-invalid @enderror" placeholder="Category Name" value="{{ $tables->recipe_category_name }}">
          @error('recipe_category_name')
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