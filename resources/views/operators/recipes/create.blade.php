@extends('operators.layouts.main')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
  <p class="mb-4 float-left">Opertaor / Master / <span class="text-primary">{{ $title }}</span></p>
  <a href="/operator/recipe" class="btn btn-primary btn-md float-right"><i class="fa fa-arrow-left mr-1"></i> Back</a>
  <br><br>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
      <form action="/operator/recipe" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
          <div class="col-md-6">
            <label for="recipe_title">Recipe Title : </label>
            <input type="text" name="recipe_title" id="recipe_title" class="form-control @error('recipe_title') is-invalid @enderror" placeholder="Recipe Title" value="{{ old('recipe_title') }}">
            @error('recipe_title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>  
          
          <div class="col-md-6">
            <label for="recipe_category_id">Recipe Category : </label>
            <select name="recipe_category_id" id="recipe_category_id" class="form-control">
              @if ($categories->count() > 0)
                @foreach ($categories as $item)
                  <option value="{{ $item->id }}">{{ $item->recipe_category_name }}</option>
                @endforeach
              @else
                <option value="#" disabled selected>No category yet!</option>
              @endif
            </select>
            @error('recipe_title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>  
        </div>

        <div class="form-group row">
          <div class="col-md-12">
            <label for="image">Image : </label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="Recipe Title" value="{{ old('image') }}">
            @error('image')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>  
        </div>

        <div class="form-group">
          <label for="step">Step : </label>
          <textarea name="step" id="textareaTiny" class="form-control"></textarea>
        </div>
        
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-md">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection