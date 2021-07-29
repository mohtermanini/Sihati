@extends('layouts.app')

@section('content')
<!-- Section create form -->

<section class="d-flex flex-grow-1 justify-content-center align-items-center my-5">
  <div class="card w-50">
		@include('includes.errors')
    <div class="card-header">
      <h3 class="text-center">إضافة قسم</h3>
    </div>
    <div class="card-body">
      <form action="{{ route('postCategories.store') }}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
    	<input type="text" class="form-control box-shadow-none" name="name" placeholder="اسم القسم" 
					autocomplete="off" required>
    	
    	<div class="form-group mt-3">
    		<label for="" class="form-label">صورة القسم</label>
				<img id="ImagePreview" src="" class="w-100 d-none" height="200">
    		<input type="file" id="ImageSelector" name="img" class="form-control box-shadow-none" required>
    	</div>
    	
    	<div class="form-group text-center mt-3">
    		<button type="submit" class="btn btn-outline-success">إضافة</button>
    	</div>
	</form>
   
    </div>
  </div>
</section>

<!-- Section create form -->
@stop

@section('scripts')

@include('includes.scripts.image_preview')

@stop