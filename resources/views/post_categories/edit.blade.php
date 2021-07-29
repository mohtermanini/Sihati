@extends('layouts.app')

@section('content')
<!-- Section create form -->

<section class="d-flex flex-grow-1 justify-content-center align-items-center my-5">
  <div class="card w-50">
    <div class="card-header">
      <h3 class="text-center">تعديل قسم</h3>
    </div>
    <div class="card-body">
      <form id="formUpdate" action="{{ route('postCategories.update', ['postCategory'=>$category->slug]) }}" 
            method="post" enctype="multipart/form-data">
				{{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
          <label for="" class="form-label">اسم القسم</label>
    	<input type="text" class="form-control box-shadow-none" name="name" placeholder="اسم القسم" 
					autocomplete="off" value="{{$category->name}}" required>
        </div>
    	<div class="form-group mt-3">
    		<label for="" class="form-label">صورة القسم</label>
				<img id="ImagePreview" src="{{asset($category->img)}}" class="w-100" height="200">
    		<input type="file" id="ImageSelector" name="img" class="form-control box-shadow-none">
    	</div>
    	
    
	</form>
  <div class="text-center mt-3">
    <a href="{{ route('posts.index',['slug'=>$category->slug]) }}"
        class="btn btn-primary me-2 mb-2 mb-sm-0">الرجوع</a>
  <form id="formDelete" action="{{ route('postCategories.destroy',['postCategory'=>$category->slug])}}"
    method="POST" class="d-inline-block">
    {{csrf_field()}}
    @method('DELETE')
    <button form="formDelete" type="submit" class="btn btn-danger me-2 mb-2 mb-sm-0">حذف</button>
</form>
    <button form="formUpdate" type="submit" class="btn btn-success mb-2 mb-sm-0 ">تعديل</button>
  </div>

  
    </div>
  </div>
</section>

<!-- Section create form -->
@stop

@section('scripts')

@include('includes.scripts.image_preview')

@stop