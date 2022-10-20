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
      <h6 class="m-0 font-weight-bold text-primary">{{ $recipes->recipe_title }}</h6>
    </div>

    <div class="card-body">

      <form action="/operator/product_recipe" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
          <div class="col-md-5">
            <input type="hidden" name="recipe_id" value="{{ $recipes->id }}">
            <input type="text" name="keyword" id="keyword" value="{{ old('keyword') }}" class="form-control" placeholder="Keyword">
          </div>
          <div class="col-md-5">
            <input type="file" name="image" id="image" value="{{ old('image') }}" class="form-control" placeholder="image">
          </div>

          <div class="col-md-2">
            <button class="btn btn-primary btn-sm btn-block p-2">Submit</button>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="20px">#</th>
              <th>Recipe</th>
              <th>Keyword</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tables as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->recipe->recipe_title }}</td>
                <td>{{ $item->keyword }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                  <form action="/operator/product_recipe/{{ $item->id }}/{{ $recipes->id }}" onsubmit="return confirm('Are you sure to delete data?')" method="post">
                    @csrf
                    @method('DELETE')
  
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