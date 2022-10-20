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
      <form action="/operator/recipe/{{ $tables->id }}" method="post">
        @csrf
        @method('PUT')
        
        <div class="form-group row">
          <div class="col-md-6">
            <label for="recipe_title">Recipe Title : </label>
            <input type="text" name="recipe_title" id="recipe_title" class="form-control @error('recipe_title') is-invalid @enderror" placeholder="Recipe Title" value="{{ $tables->recipe_title }}">
            @error('recipe_title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>  
          
          <div class="col-md-6">
            <label for="recipe_level">Recipe Level : </label>
            <select name="recipe_level" id="recipe_title" class="form-control">
              <option value="mudah" {{ ($tables->recipe_level == 'mudah') ? 'selected' : '' }}>Mudah</option>
              <option value="sedang" {{ ($tables->recipe_level == 'sedang') ? 'selected' : '' }}>Sedang</option>
              <option value="sulit" {{ ($tables->recipe_level == 'sulit') ? 'selected' : '' }}>Sulit</option>
            </select>
            @error('recipe_title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>  
        </div>

        <div class="form-group">
          <label for="step">Step : </label>
          <textarea name="step" id="textareaTiny" class="form-control">{{ $tables->step }}</textarea>
        </div>
        
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-md">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection