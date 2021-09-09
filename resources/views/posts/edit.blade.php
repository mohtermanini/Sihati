@extends('layouts.app')
@section('content')
  
<section class="d-flex flex-grow-1 justify-content-center align-items-center my-5">
  <div class="card w-75">
    <div class="card-header">
      <h3 class="text-center">تعديل المقالة</h3>
    </div>
    <div class="card-body">
      <form id="formUpdate" action="{{ route('posts.update',['post'=>$post->id]) }}" method="post" 
          enctype="multipart/form-data">
      @csrf
      @method('PUT')
    	<input type="text" class="form-control box-shadow-none" name="title" placeholder="عنوان المقالة" 
           value="{{ $post->title }}" required>
    	<textarea id="summernote" name="content" class="form-control mt-3 box-shadow-none" cols="30" rows="10"
            ></textarea>
    	<div class="form-group w-75 mt-3">
    		<label for="" class="form-label">صورة المقالة</label>
        <img id="ImagePreview" src="{{ asset($post->img) }}" class="w-100" height="200">
    		<input type="file" id="ImageSelector" name="img" class="form-control box-shadow-none">
    	</div>
    	<div class="form-group d-flex align-items-center flex-wrap justify-content-center
             justify-content-sm-start mt-3">
            <label for="" class="flex-shrink-0 me-2 mb-2">اختيار صنف</label>
            <select name="post_category_id" id="" class="form-select form-select-sm w-auto mb-2">
              @foreach($postCategories as $category)
    		          <option value="{{$category->id}}"
                      {{ $post->post_category_id == $category->id?'selected':'' }}>
                      {{$category->name}}</option>
              @endforeach
    	</select>
     	</div>
     	<!-- Writers -->
       @foreach($post->users as $user)
     	 <div id="writers" class="mt-3">
          <div class="d-flex align-items-center">
            <button type="button" class="btn btn-outline-info btn-sm rounded-pill me-2">
                {{ $user->profile->titleFromGender() }}
                {{ $user->profile->first_name }}
                {{ $user->profile->last_name }}
            </button>     		    
          </div>
            @endforeach
   	     </div>
     	<!-- Writers -->
	</form>

  <div class="form-group text-center mt-3">
    <form action="{{ route("posts.destroy",['post'=>$post->id])}}" 
          method="POST" class="d-inline-block me-2">
      @csrf
      @method("DELETE")
      <button type="submit" class="btn btn-danger mb-2 mb-sm-0">حذف المقالة</button>
    </form>
    <button type="submit" form="formUpdate" class="btn btn-success mb-2 mb-sm-0">تعديل المقالة</button>
  </div>

    </div>
  </div>
</section>
@stop

@section('styles')
		<!-- Summernote -->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
	<!-- Summernote -->
@endsection


@section('scripts')

<!-- Summernote -->
<script>
  let summernoteHeight = 600, summernotePlaceHolder ='محتوى المقالة';
  </script>
  @include('includes.scripts.summernote')
  <!-- Summernote -->

  <script>
    $(document).ready(function(){
      $('#summernote').summernote("code",'{!!$post->content!!}');

    });
  </script>
  @include('includes.scripts.image_preview')

  @endsection
