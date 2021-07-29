@extends('layouts.app')

@section('content')
<main class="flex-grow-1 mt-5">

    @include('includes.breadcrumb',[
        'breadcrumbs' => [
            [ 'title' => 'الصفحة الرئيسية', 'url' => route('index')],
            [ 'title' => 'الاستشارات الطبية']
        ]
    ])
    <header class="container d-flex justify-content-between flex-wrap">
        <div class="mb-3">
            <h2 class="mb-2">الاستشارات الطبية</h2>
            <small class="text-muted">اقرأ أسئلة وإجابات طبية</small>
        </div>
    </header>
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between flex-wrap align-items-center">
                    <!-- Search form -->
                    @include('includes.search_form',[
                    'search_route' => route('consultations.index'),
                    'all_route' => route('consultations.index'),
                    'all_text' => 'كل الاستشارات'
                    ])
                    <!-- Search form -->
                    <div class="d-flex">
                        <!-- Sort -->
                        <div class="dropdown mb-2">
                            <button class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown">
                                ترتيب الاستشارات
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('consultations.index',
                                    ['orderCol'=>0, 'orderType'=>'asc','answered'=>$answered,
                                     'tags'=>old('tags')]) }}" class="dropdown-item">من الأقدم إلى الأحدث</a></li>
                                <li>
                                    <a href="{{ route('consultations.index',
                                  ['orderCol'=>0, 'orderType'=>'desc','answered'=>$answered, 
                                  'tags'=>old('tags')]) }}" class="dropdown-item">من الأحدث إلى الأقدم</a></li>
                                <li>
                                    <a href="{{ route('consultations.index',
                                  ['orderCol'=>1, 'orderType'=>'asc','answered'=>$answered,
                                   'tags'=>old('tags')]) }}" class="dropdown-item">الأقل مشاهدة</a></li>
                                <li>
                                    <a href="{{ route('consultations.index',
                                    ['orderCol'=>1, 'orderType'=>'desc','answered'=>$answered, 
                                    'tags'=>old('tags')]) }}" class="dropdown-item">الأكثر مشاهدة</a></li>
                            </ul>
                        </div>
                        <!-- Sort -->
                    </div>
                </div>

                <!-- Filters -->
                <form id="formFilter" action="{{ route('consultations.index') }}" method="GET"
                    class="mt-4">
                    <input type="hidden" name="orderCol"
                        value="{{ old('orderCol') !== null?old('orderCol'):0 }}">
                    <input type="hidden" name="orderType"
                        value="{{ old('orderType')!==null?old('orderType'):'desc' }}">
                    @if(isset($selected_tags))
                        @foreach($selected_tags as $tag)
                        <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                        @endforeach
                    @endif
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="answered" id="inlineCheckbox3" value="-1"
                            {{ $answered==-1?'checked':'' }}>
                        <label class="form-check-label" for="inlineCheckbox3">عرض كافة الأسئلة</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox1" name="answered" value="1"
                            {{ $answered==1?'checked':'' }}>
                        <label class="form-check-label" for="inlineCheckbox1">تم الإجابة عليها</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox2" name="answered" value="0"
                            {{ $answered==-0?'checked':'' }}>
                        <label class="form-check-label" for="inlineCheckbox2">لم يتم الإجابة عليها</label>
                    </div>
                </form>
                <!-- Filters -->

                @if(isset($selected_tags) )
                    <button class="btn btn-orange btn-sm p-2 me-2 mt-2 text-white rounded-pill">الكلمات
                        المفتاحية</button>
                    @foreach($selected_tags as $tag)
                        <button
                            class="btn btn-info btn-sm p-2 me-2 mt-2 text-white rounded-pill">{{ $tag->name }}</button>
                    @endforeach
                @endif

            </div>
        </div>
    </div>

    <!-- Consultations -->
    <section class="container">
        <div class="row mt-5">
            <div class="col-lg-8  mb-3">
                @if($consultations->count() ==0)
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <h3 class="">لايوجد استشارات طبية حالياً</h3>
                    </div>
                @else
                    <!-- Consultations -->
                    <?php $i = 0; ?>
                    @foreach($consultations as $consultation)
                        @include("includes.consultations.big_card",
                        ['margin_top' => ($i++ == 0?'':'mt-3') ])
                    @endforeach
                    <!-- Consultations -->
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-5">
                        {{ $consultations->links() }}
                    </div>
                    <!-- Pagination -->
                @endif
            </div>
            <div class="col-lg-4  mb-3">
                <aside>
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h4 class="card-title mb-3">لديك سؤال؟</h4>
                            <small>يمكن الحصول على استشارة طبية مجاناً</small>
                            <a href="{{ route('consultations.create') }}"
                                class="btn btn-outline-info d-block mt-3">اسأل طبيب</a>
                        </div>
                    </div>
                    <!-- Most famous doctors -->
                    @include('includes.famous_doctors', ['famous_title'=> 'أكثر الأطباء تفاعلاً'])
                    <!-- Most famous doctors -->

                    <!-- Doctors register -->
                    @include('includes.ads.doctor_register')
                    <!-- Doctors register -->
                </aside>



            </div>
        </div>
    </section>
    <!-- Posts -->
</main>


@stop

    @section('scripts')
    <script>
        $(document).ready(function () {
            $('input[name=answered').change(function () {
                $("#formFilter").submit();
            });
        });

    </script>
    @include('includes.scripts.search')

    @stop

        @section('styles')
        @include('includes.styles.search')
        @endsection
