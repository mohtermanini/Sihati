@extends('layouts.app')

@section('content')
<!-- Create Post -->

<section class="d-flex flex-grow-1 justify-content-center align-items-center my-5">
    <div class="card w-75">
        <div class="card-header">
            <h3 class="text-center">اكتب مقالة</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" class="form-control box-shadow-none" name="title" placeholder="عنوان المقالة"
                    autocomplete="off" required>
                <textarea name="content" class="form-control mt-3 box-shadow-none" id="summernote" cols="30"
                    rows="10"></textarea>
                <div class="form-group w-75 mt-3">
                    <label for="" class="form-label">صورة المقالة</label>
                    <img id="ImagePreview" class="w-100" height="200">
                    <input type="file" id="ImageSelector" name="img" class="form-control box-shadow-none">
                </div>
                <div class="form-group d-flex align-items-center flex-wrap mt-3">
                    <label for="" class="flex-shrink-0 me-2 mb-2 mb-sm-0">اختيار صنف</label>
                    <select class="js-example-basic-multiple"  name="post_category_id" required>
                        @foreach($postCategories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $category->id == request()->query('category')? 'selected':'' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Writers -->
                <div class="form-group d-flex align-items-center flex-wrap mt-3">
                    <label for="" class="flex-shrink-0 me-2 mb-2 mb-sm-0">إضافة كاتب</label>
                    <select id="selectWriters" class="js-data-example-ajax" style="min-width: 200px;"
                         name="writers[]" multiple="multiple" >
                    </select>
                </div>
                <div class="mt-4">
                    <p class="d-inline-block fw-bold mb-0">الكاتبين :</p>
                    <ul id="listWriters" class="list-unstyled d-inline-block mb-0">
                        <li id="writer{{Auth::id()}}" class="d-inline-block ms-2 mb-3">
                        <button class="btn btn-outline-info btn-sm rounded-pill">
                            {{ $user->profile->first_name }}
                            {{ $user->profile->last_name }} 
                        </button>
                        </li>
                    </ul>
                </div>
                <!-- Writers -->
                
                <!-- Tags -->
                <div class="form-group d-flex align-items-center flex-wrap mt-3">
                    <label class="flex-shrink-0 me-2 mb-2 mb-sm-0">اختيار كلمة مفتاحية</label>
                    <select id="selectTags" class="js-example-basic-multiple"  name="tags[]" 
                            multiple="multiple">
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">
                            {{ $tag->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div id="divTags" class="mt-4 d-none">
                    <p class="d-inline-block fw-bold mb-0">كلمات مفتاحية :</p>
                    <ul id="listTags" class="list-unstyled d-inline-block mb-0">
                        <li id="copyTag" class="d-inline-block ms-2 mb-3 d-none">
                            <button class="btn btn-outline-info btn-sm rounded-pill"></button>
                        </li>
                    </ul>
                </div>
                <!-- Tags -->

                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-outline-success">نشر المقالة</button>
                </div>
            </form>

        </div>
    </div>
</section>
<!-- Create Post -->

@stop


    @section('styles')
    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Summernote -->
    @include('includes.styles.search')

    @endsection

    @section('scripts')
    <!-- Summernote -->
    <script>
        let summernoteHeight = 600,
            summernotePlaceHolder = 'محتوى المقالة';

    </script>
    @include('includes.scripts.summernote')
    <!-- Summernote -->
    @include('includes.scripts.image_preview')
    @include('includes.scripts.search')
    <script>
    $(document).ready(function(){
        $('#summernote').summernote("code",'{!!old('content')!!}');
        $('.js-data-example-ajax').select2({
            ajax: {
                url: "{{route('profiles.doctors.search')}}",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                    var query = {
                        name: params.term,
                        page: params.page || 1
                    }
                    return query;
                }
            }
        });
        let selectWriters = $("#selectWriters");
        selectWriters.on('select2:select', function (e) {
            let newWriterId = e.params.data.id;
            let newWriter = $("#writer"+{{Auth::id()}}).clone().attr("id","writer"+newWriterId);
            newWriter.children().eq(0).text(e.params.data.text);
            $("#listWriters").append(newWriter);
        });
        selectWriters.on('select2:unselect', function (e) {
            let writerId = e.params.data.id;
            let y = jQuery.inArray(writerId.toString(),selectWriters.val());
            if(y==-1){
                $("#writer"+writerId).remove();
            }
        });

        let selectTags = $("#selectTags");
        selectTags.on('select2:select', function (e) {
            let newTagId = e.params.data.id;
            let newTag = $("#copyTag").clone().attr("id","tag"+newTagId).removeClass("d-none");
            newTag.children().eq(0).text(e.params.data.text);
            $("#listTags").append(newTag);
            $("#divTags").removeClass("d-none");
        });
        selectTags.on('select2:unselect', function (e) {
            let tagId = e.params.data.id;
            let y = jQuery.inArray(tagId.toString(),selectTags.val());
            if(y==-1){
                $("#tag"+tagId).remove();
            }
            if(selectTags.val().length==0){
                
            }
        });

    });
    </script>
    @stop
