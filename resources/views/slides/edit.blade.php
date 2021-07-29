@extends('layouts.app')

@section('content')
<!-- Slides form -->
<section class="d-flex flex-grow-1 justify-content-center align-items-center my-5">
  <div class="card w-50">
		@include('includes.errors')
    <div class="card-header">
      <h3 class="text-center">تعديل الشرائح</h3>
    </div>
    <div class="card-body">
      <form action="{{ route('slides.update') }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method("PUT")
      	<select name="id" id="stSlide" class="form-select">
					@for($i = 1; $i <= $slides->count(); $i++)
      				<option value="{{$i}}">الشريحة {{$i}}</option>
					@endfor
      	</select>
    	<input id="slideTitle" type="text" class="form-control mt-3 box-shadow-none" name="title"
					 placeholder="عنوان الشريحة" autocomplete="off" required>
    	<textarea id="summernote" name="content" class="form-control box-shadow-none"></textarea>
    	<div class="form-group mt-3">
    		<label for="" class="form-label">اختيار صورة</label>
				<img id="ImagePreview" src="" class="w-100" height="200">
    		<input type="file" id="ImageSelector" name="img" class="form-control box-shadow-none">
    	</div>
    	<div class="form-group text-center mt-3">
    		<button type="submit" class="btn btn-outline-success">تعديل الشريحة</button>
    	</div>
	</form>
   
    </div>
  </div>
</section>
<!-- Slides form -->

@stop

@section('styles')
		<!-- Summernote -->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
	<!-- Summernote -->
@endsection

@section('scripts')

<!-- Summernote -->
<script>
let summernoteHeight = 300, summernotePlaceHolder ='محتوى الشريحة';
</script>
@include('includes.scripts.summernote')
<!-- Summernote -->

<script>	
	$(document).ready(function(){
				let appUrl = "{{asset('')}}";
				//loading all slides data
				let slides = [];
				@for($i = 0;$i < $slides->count(); $i++)
					id = parseInt("{{$slides[$i]->id}}");
					slides[id-1] = {
						"title" : "{{$slides[$i]->title}}",
						"content" : '{!! $slides[$i]->content !!}',
						"img" : "{{$slides[$i]->img}}",
					}
				@endfor

				//change slide
				function formChange(ind){
				$("#slideTitle").val(slides[ind].title);
				$('#summernote').summernote("code",slides[ind].content);
				$("#ImagePreview").attr("src", appUrl + slides[ind].img);
			}

			//initial selected Slide
			$("#stSlide").children().eq({{old('id','1')-1}}).attr("selected","selected");
			formChange({{old('id','1')-1}});

			//change slide event
				$("#stSlide").change(function(){
				let ind = $("#stSlide").val()-1;
				formChange(ind);
			});			
	});
</script>
@include('includes.scripts.image_preview')
@stop