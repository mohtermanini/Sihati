@extends('layouts.app')
@section('content')
<main class="flex-grow-1 mt-5">

  @include('includes.breadcrumb',[
    'breadcrumbs' => [
        [ 'title' => 'الصفحة الرئيسية', 'url' => route('index')],
        [ 'title' =>  $page_header ]
    ]
])
      <header class="container d-flex justify-content-between flex-wrap">
    <div class="mb-3">
          <h2 class="mb-2">{{ $page_header }}</h2>
          <small class="text-muted">تصفح الأخبار والمقالات الطبية</small> </div>
   		 <div>
        @if(isset($postCategory) && Auth::check() &&
         Auth::user()->type_id == Config::get('type_admin_id') )
   		 	<a href="{{ route('postCategories.edit',['postCategory'=>$postCategory->slug]) }}" 
                class="btn btn-outline-warning btn-sm align-self-start me-2 mb-2">تعديل القسم</a> 
        @endif
        @if(Auth::check() && Auth::user()->type_id != Config::get('type_normal_id') )
        <a href="{{ route('posts.create',
                    ['category'=> isset($postCategory)?$postCategory->id:null] ) }}" 
          class="btn btn-outline-info btn-sm align-self-start me-2 mb-2">كتابة مقالة</a> 
        @endif
   		 	<a href="{{ route('index',['#siteSections']) }}"
             class="btn btn-outline-success btn-sm align-self-start mb-2">تصفح كافة الأقسام الطبية</a> 
   		 </div>
    
    </header>
    	<div class="container">
      <div class="row mt-3">
     <div class="col-lg-8">
     <div class="d-sm-flex justify-content-between flex-wrap align-items-center">
      <!-- Search form -->
      
     @include('includes.search_form',[
       'search_route' => route('posts.index',['slug'=> isset($postCategory)?$postCategory->slug:null]),
       'all_route' => route('posts.index',['slug'=> isset($postCategory)?$postCategory->slug:null]),
       'all_text' => 'كل المقالات'
     ])
		   <!-- Search form -->
       
		   <!-- Sort -->
			<div class="dropdown mb-2">
				<button class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown">
					ترتيب المقالات
				</button>
     
				<ul class="dropdown-menu">
					<li><a href="{{ route('posts.index',['slug'=> isset($postCategory)?$postCategory->slug:null, 
                'orderCol'=> 0, 'orderType'=>'asc', 'tags'=>old('tags')]) }}" 
              class="dropdown-item">من الأقدم إلى الأحدث</a></li>
					<li><a href="{{ route('posts.index',['slug'=> isset($postCategory)?$postCategory->slug:null, 
            'orderCol'=> 0, 'orderType'=>'desc', 'tags'=>old('tags')]) }}" class="dropdown-item">من الأحدث إلى الأقدم</a></li>
					<li><a href="{{ route('posts.index',['slug'=> isset($postCategory)?$postCategory->slug:null, 
            'orderCol'=> 1, 'orderType'=>'desc', 'tags'=>old('tags')]) }}" class="dropdown-item">الأكثر مشاهدة</a></li>
					<li><a href="{{ route('posts.index',['slug'=> isset($postCategory)?$postCategory->slug:null, 
            'orderCol'=> 1, 'orderType'=>'asc', 'tags'=>old('tags')]) }}" class="dropdown-item">الأقل مشاهدة</a></li>
				</ul>
			</div>
			<!-- Sort -->
    </div>
    @if(isset($selected_tags) )
        <button class="btn btn-orange btn-sm p-2 me-2 mt-2 text-white rounded-pill">الكلمات المفتاحية</button>
        @foreach($selected_tags as $tag)
            <button class="btn btn-info btn-sm p-2 me-2 mt-2 text-white rounded-pill">{{$tag->name}}</button>
        @endforeach
    @endif
    </div>
    </div>
    </div>
     <!-- Posts -->
     <section class="container">
    <div class="row mt-5">
          <div class="col-lg-8 mb-3"> 
        @if(count($posts)==0)
        <div class="d-flex justify-content-center align-items-center h-100">
          <h3 class="">لايوجد مقالات في هذا القسم حالياً</h3>
        </div>
        @else
        <?php $i = 0; ?>
        @foreach($posts as $post)
        <!-- Posts -->
        <div class="card {{ $i++ == 0?'':'mt-3' }}">
              <div class="card-header">
            <h2 style="font-size:1.1rem;">
              <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug])}}"
                  class="text-dark">{{ $post->title }}</a></h2>
          </div>
  
              <div class="card-body p-0 row justify-content-between">
            <div class="col-12 col-md-8">
                  <div class="p-3"> 
                  <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug])}}"
                       class="text-dark">
                  <small>{{ Str::limit(strip_tags($post->content),130) }}</small>
                  </a>
                  <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <!-- Writers -->
                <div class="dropdown my-3">
                      <button class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown">الكاتبين</button>
                      <ul class="dropdown-menu">
                    @foreach($post->users as $writer)
                    <li><a href="{{ route('users.show',['user'=>$writer->id]) }}" class="dropdown-item">
                          <div class="d-flex align-items-center">
                           <img src="{{ asset($writer->profile->avatar) }}" height="25" width="25" 
                                class="rounded-circle me-1" alt="">
                         <p class="mb-0">
                          {{ $writer->profile->titleFromGender() }} 
                          {{ $writer->profile->first_name }}
                          {{ $writer->profile->last_name }}  
                        </p> 
                      </div>
                          </a></li>
                    @endforeach
                  </ul>
                    </div>
                    <!-- Writers -->
                  <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug])}}"
                     class="btn btn-outline-success btn-sm my-3">قراءة كامل المقالة</a>
                    </div>
                <div class="d-flex align-items-center text-muted ">
                <i class="bi bi-calendar3 me-2"></i>
                <small>{{ \App\Http\Controllers\GeneralController::toArabicDate($post->created_at) }}</small>
                &nbsp;|&nbsp;
                <a href="{{ route('posts.index', ['slug'=>$post->post_category->slug]) }}"
                   class="text-muted"><small>{{ $post->post_category->name }}</small></a>
                &nbsp;|&nbsp;
                <small>{{ $post->views }} مشاهدة</small>
                 </div>
              </div>
                </div>
            <div class="col-md-4 d-none d-md-block"> <img src="{{ asset($post->img) }}" 
              class="w-100 " height="175"> </div>
          </div>
         
            </div>
        <!-- Posts --> 
        @endforeach
       	<!-- Pagination -->
       	<div class="d-flex justify-content-center mt-5">
          {{$posts->links()}}
         </div>
       	<!-- Pagination -->
         @endif
      </div>
       <div class="col-lg-4  mb-3">
        <aside>
        	
            <!-- Most famous doctors -->
            @php 
              $famous_title = 'أكثر الأطباء كتابة للمقالات';
              if(isset($postCategory)) $famous_title .= " عن " . $page_header;
            @endphp
            @include('includes.famous_doctors', ['famous_title'=> $famous_title])
            <!-- Most famous doctors -->
            
            <!-- Doctors register -->
            @include('includes.ads.doctor_register')
            <!-- Doctors register -->
            
              <!-- User register -->
              @if(!Auth::check())
            <div class="card mb-3">
              <div class="card-body text-center">
            <h4 class="card-title mb-3">لديك سؤال وتريد استشارة طبيب؟</h4>
            <small>سجل وأرسل جميع استفساراتك</small> 
            <a href="{{ route('signup') }}"
                 class="btn btn-outline-info d-block mt-3">تسجيل</a> </div>
            </div>
            @endif
            <!-- User register -->
            
        </aside>
            
            
            
      </div>
        </div>
  </section>
   <!-- Posts -->
    </main>

@stop

@section('scripts')
  @include('includes.scripts.search')
@endsection

@section('styles')
  @include('includes.styles.search')
@endsection